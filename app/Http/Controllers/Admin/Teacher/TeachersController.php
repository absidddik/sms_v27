<?php

namespace App\Http\Controllers\Admin\Teacher;

use App\Models\Admin\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeachersController extends Controller
{
    public function index()
    {
        $teacher_role = UserRole::where('name','teacher')->first();
        return view('admin.teacher.index')
                ->with('teachers',$teacher_role->users);
    }
}
