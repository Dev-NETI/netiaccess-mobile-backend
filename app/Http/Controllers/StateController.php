<?php

namespace App\Http\Controllers;

use App\Models\refprovince;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function show($regCode)
    {
        return response()->json(refprovince::where('regCode',$regCode)->orderBy('provDesc','asc')->get());
    }
}
