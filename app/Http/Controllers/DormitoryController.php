<?php

namespace App\Http\Controllers;

use App\Models\tbldorm;
use Illuminate\Http\Request;

class DormitoryController extends Controller
{
    public function show($fleetId)
    {
        $allDormData = tbldorm::all();
        $dormData = [];

        foreach ($allDormData as $dorm) {
            if (($fleetId == 10 && $dorm->dormid == 5) || ($fleetId == 10 && $dorm->dormid == 1)) {
                $dormData[] = $dorm;
            } else if ($fleetId != 10) {
                if ($dorm->dormid != 5) {
                    $dormData[] = $dorm;
                }
            }
        }

        return $dormData;
    }
}
