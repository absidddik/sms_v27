@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2>Create User</h2>
                </div>

                <div class="panel-body">
                    {{-- some change need
                    must be set form action
                    --}}

                    {{Form::open(['route'=>'users.store','method'=>'post','class'=>'form-horizontal'])}}
                        @include('includes.errors')

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-6">
                                {{Form::text('name',null,['class'=>'form-control'])}}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email</label>
                            <div class="col-sm-6">
                                {{Form::text('email',null,['class'=>'form-control'])}}
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-3 control-label">Password</label>
                            <div class="col-sm-6">
                                {{Form::password('password',['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Confirm Password</label>
                            <div class="col-sm-6">
                                {{Form::password('password_confirmation',['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Role</label>
                            <div class="col-sm-6">
                                {{Form::select('role_id',['' => 'Choose']+$roles,null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label"></label>
                            <div class="col-sm-6">
                                <div class="pull-right">
                                    {{Form::submit('Save',['class'=>'btn btn-success'])}}
                                    <input class="btn btn-danger" type="reset" value="Reset">
                                </div>
                            </div>
                        </div>

                    {{Form::close()}}
                </div>

            </div>
        </div>
    </div>
@endsection
