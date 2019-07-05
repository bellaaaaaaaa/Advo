<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Interest;
use DB;

class DashboardController extends Controller{

	protected $path = 'admin.dashboard.';

	public function dashboard(){
		$users = User::all();
		$roles =  array(count( DB::table('users')->where('role', '=', 0)->get()), count( DB::table('users')->where('role', '=', 1)->get()), count( DB::table('users')->where('role', '=', 2)->get() ));
		$interests = Interest::all();
		return view($this->path . 'index', ['users' => $users, 'roles' => $roles, 'interest_obj' => $interests]);
	}
}
