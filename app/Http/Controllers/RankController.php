<?php

namespace App\Http\Controllers;

use App\Models\tblrank;
use Illuminate\Http\Request;

class RankController extends Controller
{
    public function index()
    {
        return response()->json(tblrank::where('deletedid', 0)->orderBy('rankacronym','asc')->get());
    }
}
