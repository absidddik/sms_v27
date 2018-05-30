@extends('layouts.user')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body" style="padding-bottom: 0;">
                    <div class="col-sm-3">
                        <p><a style="width:100%" class="btn btn-success text-center" href="{{route('internal.result.thirty.show', ['course_e_id'=>$course_e->id,'semester_id'=>$course_e->semester_id])}}">Thirty Percent Marks</a></p>
                        <p><a style="width:100%" class="btn btn-default text-center" href="{{route('internal.result.seventy.show', ['course_e_id'=>$course_e->id,'semester_id'=>$course_e->semester_id])}}">Seventy Percent Marks</a></p>
                        <p><a style="width:100%" class="btn btn-info" href="{{route('internal.full-marks.index', [$course_e->exam_time->id, $course_e->course->id, $course_e->semester->id])}}" >View Full Result</a></p>
                    </div>
                    <div class="col-sm-9">
                        <table class="table table-bordered">
                            <tr>
                                <td width="25%"><b>Exam Time</b></td>
                                <td width="25%">{{ $course_e->exam_time->exam_month.' '.$course_e->exam_time->exam_year }}</td>
                                <td width="25%"><b>Semester</b></td>
                                <td width="25%">{{ $course_e->semester->semester }}</td>
                            </tr>
                            <tr>
                                <td width="25%"><b>Course Name</b></td>
                                <td width="25%">{{ $course_e->course->name }}</td>
                                <td width="25%"><b>Course Code</b></td>
                                <td width="25%">{{ $course_e->course->code }}</td>
                            </tr>

                            <tr>
                                <td width="25%"><b>Credit</b></td>
                                <td width="25%">{{ $course_e->course->credit }}</td>
                                <td width="25%"><b>Mark</b></td>
                                <td width="25%">{{ $course_e->course->mark }}</td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Process 30% Result</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered datatable">
                        <thead>
                            <th>Exam Roll</th>
                            <th>Tutorial 1</th>
                            <th>Tutorial 2</th>
                            <th>Tutorial 3</th>
                            <th>Prefer Tutorial</th>
                            <th>Mid-term</th>
                            <th>Attendance</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
                        <tbody>

                            @foreach ($results as $result)
                                <tr>
                                    <td><b>{{ $result['student']->exam_roll }}</b></td>
                                    <td>{{ $result['result']->tutorial_1 }}</td>
                                    <td>{{ $result['result']->tutorial_2 }}</td>
                                    <td>{{ $result['result']->tutorial_3 }}</td>
                                    <td>{{ $result['result']->prefer_tutorial }}</td>
                                    <td>{{ $result['result']->mid_term }}</td>
                                    <td>{{ $result['result']->attendance }}</td>
                                    <td>{{ $result['result']->total }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info " href="{{ route('internal.thirty-percetn-mark.edit',['course_e_id'=>$course_e->id,'student_id'=>$result['student']->id]) }}">Edit </a>
                                    </td>
                                </tr>
                            @endforeach

                            {{-- @foreach ($student_enrolls as $student_enroll)
                                <tr>
                                    <td><b>{{ $student_enroll->student->exam_roll }}</b></td>
                                    <td>{{ $student_enroll->thirtyMark['tutorial_1'] }}</td>
                                    <td>{{ $student_enroll->thirtyMark['tutorial_2'] }}</td>
                                    <td>{{ $student_enroll->thirtyMark['tutorial_3'] }}</td>
                                    <td>{{ $student_enroll->thirtyMark['prefer_tutorial'] }}</td>
                                    <td>{{ $student_enroll->thirtyMark['mid_term'] }}</td>
                                    <td>{{ $student_enroll->thirtyMark['attendance'] }}</td>
                                    <td>{{ $student_enroll->thirtyMark['total'] }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info " href="{{ route('internal.thirty-percetn-mark.edit',['course_e_id'=>$course_e->id,'student_id'=>$student_enroll->student->id]) }}">Edit </a>
                                    </td>
                                </tr>
                            @endforeach --}}

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
