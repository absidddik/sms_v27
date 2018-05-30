@extends('layouts.common')

@section('styles')
    <style media="screen">
    #profile-pic{

    }

    #profile-pic .pic-but{

        line-height: 0px;
        margin-top: 0px;
        margin-left: 0px;
        margin-right:0px;
        display:inline-block;
        position:relative;
    }

    #profile-pic .pic-but a {
        position:absolute;
        bottom: 5px;
        right: 10px;
        color:silver;

    }

    .nav-tabs, .nav-tabs.nav-justified {
        border-bottom: 0;
        margin-bottom: auto;
        margin-top: auto;
        padding: 0;
        border-bottom: 1px solid #ddd;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus, .nav-tabs > .dropdown.active.open > a:hover {
        border: 0px;
        background: #FFF;
        -moz-border-radius: 3px 3px 0px 0px;
        -webkit-border-radius: 3px 3px 0px 0px;
        border-radius: 3px 3px 0px 0px;
    }

    .btn-cu{
        margin-right: 5px;
        border: 0px;
        font-size: 14px;
        border-top: 2px solid transparent;
        -moz-border-radius: 0px;
        -webkit-border-radius: 0px;
        border-radius: 0px;
        color: #333;
        -webkit-transition: all 200ms ease;
        -moz-transition: all 200ms ease;
        -ms-transition: all 200ms ease;
        -o-transition: all 200ms ease;
        transition: all 200ms ease;
        background: #F5F5F5;
        padding: 9px 15px;
    }
    .active{
        background: white;
    }
    .panel-body{
        padding:0px;
    }
    </style>
@endsection

@section('content')
    <div class="col-sm-12">
        <div class="col-sm-3" style="padding:0">
            <div class="row">
                <div id="profile-pic">
                    <div class="pic-but">
                        @if ($user->personalInfo && $user->personalInfo->image)
                            <img class="img-responsive img-thumbnail" src="{{ asset('storage/user/profile/'.$user->personalInfo->image) }}" alt="">
                        @else
                            <img class="img-responsive img-thumbnail" src="{{ asset('images/default-profile.png') }}" alt="">
                        @endif

                        <a href="{{ route('personal-info.profile-pic.edit',$user->user_id) }}" class="btn-floating btn-large"><i class="fa fa-camera fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <br>
            <h3 class=''><i class="fa fa-user"></i> {{ $user->name }}</h3>
            <h4><i class="fa fa-envelope"></i> {{ $user->email }}</h4>
            <h4><i class="fa fa-tasks"></i> {{ $user->role->name }}</h4>
            @if (Auth::user()->isAdmin())
                <div class="pull-left">
                    <div class="dropdown">
                        <button class="btn btn-default btn-block dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i>Account Settings
                        </button>
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
                </div>

                @else
                    <a href="{{route('account.setting',$user->user_id)}}" class="btn btn-xs btn-default"><i class="fa fa-cog" aria-hidden="true"></i> Account Settings</a>
            @endif
        </div>

        <div class="col-sm-9" style="">
            <div class="col-sm-12" style="background:white;padding: 10px;">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs">
                        <li><button class="btn-cu" id="profile" type="button" name="profile">Profile</button></li>
                        <li><button class="btn-cu" id="edu" type="button" name="profile">Education</button></li>
                        <li><button class="btn-cu" id="res" type="button" name="profile">Research</button></li>
                        <li><button class="btn-cu" id="pub" type="button" name="profile">Publications</button></li>
                    </ul>
                    <br>
                </div>

                <div class="col-sm-12">

                    <div class="panel-body" id="profile-view">
                        <h3>Personal Info</h3>
                        <hr>
                        <table class="table no-border">
                            <tbody>
                                @if ($user->personalInfo)
                                    <tr>
                                        <td width="18%"><b>Designation</b></td>
                                        <td width="1%">:</td>
                                        <td width="81%">{{ $user->personalInfo->designation }}</td>
                                    </tr>
                                    <tr>
                                        <td width="18%"><b>Mobile Number</b></td>
                                        <td width="1%">:</td>
                                        <td width="81%">{{ $user->personalInfo->mobile }}</td>
                                    </tr>
                                    <tr>
                                        <td width="18%"><b>Gender</b></td>
                                        <td width="1%">:</td>
                                        <td width="81%">{{ gender($user->personalInfo->gender) }}</td>
                                    </tr>
                                    <tr>
                                        <td width="18%"><b>Blood Group</b></td>
                                        <td width="1%">:</td>
                                        <td width="81%">{{ $user->personalInfo->blood_group }}</td>
                                    </tr>
                                    <tr>
                                        <td width="18%"><b>Joining Date</b></td>
                                        <td width="1%">:</td>
                                        <td width="81%">{{ $user->personalInfo->joining_date }}</td>
                                    </tr>
                                    <tr>
                                        <td width="18%"><b>About</b></td>
                                        <td width="1%">:</td>
                                        <td width="81%">{{ $user->personalInfo->about }}</td>
                                    </tr>
                                @else
                                    <p style="color:red;">Not set yet!</p>
                                @endif
                            </tbody>
                        </table>

                        <div class="pull-right">
                            <a class="btn btn-default"  href="{{ route('personal-info.edit',$user->user_id) }}"> <i class="fa fa-cog" aria-hidden="true"></i>Edit</a>
                        </div>
                    </div>

                    <div class="panel-body" id="edu-view" style="display:none">
                        <h3>Educational Qualification</h3>
                        <hr>
                        <table class="table table-border">
                            <thead>
                                <th>Serial No.</th>
                                <th>Degree</th>
                                <th>Board / Institute</th>
                                <th>Passing Year</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <a class="btn btn-primary" href=""><i class="fa fa-plus"></i>  Add New</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body" id="res-view" style="display:none">
                    <h3>Research Area</h3>
                    <hr>
                    <table class="table table-border">
                        <thead>
                            <th>Serial No.</th>
                            <th width="50%">Title</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <td>1</td>
                            <td>test test</td>
                            <td>
                                <form class="" action="" method="post">
                                    {{ csrf_field() }} {{ method_field('delete') }}
                                    <a class="btn btn-info" href=""><i class="fa fa-eye"> View</i></a>
                                    <a class="btn btn-primary" href=""><i class="fa fa-edit"> Edit</i></a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#1"><i class="fa fa-trash-o"> Delete</i></button>
                                    <div id="1" class="modal fade" role="dialog">
                                        @include('includes.delete')
                                    </div>
                                </form>
                            </td>
                        </tbody>
                    </table>
                    <div class="pull-right">
                        <a class="btn btn-primary" href=""><i class="fa fa-plus"></i>  Add Research</a>
                    </div>
                </div>
                <div class="panel-body" id="pub-view" style="display:none">
                    <h3>Publications (National and International)</h3>
                    <hr>
                    <table class="table table-border">
                        <thead>
                            <th>Serial No.</th>
                            <th style="width:50%">Title</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <td>1</td>
                            <td>test test</td>
                            <td>
                                <form class="" action="" method="post">
                                    {{ csrf_field() }} {{ method_field('delete') }}
                                    <a class="btn btn-info" href=""><i class="fa fa-eye"> View</i></a>
                                    <a class="btn btn-primary" href=""><i class="fa fa-edit"> Edit</i></a>
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#1"><i class="fa fa-trash-o"> Delete</i></button>
                                    <div id="1" class="modal fade" role="dialog">
                                        @include('includes.delete')
                                    </div>
                                </form>
                            </td>
                        </tbody>
                    </table>
                    <div class="pull-right">
                        <a class="btn btn-primary" href=""><i class="fa fa-plus"></i>  Add Publication</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
    $(document).ready(function(){
        var show_time = 0;
        $("#profile").click(function(){
            $('#edu-view').hide();
            $('#res-view').hide();
            $('#pub-view').hide();
            $('#profile-view').show(show_time);
        });
        $("#edu").click(function(){
            $('#profile-view').hide();
            $('#res-view').hide();
            $('#pub-view').hide();
            $('#edu-view').addClass('active');
            $('#edu-view').show(show_time);
        });

        $("#res").click(function(){
            $('#profile-view').hide();
            $('#edu-view').hide();
            $('#pub-view').hide();
            $('#res-view').addClass('active');
            $('#res-view').show(show_time);
        });

        $("#pub").click(function(){
            $('#profile-view').hide();
            $('#res-view').hide();
            $('#edu-view').hide();
            $('#pub-view').addClass('active');
            $('#pub-view').show(show_time);
        });

    });
    </script>
@endsection
