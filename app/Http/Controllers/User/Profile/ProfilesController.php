<?php

namespace App\Http\Controllers\User\Profile;

use Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\User\UserBaseController;

class ProfilesController extends UserBaseController
{
    public function show($user_id)
    {
        $user = $this->getUser($user_id);
        return view('user.profile.show')
        ->with('user', $user);
    }
}
