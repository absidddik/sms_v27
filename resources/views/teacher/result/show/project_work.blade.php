@extends('layouts.user')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body" style="padding-bottom: 0;">
                    <div class="col-sm-3">
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
                    <h4>Process Project Work Result</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered datatable">
                        <thead>
                            <th>Exam Roll</th>
                            <th>Project Work</th>
                            <th>Absent</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr>
                                    <td><b>{{ $result['student']->exam_roll }}</b></td>
                                    <td>{{ $result['result']->total }}</td>
                                    <td>{{ $result['result']->is_absent? 'Absent' : '' }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info " href="{{ route('internal.project-work-mark.edit',['course_e_id'=>$course_e->id,'student_id'=>$result['student']->id]) }}">Edit </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
