<?php

namespace App\Http\Controllers\User\Account;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\User\UserBaseController;

class AccountsController extends UserBaseController
{
    public function setting($user_id)
    {
        return view('user.account.setting')
        ->with('user', $this->getUser($user_id));
    }

    public function update(Request $request, $user_id)
    {
        $user = $this->getUser($user_id);
        $this->validate($request,[
            'name'    => 'required|min:2|max:100',
            'email'   => 'required|email|max:255|unique:users,email,'.$user->user_id.',user_id',
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


        if ($user->isClean()) {
            Session::flash('info', 'You need to change information for update.');
            return redirect()->back();
        }else{
            $user->save();
            Session::flash('success', 'Account update successfull.');
        }
        return redirect()->route('profile.show',$user->user_id);
    }


    public function changePassword(Request $request, $user_id)
    {
        $user = $this->getUser($user_id);

        $validator = Validator::make($request->all(),[
            'old_password' => 'required|min:6|max:50',
            'password' => 'required|min:6|max:50|confirmed',
        ]);

        if ($validator->fails()) {
            Session::flash('info',$validator->errors()->all()[0]);
            return redirect()->back();
        }else {
            $old_password = $request->old_password;
            $new_password = $request->password;

            if (!Hash::check($old_password,$user->password)) {
                Session::flash('info', 'Your old password does not match.');
                return redirect()->back();
            }else{
                $user->password = bcrypt($new_password);
                $user->save();
                Session::flash('success', 'Password change successfull.');
                //...........logout user after password change
                Auth::logout();
                return redirect('login');
            }
        }

        return redirect()->route('profile.show',$user->user_id);
    }

}
