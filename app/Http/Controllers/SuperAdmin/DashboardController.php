<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\SuperAdmin\School;
use App\Models\User;

class DashboardController extends Controller
{
	function index() {
		$data['users'] = User::where('user_type', 'user')->count();
		$data['school_admins'] = User::where('user_type', 'school_admin')->count();
		$data['super_admins'] = User::where('user_type', 'super_admin')->count();
		$data['branch_admins'] = User::where('user_type', 'branch_admin')->count();

		$data['schools'] = School::count();

		return view('superadmin.index', $data);
	}
}