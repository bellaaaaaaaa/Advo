<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\User;
use Auth;
use App\Services\AwsService;

class AuthController extends Controller{
	protected $awsService;
	public function __construct(AwsService $awsService){ // Make service accessible in controller
			$this->awsService = $awsService;
	}

	public function viewRegister(){
    return view('admin.auth.register');
  }

  public function register(Request $request){
	  $this->validate($request, [
	    "email" => "required|email|unique:users",
	    "name" => "required",
	    "password" => "required|confirmed"
	  ]);

		$user = User::create($request->all());
		$user->password = password_hash($request->password, PASSWORD_BCRYPT);
		$user->save();
		$this->awsService->uploadFile($request, $user, 'avatar', 'Users/Profiles/');
		Auth::login($user);

	  return redirect()->route('dashboard');
	}

	public function viewLogin(){
	  return view('admin.auth.login');
	}

	public function login(Request $request){
	  $this->validate($request, [
	    "email" => "required|email",
	    "password" => "required"
		]);
		
	  if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
	    return redirect()->route('dashboard');
	  }else{
	    return redirect()->back()->withErrors(['message' => 'Email or password is incorrect']);
	  }
	}

	public function logout(){
	  Auth::logout();

	  return redirect()->route('admin.login.show');
	}







}
