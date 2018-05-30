<!DOCTYPE html>
<html lang="en">
<head>
    <!-- META SECTION -->
    <title>{{ config('app.name', 'HealthCare') }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <!-- END META SECTION -->

    <!-- CSS INCLUDE -->
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('admin/css/theme-brown.css')}}"/>
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/toastr.min.css')}}"/>
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/custom.css')}}"/>
    {{-- this style used for borderless table  --}}

    @yield('styles')
    <!-- EOF CSS INCLUDE -->
</head>
<body>
    <!-- START PAGE CONTAINER -->
    <div class="page-container" style="background-color:#ffffff">

        <!-- START PAGE SIDEBAR -->
        <div class="page-sidebar">
            <!-- START X-NAVIGATION -->
            <ul class="x-navigation">
                <li class="xn-logo">
                    <a href="">Admin Area</a>
                    <a href="#" class="x-navigation-control"></a>
                </li>
                <li class="xn-profile">
                    <div class="profile">

                        <div class="profile-data">
                            <div class="profile-data-name">{{Auth::user()->name}}</div>
                        </div>

                    </div>
                </li>


                {{-- ------------------------------------------------------
                Left Menu Bar Start
                ------------------------------------------------------------  --}}


                <li>
                    <a href="{{route('admin.dash')}}"><span class="fa fa-desktop"></span> <span class="xn-text">Dashboard</span></a>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-group"></span> <span class="xn-text">User</span></a>
                    <ul>
                        <li><a href="{{route('user-role.index')}}"><span class="fa fa-legal"></span>User Role</a></li>
                        <li><a href="{{route('users.create')}}"><span class="fa fa-plus"></span>Create User</a></li>
                        <li><a href="{{route('users.index')}}"><span class="fa fa-list"></span>User List</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-tags"></span> <span class="xn-text">Batch</span></a>
                    <ul>
                        <li><a href="{{route('batch.create')}}"><span class="fa fa-plus"></span>Create Batch</a></li>
                        <li><a href="{{route('batch.index')}}"><span class="fa fa-list"></span>Batch List</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-tags"></span> <span class="xn-text">Batch Enroll</span></a>
                    <ul>
                        <li><a href="{{route('batch-enroll.create')}}"><span class="fa fa-plus"></span>Enroll Batch</a></li>
                        <li><a href="{{route('batch-enroll.index')}}"><span class="fa fa-list"></span>All Enroll Batch</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-tags"></span> <span class="xn-text">Course</span></a>
                    <ul>
                        <li><a href="{{route('course.create')}}"><span class="fa fa-plus"></span>Add Course</a></li>
                        <li><a href="{{route('course.index')}}"><span class="fa fa-list"></span>Course List</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-tags"></span> <span class="xn-text">Exam Time</span></a>
                    <ul>
                        <li><a href="{{route('exam-time.create')}}"><span class="fa fa-plus"></span>Add Exam Time</a></li>
                        <li><a href="{{route('exam-time.index')}}"><span class="fa fa-list"></span>Exam Time List</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-tags"></span> <span class="xn-text">Semester</span></a>
                    <ul>
                        <li><a href="{{route('semester.index')}}"><span class="fa fa-list"></span>Semester</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-graduation-cap"></span> <span class="xn-text">Teacher</span></a>
                    <ul>
                        {{-- <li><a href="{{route('teacher.create')}}"><span class="fa fa-plus"></span>Create Teacher</a></li> --}}
                        <li><a href="{{route('teacher.index')}}"><span class="fa fa-list"></span>Teacher List</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-graduation-cap"></span> <span class="xn-text">Student</span></a>
                    <ul>
                        <li><a href="{{route('student.create')}}"><span class="fa fa-plus"></span>Create Student</a></li>
                        <li><a href="{{route('student.index')}}"><span class="fa fa-list"></span>Student List</a></li>
                    </ul>
                </li>


                <li class="xn-openable">
                    <a href="#"><span class="fa fa-tags"></span> <span class="xn-text">Course Enroll</span></a>
                    <ul>
                        <li><a href="{{route('course-enroll.create')}}"><span class="fa fa-plus"></span>Enroll Course</a></li>
                        <li><a href="{{route('course-enroll.index')}}"><span class="fa fa-list"></span>All Enroll Course</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-tags"></span> <span class="xn-text">Charman Enroll</span></a>
                    <ul>
                        <li><a href="{{route('charman-enroll.create')}}"><span class="fa fa-plus"></span>Charman Enroll</a></li>
                        <li><a href="{{route('charman-enroll.index')}}"><span class="fa fa-list"></span>All Charman Enroll</a></li>
                    </ul>
                </li>



                <li class="xn-openable">
                    <a href="#"><span class="fa fa-tags"></span> <span class="xn-text">External Enroll</span></a>
                    <ul>
                        <li><a href="{{route('external-enroll.create')}}"><span class="fa fa-plus"></span>External Enroll</a></li>
                        <li><a href="{{route('external-enroll.index')}}"><span class="fa fa-list"></span>All External Enroll</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-graduation-cap"></span> <span class="xn-text">Student Enroll</span></a>
                    <ul>
                        <li><a href="{{route('student-enroll.create')}}"><span class="fa fa-plus"></span>Enroll Student</a></li>
                        <li><a href="{{route('student-enrolls.show')}}"><span class="fa fa-list"></span>All Enroll Student</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-graduation-cap"></span> <span class="xn-text">Due Student Enroll</span></a>
                    <ul>
                        <li><a href="{{route('due-student-enroll.create')}}"><span class="fa fa-plus"></span>Enroll Student</a></li>
                        <li><a href="{{route('due.student-enrolls.show')}}"><span class="fa fa-list"></span>All Enroll Student</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-graduation-cap"></span> <span class="xn-text">Supplementary Enroll</span></a>
                    <ul>
                        <li><a href="{{route('supplementary-enroll.create')}}"><span class="fa fa-plus"></span>Enroll Supplementary</a></li>
                        <li><a href="{{route('supplementary-enrolls.show')}}"><span class="fa fa-list"></span>All Enroll Supplementary</a></li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Level 3</span></a>
                    <ul>
                        <li>
                            <a href=""><span class="fa fa-file-o"></span>Slide 1</a>
                        </li>
                        <li class="xn-openable">
                            <a href="#"><span class="fa fa-files-o"></span>Slide 2</a>
                            <ul>
                                <li><a href=""><span class="fa fa-plus"></span>Part 1</a></li>
                                <li><a href=""><span class="fa fa-list"></span>Part 2</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Level 4</span></a>
                    <ul>
                        <li>
                            <a href=""><span class="fa fa-file-o"></span>Slide 1</a>
                        </li>
                        <li class="xn-openable">
                            <a href="#"><span class="fa fa-files-o"></span>Slide 2</a>
                            <ul>
                                <li><a href=""><span class="fa fa-file-o"></span>Page 1</a></li>
                                <li class="xn-openable">
                                    <a href="#"><span class="fa fa-files-o"></span>Page 2</a>
                                    <ul>
                                        <li><a href=""><span class="fa fa-plus"></span>Part 1</a></li>
                                        <li><a href=""><span class="fa fa-list"></span>Part 2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>


                {{-- ------------------------------------------------------
                Left Menu Bar end
                ------------------------------------------------------------  --}}




                <li>
                    <a href=""><span class=""></span> <span class="xn-text"></span></a>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-files-o"></span> <span class="xn-text">Design</span></a>
                    <ul>
                    </ul>
                </li>

                <li class="xn-openable">
                    <a href="#"><span class="fa fa-sitemap"></span> <span class="xn-text">Navigation Levels</span></a>
                    <ul>
                        <li class="xn-openable">
                            <a href="#">Second Level</a>
                            <ul>
                                <li class="xn-openable">
                                    <a href="#">Third Level</a>
                                    <ul>
                                        <li class="xn-openable">
                                            <a href="#">Fourth Level</a>
                                            <ul>
                                                <li><a href="#">Fifth Level</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>






            </ul>
            <!-- END X-NAVIGATION -->
        </div>
        <!-- END PAGE SIDEBAR -->

        <!-- PAGE CONTENT -->
        <div class="page-content">

            <!-- START X-NAVIGATION VERTICAL -->
            <ul class="x-navigation x-navigation-horizontal x-navigation-panel">
                <!-- TOGGLE NAVIGATION -->
                <li class="xn-icon-button">
                    <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
                </li>
                <!-- END TOGGLE NAVIGATION -->
                <!-- SEARCH -->

                <!-- END SEARCH -->
                <!-- SIGN OUT -->
                <li class="xn-icon-button pull-right">
                    <a href="#" class="mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span></a>
                </li>
                <!-- END SIGN OUT -->


            </ul>
            <!-- END X-NAVIGATION VERTICAL -->


            <!-- PAGE CONTENT WRAPPER -->
            @yield('breadcrumb')
            <div class="page-content-wrap">

                <div class="row">
                    <div class="col-md-12">
                        <br>
                        @yield('content')

                    </div>
                </div>


            </div>
            <!-- END PAGE CONTENT WRAPPER -->
        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->


    <!-- MESSAGE BOX-->
    <div class="message-box animated fadeIn" data-sound="alert" id="mb-signout">
        <div class="mb-container">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
                <div class="mb-content">
                    <p>Are you sure you want to log out?</p>
                    <p>Press No if youwant to continue work. Press Yes to logout current user.</p>
                </div>
                <div class="mb-footer">
                    <div class="pull-right">
                        <a class="btn btn-success btn-lg" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Yes
                    </a>
                    <button class="btn btn-default btn-lg mb-control-close">No</button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MESSAGE BOX-->


<!-- START SCRIPTS -->
<!-- START PLUGINS -->
<script type="text/javascript" src="{{asset('admin/js/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/jquery/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/bootstrap/bootstrap.min.js')}}"></script>
<!-- END PLUGINS -->

<!-- START THIS PAGE PLUGINS-->
<script type='text/javascript' src="{{asset('admin/js/plugins/icheck/icheck.min.js')}}"></script>
<script type='text/javascript' src="{{asset('admin/js/plugins/bootstrap/bootstrap-file-input.js')}}"></script>
<script type='text/javascript' src="{{asset('admin/js/plugins/summernote/summernote.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/bootstrap/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/bootstrap/bootstrap-select.js') }}"></script>

<script type='text/javascript' src="{{asset('admin/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js')}}"></script>
<!-- END THIS PAGE PLUGINS-->


<!-- START TEMPLATE -->
<script type="text/javascript" src="{{asset('admin/js/settings.js')}}"></script>

<script type="text/javascript" src="{{asset('admin/js/plugins.js')}}"></script>
<script type="text/javascript" src="{{asset('admin/js/actions.js')}}"></script>
<script type="text/javascript" src="{{asset('js/toastr.min.js')}}"></script>
<!-- END TEMPLATE -->
<script type="text/javascript">
@if (Session::has('success'))
toastr.success("{{Session::get('success')}}")
@endif
@if (Session::has('info'))
toastr.info("{{Session::get('info')}}")
@endif
</script>

@yield('scripts')
<!-- END SCRIPTS -->
</body>
</html>
