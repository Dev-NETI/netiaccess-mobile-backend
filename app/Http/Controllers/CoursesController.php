<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\tblcourses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courseData = tblcourses::with('type')->where('deletedid',0)->get();
        // return CourseResource::collection($courseData);
        return response()->json($courseData);
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $courseData = tblcourses::where('courseid', $id)->first();
        return CourseResource::make($courseData);
    }

    /**
     * Show the form for editing the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
