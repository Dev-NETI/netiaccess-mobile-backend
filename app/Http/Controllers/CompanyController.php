<?php

namespace App\Http\Controllers;

use App\Models\tblcompany;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(tblcompany::where('deletedid', 0)->orderBy('company','asc')->get());
    }
}
