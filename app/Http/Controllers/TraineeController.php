<?php

namespace App\Http\Controllers;

use App\Models\refprovince;
use App\Models\tbltraineeaccount;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TraineeController extends Controller
{
    public function checkEmail($email)
    {
        $emailData = tbltraineeaccount::where('email', $email)->first();
        if (!$emailData) {
            return response()->json(false); //email is not yet registered
        }

        return response()->json(true); //email is already registered
    }

    public function checkMobile($dialingCodeId, $mobileNumber)
    {
        $mobileNumberData = tbltraineeaccount::where('dialing_code_id', $dialingCodeId)
            ->where('contact_num', $mobileNumber)
            ->first();

        if (!$mobileNumberData) {
            return response()->json(false); //number is not yet registered
        }

        return response()->json(true); //number is already registered
    }

    public function getTraineeAddressDropdown($traineeId)
    {
        $addressData = tbltraineeaccount::with('prov')->where('traineeid', $traineeId)->first();
        $regData = optional($addressData->reg)->regDesc;
        $provData = refprovince::where('provCode', 'LIKE', '%' . $addressData->provCode . '%')->first();
        $cityData = optional($addressData->city)->citymunDesc;
        $brgyData = optional($addressData->brgy)->brgyDesc;

        if (!$addressData) {
            return response()->json(false);
        }
        return response()->json([
            'region' => $regData,
            'state' => $provData->provDesc,
            'city' => $cityData,
            'brgy' => $brgyData,
        ]);
    }

    public function getTraineeEmployment($traineeId)
    {
        $addressData = tbltraineeaccount::with(['company', 'rank'])->where('traineeid', $traineeId)->first();

        if (!$addressData) {
            return response()->json(false);
        }
        return response()->json($addressData);
    }

    public function getTraineeId($email)
    {
        $traineeId = tbltraineeaccount::where('email', $email)->first();

        if (!$traineeId) {
            return response()->json(false);
        }
        return response()->json($traineeId->traineeid);
    }

    public function store(Request $request)
    {
        if ($request["selectedSwitch"] == 1) {
            // local
            $addressAttribute = [
                'regCode' => $request['region'],
                'provCode' => $request['province'],
                'citynumCode' => $request['city'],
                'brgyCode' => $request['brgy'],
                'street' => $request['street'],
                'postal' => $request['postalCode'],
            ];
            $addressValidationRules = [
                'region' => 'required',
                'province' => 'required',
                'city' => 'required',
                'brgy' => 'required',
                'street' => 'required|min:2|max:100',
                'postalCode' => 'required|numeric',
            ];
        } else {
            // foreign
            $addressAttribute = [
                'address' => $request['fullAddress'],
            ];
            $addressValidationRules = [
                'fullAddress' => 'required|min:2|max:100',
            ];
        }

        $validationRules = [
            'firstname' => 'required|min:2|max:100',
            'middlename' => 'required|min:2|max:100',
            'lastname' => 'required|min:2|max:100',
            'dateOfBirth' => 'required',
            'placeOfBirth' => 'required|min:2|max:100',
            'gender' => 'required',
            'nationality' => 'required',
            'rank' => 'required',
            'company' => 'required',
            'email' => 'required|email|min:2|max:100',
            'dialingCode' => 'required',
            'contactNumber' => 'required|min:2|max:100',
            'password' => [
                'required',
                'string',
                'min:8',             // Minimum length of 8 characters
                'regex:/[a-z]/',     // At least one lowercase letter
                'regex:/[A-Z]/',     // At least one uppercase letter
                'regex:/[0-9]/',     // At least one digit
                'regex:/[@$!%*?&#]/' // At least one special character
            ],
        ];

        $attributes = [
            'f_name' => $request['firstname'],
            'm_name' => $request['middlename'],
            'l_name' => $request['lastname'],
            'suffix' => $request['suffix'],
            'birthday' => $request['dateOfBirth'],
            'birthplace' => $request['placeOfBirth'],
            'genderid' => $request['gender'],
            'nationalityid' => $request['nationality'],
            'rank_id' => $request['rank'],
            'company_id' => $request['company'],
            'email' => $request['email'],
            'dialing_code_id' => $request['dialingCode'],
            'contact_num' => $request['contactNumber'],
            'password' => Hash::make($request->input('confirmPassword'))
        ];

        // $request->validate(array_merge($addressValidationRules, $validationRules));
        try {
            $store = tbltraineeaccount::create(array_merge($attributes, $addressAttribute));

            if (!$store) {
                return response()->json(false, 400);
            }

            return response()->json(true, 201);
        } catch (Exception $e) {
            return response()->json(false, 422);
        }
    }

    public function updateAddress($traineeId, Request $request)
    {
        if ($request["selectedSwitch"] == 1) {
            // local
            $addressAttribute = [
                'regCode' => $request['region'],
                'provCode' => $request['province'],
                'citynumCode' => $request['city'],
                'brgyCode' => $request['brgy'],
                'street' => $request['street'],
                'postal' => $request['postalCode'],
            ];
            $addressValidationRules = [
                'region' => 'required',
                'province' => 'required',
                'city' => 'required',
                'brgy' => 'required',
                'street' => 'required|min:2|max:100',
                'postalCode' => 'required|numeric',
            ];
        } else {
            // foreign
            $addressAttribute = [
                'address' => $request['fullAddress'],
            ];
            $addressValidationRules = [
                'fullAddress' => 'required|min:2|max:100',
            ];
        }

        // $request->validate(addressValidationRules);

        try {
            $traineeData = tbltraineeaccount::where('traineeid', $traineeId)->first();

            if (!$traineeData) {
                return response()->json(false, 400);
            }

            $update = $traineeData->update($addressAttribute);
            if (!$update) {
                return response()->json(false, 400);
            }

            return response()->json(true, 201);
        } catch (Exception $e) {
            return response()->json(false, 422);
        }
    }

    public function updateEmployment($traineeId, Request $request)
    {
        // $request->validate([
        //     'rank' => 'required',
        //     'company' => 'required',
        // ]);

        try {
            $traineeData = tbltraineeaccount::where('traineeid', $traineeId)->first();

            if (!$traineeData) {
                return response()->json(false, 400);
            }

            $update = $traineeData->update([
                'rank_id' => $request['rank'],
                'company_id' => $request['company'],
            ]);
            if (!$update) {
                return response()->json(false, 400);
            }

            return response()->json(true, 201);
        } catch (Exception $e) {
            return response()->json(false, 422);
        }
    }

    public function show($traineeId)
    {
        $traineeData = tbltraineeaccount::where('traineeid', $traineeId)
            ->with(['rank'])
            ->first();

        if (!$traineeData) {
            return response()->json(false, 400);
        }

        return response()->json($traineeData, 200);
    }

    public function updatePassword($traineeId, Request $request)
    {
        $request->validate([
            'confirmPassword' => [
                'required',
                'string',
                'min:8',             // Minimum length of 8 characters
                'regex:/[a-z]/',     // At least one lowercase letter
                'regex:/[A-Z]/',     // At least one uppercase letter
                'regex:/[0-9]/',     // At least one digit
                'regex:/[@$!%*?&#]/' // At least one special character
            ],
        ]);

        $traineeData = tbltraineeaccount::where('traineeid', $traineeId)->first();

        if (!$traineeData) {
            return response()->json(false, 200);
        }

        try {
            $update = $traineeData->update([
                'password' => Hash::make($request->input('confirmPassword'))
            ]);

            if (!$update) {
                return response()->json(false, 200);
            }

            return response()->json(true, 201);
        } catch (Exception $e) {
            return response()->json(false, 200);
        }
    }

    public function updateContact($traineeId, Request $request)
    {
        $request->validate([
            'contactNumber' => 'required',
            'dialingCode' => 'required',
            'email' => 'email|required',
        ]);

        $traineeData = tbltraineeaccount::where('traineeid', $traineeId)->first();

        if (!$traineeData) {
            return response()->json(false, 404);
        }

        try {
            $update = $traineeData->update([
                'email' => $request['email'],
                'dialing_code_id' => $request['dialingCode'],
                'contact_num' => $request['contactNumber'],
            ]);

            if (!$update) {
                return response()->json(false, 400);
            }

            return response()->json(true, 201);
        } catch (Exception $e) {
            return response()->json(false, 422);
        }
    }

    public function update($id, Request $request)
    {
        // $request->validate([
        //     'firstname' => 'required|min:2|max:30',
        //     'middlename' => 'required|min:2|max:30',
        //     'lastname' => 'required|min:2|max:30',
        //     'dateOfBirth' => 'required',
        //     'placeOfBirth' => 'required|min:2|max:500',
        //     'gender' => 'required',
        //     'nationality' => 'required',
        // ]);

        $traineeData = tbltraineeaccount::where('traineeid', $id)->first();

        if (!$traineeData) {
            return response()->json(false, 404);
        }

        try {
            $update = $traineeData->update([
                'f_name' => $request['firstname'],
                'm_name' => $request['middlename'],
                'l_name'  => $request['lastname'],
                'suffix' => $request['suffix'],
                'birthday' => $request['dateOfBirth'],
                'birthplace' => $request['placeOfBirth'],
                'genderid' => $request['gender'],
                'nationalityid' => $request['nationality'],
            ]);

            if (!$update) {
                return response()->json(false, 400);
            }

            return response()->json(true, 201);
        } catch (Exception $e) {

            return response()->json($e, 422);
        }
    }
}
