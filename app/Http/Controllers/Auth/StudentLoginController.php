<?php

namespace App\Http\Controllers\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class StudentLoginController extends Controller
{
    use AuthenticatesUsers;
    
	public function __construct()
	{
		$this->middleware('guest:student');
	}

    public function showLoginForm()
    {
    	return view('auth.stu_login');
    }

    public function login(Request $request)
    {
    	// validation form data

    	$this->validate($request,[
			'email'    => 'required|email',
			'password' => 'required|min:6',
    	]);

    	// attempt to log student in
    	if (Auth::guard('student')->attempt(['email'=>$request->email,'password'=>$request->password],$request->remember)) {
    		return redirect()->intended(route('student.dash'));
    	}

    	return $this->sendFailedLoginResponse($request);
    }
}
