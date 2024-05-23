<?php

namespace App\Http\Controllers;

use App\Models\DialingCode;
use Illuminate\Http\Request;

class DialingCodeController extends Controller
{
    public function index()
    {
        return response()->json(DialingCode::orderBy('country_code','asc')->get());
    }
}
