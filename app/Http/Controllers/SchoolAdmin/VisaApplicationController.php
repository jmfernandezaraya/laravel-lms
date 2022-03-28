<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VisaApplicationController extends Controller
{
    public function index()
    {
        return view('schooladmin.visa_application.index');
    }
}