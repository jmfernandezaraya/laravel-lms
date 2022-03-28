<?php

namespace App\Http\Controllers\BranchAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SuperAdmin\School;
use App\Models\User;

class DashboardController extends Controller
{
    //
    function index()
    {
        $school_id = optional(auth('branch_admin')->user()->userSchool)->school_id;

        $data['school_count'] = School::where('id', $school_id)->count() ?? 0;

        $user = User::where('user_type', 'branch_admin')->count();
        $data['super_admin_count'] = $user;

        return view('branchadmin.index', $data);
    }
}