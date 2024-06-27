<?php

namespace App\Http\Controllers;

use App\Models\tblrank;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getRank($rankId)
    {
        try {
            $rankData = tblrank::with(['ranklevel', 'rankdepartment'])->where('rankid', $rankId)->first();

            if (!$rankData) {
                return response()->json(false, 400);
            }
            return response()->json($rankData, 200);
        } catch (Exception $e) {
            return response()->json($e, 400);
        }
    }
}
