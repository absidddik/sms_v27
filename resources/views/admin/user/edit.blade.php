@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Update User</h4>
                    </div>

                    <div class="panel-body">

                        {{Form::model($user,['route'=>['users.update',$user->user_id],'method'=>'put','class'=>'form-horizontal'])}}
                            @include('includes.errors')

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Name</label>
                                <div class="col-sm-8">
                                    {{Form::text('name',null,['class'=>'form-control'])}}
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-8">
                                    {{Form::text('email',null,['class'=>'form-control'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">User Role</label>
                                <div class="col-sm-8">
                                    {{Form::select('role_id',['' => 'Choose']+$roles,null,['class'=>'form-control'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="pull-right">
                                        {{Form::submit('Update',['class'=>'btn btn-info'])}}
                                    </div>
                                </div>
                            </div>

                        {{Form::close()}}
                    </div>

                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Change Password</h4>
                    </div>

                    <div class="panel-body">

                        {{Form::open(['route'=>['user.changePassword',$user->user_id],'method'=>'put','class'=>'form-horizontal'])}}
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-8">
                                    <p>The password must be at least 6 characters.</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Password</label>
                                <div class="col-sm-8">
                                    {{Form::password('password',['class'=>'form-control'])}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Confirm Password</label>
                                <div class="col-sm-8">
                                    {{Form::password('password_confirmation',['class'=>'form-control'])}}
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-sm-3 control-label"></label>
                                <div class="col-sm-8">
                                    <div class="pull-right">
                                        {{Form::submit('Change',['class'=>'btn btn-info'])}}
                                    </div>
                                </div>
                            </div>

                        {{Form::close()}}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
