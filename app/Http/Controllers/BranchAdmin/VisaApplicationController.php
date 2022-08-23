<?php

namespace App\Http\Controllers\BranchAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class VisaApplicationController extends Controller
{
    public function index()
    {
        return view('branchadmin.visa_application.index');
    }
}