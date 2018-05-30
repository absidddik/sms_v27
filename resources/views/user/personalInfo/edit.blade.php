@extends('layouts.common')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li>Profile</li>
        <li class=""><a href="{{ route('profile.show',$user->user_id) }}"> {{ $user->name }}</a></li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3><a href="{{ route('profile.show',$user->user_id) }}"> <i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a> | {{ $user->name}} | Personal Info</h3>
                </div>
                <div class="panel-body">

                    {{ Form::model($personalInfo,['route'=>['personal-info.update',$user->user_id],'method'=>'post','class'=>'form-horizontal'])}}

                        @include('includes.errors')
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Designation: </label>
                            <div class="col-md-6 col-xs-12">
                                {{Form::text('designation',null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Mobile: </label>
                            <div class="col-md-6 col-xs-12">
                                {{Form::number('mobile',null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Gender: </label>
                            <div class="col-sm-6">
                                {{Form::select('gender',[''=>'Choose','1'=>'Male','2'=>'Female','3'=>'Other\'s'],null,['class'=>'form-control'])}}

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Blood Group: </label>
                            <div class="col-sm-6">
                                {{Form::text('blood_group',null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">Joining Date: </label>
                            <div class="col-md-6 col-xs-12">
                                {{Form::date('joining_date',null,['class'=>'form-control'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label">About You: </label>
                            <div class="col-md-6 col-xs-12">
                                {{Form::textarea('about',null,['rows' => 5,'class'=>'form-control'])}}
                            </div>
                        </div>

                        {{------------------- submit button ------------------------}}
                        <div class="form-group">
                            <label class="col-md-3 col-xs-12 control-label"></label>
                            <div class="col-md-6 col-xs-12">
                                <div class="pull-right">
                                    <input class="btn btn-success" type="submit" name="" value="Save">
                                    <input class="btn btn-danger" type="reset" name="" value="Reset">
                                </div>
                            </div>
                        </div>
                        {{-------------------- submit button -------------- --}}

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
