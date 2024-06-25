<?php

namespace App\Http\Controllers;

use App\Models\tblnationality;
use Illuminate\Http\Request;

class NationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nationalityData = tblnationality::where('deletedid', 0)->orderBy('nationality', 'asc')->get();
        return response()->json($nationalityData);
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
        $nationalityData = tblnationality::where('nationalityid', $id)->first();
        if (!$nationalityData) {
            return response()->json(false, 404);
        }

        return response()->json($nationalityData, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(tblnationality $tblnationality)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, tblnationality $tblnationality)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(tblnationality $tblnationality)
    // {
    //     //
    // }
}
