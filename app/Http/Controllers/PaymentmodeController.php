<?php

namespace App\Http\Controllers;

use App\Models\tblcourses;
use App\Models\tblpaymentmode;
use Illuminate\Http\Request;

class PaymentmodeController extends Controller
{
    public function show($courseId, $fleetId)
    {
        $courseData = tblcourses::select('coursetypeid')->where('courseid', $courseId)->first();
        $query = tblpaymentmode::query();

        if ($courseData->coursetypeid == 3 || $courseData->coursetypeid == 4 || $courseData->coursetypeid == 8) {
            $paymentModeData = $query->where('paymentmodeid', 1)->get();
        } else if ($fleetId == 10 || $fleetId == 13) {
            $paymentModeData = $query->where('paymentmodeid', 4)->orWhere('paymentmodeid', 2)->get();
        } else if ($fleetId == 17 || $fleetId == 18 || $fleetId == 19) {
            $paymentModeData = $query->where('paymentmodeid', 2)->orWhere('paymentmodeid', 3)->get();
        } else {
            $paymentModeData = $query->where('paymentmodeid', 2)->get();
        }

        return response()->json($paymentModeData);
        // return $courseData->coursetypeid;
    }
}
