<?php

namespace App\Http\Controllers;

use App\Models\refcitymun;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function show($provCode)
    {
        return response()->json(refcitymun::where('provCode', $provCode)->orderBy('citymunDesc','asc')->get());
    }
}
