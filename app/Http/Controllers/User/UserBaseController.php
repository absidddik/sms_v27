<?php

namespace App\Http\Controllers\User;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserBaseController extends Controller
{
    protected function getUser($user_id)
    {
        //.........check user admin or others
        $user = '';
        if (Auth::user()->isAdmin()) {
            $user = User::where('user_id', $user_id)->first();
        }else{
            $user = User::where('user_id', Auth::user()->user_id)->first();
        }

        return $user;
    }
}
