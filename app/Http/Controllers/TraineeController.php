<?php

namespace App\Http\Controllers;

use App\Models\tbltraineeaccount;
use Illuminate\Http\Request;

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
}
