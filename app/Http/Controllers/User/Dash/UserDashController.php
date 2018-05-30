<?php

namespace App\Http\Controllers\User\Dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDashController extends Controller
{
    public function dash()
    {
        return view('user.dash.index');
    }
}
