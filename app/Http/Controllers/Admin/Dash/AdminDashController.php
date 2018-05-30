<?php

namespace App\Http\Controllers\Admin\Dash;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashController extends Controller
{
    public function dash()
    {
        return view('admin.dash.index');
    }
}
