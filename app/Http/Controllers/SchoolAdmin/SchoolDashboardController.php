<?php

namespace App\Http\Controllers\SchoolAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperAdmin\School;
use App\Models\User;

class SchoolDashboardController extends Controller
{
    //
    function index()
    {
        echo "here"; exit();
        $data['school_count'] = School::count();

        $user = User::where('user_type', 'school_admin')->count();
        $data['super_admin_count'] = $user;

        return view('schooladmin.index', $data);
    }
}