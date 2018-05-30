<?php

namespace App\Http\Controllers\Admin\User;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Models\Admin\UserRole;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminUsersController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.user.index')
                ->with('users', User::all());
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('admin.user.create')
                ->with('roles', UserRole::pluck('name','id')->all());
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'     => 'required|min:2|max:100',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:50|confirmed',
            'role_id'  => 'required|numeric',
        ],[
            'role_id.required' => 'The user role field is required.'
        ]);

        $input = $request->all();

        $input['user_id']            = User::generateUserId();
        $input['password']           = bcrypt($request->password);
        $input['verified']           = User::UNVERIFIED_USER;
        $input['verification_token'] = User::generateVerificationToken();

        if (User::create($input)) {
            Session::flash('success','User create successfull');
        }

        return redirect()->back();
    }


    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $user = User::where('user_id',$id)->first();
        return view('admin.user.edit')
                ->with('user', $user)
                ->with('roles', UserRole::pluck('name','id')->all());
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $user_id)
    {
        $user = User::where('user_id',$user_id)->first();
        $this->validate($request,[
            'name'    => 'required|min:2|max:100',
            'email'   => 'required|email|max:255|unique:users,email,'.$user->user_id.',user_id',
            'role_id' => 'required|numeric',
        ],[
            'role_id.required' => 'The user role field is required.'
        ]);

        if ($request->has('name')) {
            if ($request->name != $user->name) {
                $user->name = $request->name;
            }
        }

        if ($request->has('email')) {
            if ($request->email != $user->email) {
                $user->email = $request->email;
                $user->verified = User::UNVERIFIED_USER;
                $user->verification_token = User::generateVerificationToken();
                $user->is_active = User::INACTIVE_USER;
            }
        }

        if ($request->has('role_id')) {
            if ($request->role_id != $user->role_id) {
                $user->role_id = $request->role_id;
            }
        }

        if ($user->isClean()) {
            Session::flash('info', 'You need to change information for update.');
            return redirect()->back();
        }else{
            $user->save();
            Session::flash('success', 'User update successfull.');
        }
        return redirect()->route('users.index');
    }


    public function changePassword(Request $request, $user_id)
    {
        $user = User::where('user_id',$user_id)->first();

        $validator = Validator::make($request->all(),[
            'password' => 'required|min:6|max:50|confirmed',
        ]);

        if ($validator->fails()) {
            Session::flash('info',$validator->errors()->all()[0]);
            return redirect()->back();
        }else {
            $user->password = bcrypt($request->password);
            $user->save();
            Session::flash('success', 'Password change successfull.');
        }

        return redirect()->route('users.index');
    }
    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\User  $user
    * @return \Illuminate\Http\Response
    */
    public function destroy($user_id)
    {
        $user = User::where('user_id',$user_id)->first();
        $user->delete();
        Session::flash('success','User delete successfull.');
        return redirect()->back();
    }

    public function verifyByAdmin($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified           = User::VERIFIED_USER;
        $user->verification_token = null;
        $user->is_active          = User::ACTIVE_USER;
        $user->save();

        Session::flash('success','User verify successfull');
        return redirect()->back();
    }

    public function makeAdmin($user_id)
    {
        $user = User::where('user_id',$user_id)->first();
        //.........user need to be verify before make admin
        if (!$user->isVerified()) {
            Session::flash('info','User not verified!');
            return redirect()->back();
        }

        $user->is_admin = User::ADMIN_USER;
        $user->save();

        Session::flash('success','This user now a admin user.');
        return redirect()->back();
    }

    public function makeRegular($user_id)
    {
        $user = User::where('user_id',$user_id)->first();

        $user->is_admin = User::REGULAR_USER;
        $user->save();

        Session::flash('success','This user now a reguler user');
        return redirect()->back();
    }

    public function active($user_id)
    {
        $user = User::where('user_id',$user_id)->first();
        //.........user need to be verify before make admin
        if (!$user->isVerified()) {
            Session::flash('info','User not verified!');
            return redirect()->back();
        }

        $user->is_active = User::ACTIVE_USER;
        $user->save();

        Session::flash('success','User active successfull');
        return redirect()->back();
    }

    public function deactive($user_id)
    {
        $user = User::where('user_id',$user_id)->first();

        $user->is_active = User::INACTIVE_USER;
        $user->save();

        Session::flash('success','User deactive successfull');
        return redirect()->back();
    }

    public function login()
    {
        return view('admin.auth.login');
    }

}
