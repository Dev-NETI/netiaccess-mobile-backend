<?php

namespace App\Http\Controllers;

use App\Models\tblcourseschedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($courseId)
    {
        //
        $scheduleData = tblcourseschedule::where('deletedid', 0)
        ->where('courseid',$courseId)
        ->where('cutoffid',0)
        ->where('startdateformat','>', Carbon::now() )//
        ->orderBy('startdateformat','asc')
        ->get();

        return response()->json($scheduleData);
    }

}
