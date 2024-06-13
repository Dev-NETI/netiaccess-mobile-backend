<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnrollmentRequest;
use App\Models\tblatdmealprice;
use App\Models\tblcourses;
use App\Models\tblcourseschedule;
use App\Models\tbldorm;
use App\Models\tblenroled;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $scheduleData = tblcourseschedule::find($request['scheduleId']);
        $courseData = tblcourses::find($request['course']);
        $trainingFee = $courseData->trainingfee;
        $transporationAttributes = [];
        $packageAttributes = [];
        $attributes = [
            'registrationcode' => $request['registrationNumber'],
            'scheduleid' => $request['scheduleId'],
            'courseid' => $request['course'],
            'traineeid' => $request['traineeId'],
            'paymentmodeid' => $request['paymentModeId'],
            'dormid' => $request['isChecked'] == false ? 1 : $request['dormId'],
            'fleetid' => $request['fleetId'],
            'dateconfirmed' => Carbon::now('Asia/Manila'),
            'enrolledby' => $request['traineeName'],
        ];


        if ($scheduleData->startdateformat && $request['busModeId'] == 2 && $courseData->coursetypeid != 1) {
            $trainingFee = $courseData->atdpackage3;
            $packageAttributes['t_fee_price'] = $trainingFee;
            $packageAttributes['t_fee_package'] = 3;
        } elseif ($scheduleData->startdateformat && $request['busModeId'] == 1 && $courseData->coursetypeid != 1) {
            $trainingFee = $courseData->atdpackage2;
            $packageAttributes['t_fee_price'] = $trainingFee;
            $packageAttributes['t_fee_package'] = 2;
        } elseif ($scheduleData->startdateformat && $request['busModeId'] == 1 && $courseData->coursetypeid == 1) {
            $trainingFee = $courseData->atdpackage2;
            $packageAttributes['t_fee_price'] = $trainingFee;
            $packageAttributes['t_fee_package'] = 2;
        } elseif ($scheduleData->startdateformat) {
            $trainingFee = $courseData->atdpackage1;
            $packageAttributes['t_fee_price'] = $trainingFee;
            $packageAttributes['t_fee_package'] = 1;
        } else {
            $trainingFee = 0;
            $packageAttributes['t_fee_price'] = $trainingFee;
        }

        if ($request['isChecked'] == true) {
            if ($request['dormId'] != 1) {
                $roomStart =  $scheduleData->dateonsitefrom;
                $roomEnd =  $scheduleData->dateonsiteto;

                $checkin = Carbon::parse($roomStart);
                $checkout = Carbon::parse($roomEnd);
                $duration = $checkin->diffInDays($checkout) + 1;
                $dormPrice = tbldorm::find($request['dormId']);
                //total price for dorm
                $dormName = tbldorm::find($request['dormId']);
                if ($request['paymentModeId'] != 1) {
                    $totalDormPrice = $dormPrice->atddormprice * $duration;
                    //gett the meal price
                    $mealPrice = tblatdmealprice::find(1)->atdmealprice * $duration;
                } else {
                    $totalDormPrice = 0;
                    $mealPrice = 0;
                }
            } else {
                $mealPrice = 0;
                $totalDormPrice = 0;
                $selectedDorm = null;
                $roomStart = null;
                $roomEnd =  null;
            }
        } else {
            $mealPrice = 0;
            $totalDormPrice = 0;
            $selectedDorm = null;
        }

        if ($request['isChecked'] == true) {
            $dormAttributes = [];

            if ($request['dormId'] != 1) {
                $dormAttributes['checkindate'] = $request['checkInDate'];
                $dormAttributes['checkoutdate'] = $request['checkOutDate'];
            } else {
                $dormAttributes['checkindate'] = null;
                $dormAttributes['checkoutdate'] = null;
            }

            //getting duration of date
            $checkin = Carbon::parse($request['checkInDate']);
            $checkout = Carbon::parse($request['checkOutDate']);
            $dormAttributes['duration'] = $checkin->diffInDays($checkout) + 1;

            $dorm_price = tbldorm::find($request['dormId']);

            // Check if $dorm_price is not null before accessing its properties
            if ($dorm_price) {
                //total price for dorm
                $total_price_dorm = $dorm_price->atddormprice * ($checkin->diffInDays($checkout) + 1);
                $dormAttributes['dorm_price'] = $total_price_dorm;
            }

            $total_meal = tblatdmealprice::find(1)->atdmealprice * ($checkin->diffInDays($checkout) + 1);
            //gett the meal price
            $dormAttributes['meal_price'] = $total_meal;
        } else {
            $dormAttributes = [
                'checkindate' => null,
                'checkoutdate' => null,
            ];
        }

        if ($request['busModeId'] != 0) {
            $transporationAttributes['busid'] = 1;
            $transporationAttributes['busmodeid'] = $request['busModeId'];
        } else {
            $transporationAttributes['busid'] = 0;
            $transporationAttributes['busmodeid'] = 0;
        }

        $total = $totalDormPrice + $trainingFee + $mealPrice;
        $packageAttributes['total'] = $total;

        $mergedAttributes = array_merge($attributes, $dormAttributes, $transporationAttributes, $packageAttributes);
        // return response()->json($mergedAttributes);

        try {
            $model = new tblenroled();
            $store = $model->bypassBoot()->fill($mergedAttributes)->save();

            if (!$store) {
                return response()->json(false, 400);
            }

            return response()->json(true, 201);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($traineeId)
    {
        $enrollmentData = tblenroled::where('traineeid', $traineeId)
            ->with(['course', 'schedule'])->get();

        if (!(count($enrollmentData) > 0)) {
            return response()->json(NULL, 404);
        }

        return response()->json($enrollmentData, 200);
    }

    public function checkExistingEnrollment($courseId, $traineeId)
    {
        $enrollmentData = tblenroled::where('courseid', $courseId)
            ->where('traineeid', $traineeId)->first();

        if (!$enrollmentData) {
            return response()->json(false);
        }
        return response()->json(true);
    }

    public function getLatestEnrollment($traineeId)
    {
        $latestEnrollmentData = tblenroled::where('traineeid', $traineeId)
            ->with(['schedule','dorm'])
            ->first();

        return response()->json($latestEnrollmentData, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
