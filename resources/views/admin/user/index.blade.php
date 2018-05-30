@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>List of Users</h2>
                </div>
                <div class="panel-body">
                    <table class="table datatable">
                        <thead>
                            <th width="10%">Serial No</th>
                            <th width="15%">Name</th>
                            <th width="20%">Email</th>
                            <th width="15%">User Role</th>
                            <th width="20%">Status</th>
                            <th width="16%">Action</th>
                        </thead>
                        <tbody>
                            @if (isset($users) && count($users))
                                @php $sl_no = 1; @endphp
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$sl_no}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->role->name}}</td>
                                        <td>
                                            <label for="">{{$user->isActive()?'Active':'Deactive'}} ({{$user->isAdmin()?'Admin':'Regular'}})</label>
                                            @if (!$user->isVerified())
                                                <p style="color:red">User not verify!</p>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary btn-block dropdown-toggle" type="button" data-toggle="dropdown">Option
                                                    <span class="caret"></span></button>
                                                    <ul class="dropdown-menu">
                                                    <li>
                                                            @if (!$user->isVerified())
                                                            <a href="{{route('user.verifyByAdmin',$user->verification_token)}}" class="btn btn-danger">Verify User</a>
                                                        @endif
                                                    </li>
                                                        <li>
                                                            @if ($user->isActive())
                                                                <a href="{{route('user.deactive',$user->user_id)}}" class="btn btn-success">Deactive User</a>
                                                            @else
                                                                <a href="{{route('user.active',$user->user_id)}}" class="btn btn-danger">Active User</a>
                                                            @endif
                                                        </li>
                                                        <li>
                                                            @if ($user->isAdmin())
                                                                <a href="{{route('user.makeRegular',$user->user_id)}}" class="btn btn-success">Make Reguler User</a>
                                                            @else
                                                                <a href="{{route('user.makeAdmin',$user->user_id)}}" class="btn btn-danger">Make Admin User</a>
                                                            @endif
                                                        </li>
                                                        <li>
                                                            <a href="{{route('users.edit',$user->user_id)}}" class="btn btn-info">Edit User</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            {{Form::open(['route'=>['users.destroy',$user->user_id],'method'=>'delete'])}}
                                                            <input type="submit" name="delete" style="width:100%" class="btn btn-danger"  value="Delete User" onclick="return confirm('Are you sure you want to delete this user?');">
                                                            {{Form::close()}}
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @php $sl_no++ @endphp
                                    @endforeach
                                @else
                                    <p>No data found.</p>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endsection
