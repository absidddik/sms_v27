<?php

namespace App\Http\Controllers\Admin\Role;

use App\Models\Admin\UserRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class UserRolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.role.index')
                ->with('roles',UserRole::all());
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
            'name' => 'required|min:2|max:150|unique:user_roles',
        ]);

        $role = new UserRole();
        $role->name = strtolower($request->name);

        if ($role->save()) {
            Session::flash('success', 'User role create successfull.');
        }

        return redirect()->back();
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRole $userRole)
    {
        return view('admin.role.edit')
                ->with('role',$userRole);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserRole $userRole)
    {
        $this->validate($request,[
            'name' => 'required|min:2|max:150|unique:user_roles,name,'.$userRole->id,
        ]);

        $userRole->name = strtolower($request->name);

        if ($userRole->save()) {
            Session::flash('success', 'User role update successfull.');
        }

        return redirect()->route('user-role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\UserRole  $userRole
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRole $userRole)
    {
        if (count($userRole->users)) {
            Session::flash('info', 'This role belongs to some user. You can not delete it.');
            return redirect()->route('user-role.index');
        }

        if ($userRole->delete()) {
            Session::flash('success', 'User role delete successfull.');
        }

        return redirect()->route('user-role.index');
    }
}
