<?php

namespace App\Http\Controllers;

use App\Models\refbrgy;
use Illuminate\Http\Request;

class BrgyController extends Controller
{
    public function show($citymunCode)
    {
        return response()->json(refbrgy::where('citymunCode',$citymunCode)->orderBy('brgyDesc','asc')->get());
    }
}
