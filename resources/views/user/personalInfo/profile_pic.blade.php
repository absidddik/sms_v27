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
            <div class="col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3><a href="{{ route('profile.show',$user->user_id) }}"> <i class="fa fa-arrow-left" aria-hidden="true"></i>Back</a> | {{ $user->name}} | Profile Picture</h3>
                    </div>
                    <div class="panel-body text-center">

                        {{ Form::open(['route'=>['personal-info.profile-pic.upload',$user->user_id],'method'=>'post','files'=>true,'class'=>'form-horizontal'])}}

                            @include('includes.errors')
                            <div class="form-group">
                                @if ($user->personalInfo && $user->personalInfo->image)
                                    <img class="img-responsive img-thumbnail" src="{{ asset('storage/user/profile/'.$user->personalInfo->image) }}" alt="">
                                @else
                                    <img class="img-responsive img-thumbnail" src="{{ asset('images/default-profile.png') }}" alt="">
                                @endif
                                <br><br>
                                <div class="">
                                    {{Form::file('image',['class'=>'fileinput btn-primary'])}}
                                </div>
                                <br>

                                <div class="col-sm-4 col-sm-offset-4">
                                    <input style="width:100%"  class="btn btn-success" type="submit" name="" value="Upload">
                                </div>
                            </div>

                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
