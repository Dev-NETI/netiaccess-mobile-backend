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
        $courseData = tblcourses::with(['type', 'mode'])->where('deletedid', 0)->get();
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
    public function show($searchInput)
    {
        $courseData = tblcourses::with(['type', 'mode'])->where(function ($query) use ($searchInput) {
            $query->where('coursecode', 'LIKE', '%' . $searchInput . '%')
                ->orWhere('coursename', 'LIKE', '%' . $searchInput . '%');
        })->get();

        return response()->json($courseData);
    }

    public function showCourse($courseId)
    {
        $courseData = tblcourses::where('courseid', $courseId)->first();

        return response()->json($courseData);
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
