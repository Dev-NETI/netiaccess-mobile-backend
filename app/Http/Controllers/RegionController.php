<?php

namespace App\Http\Controllers;

use App\Models\refregion;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        return response()->json(refregion::all());
    }
}
