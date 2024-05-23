<?php

namespace App\Http\Controllers;

use App\Models\tblgender;
use Illuminate\Http\Request;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genderData = tblgender::orderBy('genderid','asc')->get();
        return response()->json($genderData);
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(tblgender $tblgender)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, tblgender $tblgender)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tblgender $tblgender)
    {
        //
    }
}
