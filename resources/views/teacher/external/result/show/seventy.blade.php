@extends('layouts.user')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body" style="padding-bottom: 0;">
                    <div class="col-sm-3">
                        <p><a style="width:100%" class="btn btn-success text-center" href="{{route('internal.result.seventy.show', ['course_e_id'=>$course_e->id,'semester_id'=>$course_e->semester_id])}}">Seventy Percent Marks</a></p>
                        <p><a style="width:100%" class="btn btn-info" href="{{route('external.full-marks.index', [$course_e->exam_time->id, $course_e->course->id, $course_e->semester->id])}}" >View Full Result</a></p>
                    </div>
                    <div class="col-sm-9">
                        <table class="table table-bordered">
                            <tr>
                                <td width="25%"><b>Exam Time</b></td>
                                <td width="25%">{{ $course_e->exam_time->exam_time }}</td>
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
                    <h4>Process 70% Result</h4>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered datatable">
                        <thead>
                            <th>Exam Roll</th>
                            <th>Q1</th>
                            <th>Q2</th>
                            <th>Q3</th>
                            <th>Q4</th>
                            <th>Q5</th>
                            <th>Q6</th>
                            <th>Q7</th>
                            <th>Q8</th>
                            <th>Q9</th>
                            <th>Q10</th>
                            <th>Q11</th>
                            <th>Q12</th>
                            <th>Q13</th>
                            <th>Q14</th>
                            <th>Q15</th>
                            <th>Absent</th>
                            <th>Total</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($results as $result)
                                <tr>
                                    <td><b>{{ $result['student']->exam_roll }}</b></td>
                                    <td>{{ $result['result']->q_1 }}</td>
                                    <td>{{ $result['result']->q_2 }}</td>
                                    <td>{{ $result['result']->q_3 }}</td>
                                    <td>{{ $result['result']->q_4 }}</td>
                                    <td>{{ $result['result']->q_5 }}</td>
                                    <td>{{ $result['result']->q_6 }}</td>
                                    <td>{{ $result['result']->q_7 }}</td>
                                    <td>{{ $result['result']->q_8 }}</td>
                                    <td>{{ $result['result']->q_9 }}</td>
                                    <td>{{ $result['result']->q_10 }}</td>
                                    <td>{{ $result['result']->q_11 }}</td>
                                    <td>{{ $result['result']->q_12 }}</td>
                                    <td>{{ $result['result']->q_13 }}</td>
                                    <td>{{ $result['result']->q_14 }}</td>
                                    <td>{{ $result['result']->q_15 }}</td>
                                    <td>{{ $result['result']->is_absent }}</td>
                                    <td>{{ $result['result']->total }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info " href="{{ route('external.seventy-percetn-mark.edit',['course_e_id'=>$course_e->id,'student_id'=>$result['student']->id]) }}">Edit </a>
                                    </td>
                                </tr>
                            @endforeach
                            {{-- @foreach ($student_enrolls as $student_enroll)
                                <tr>
                                    <td><b>{{ $student_enroll->student->exam_roll }}</b></td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_1'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_2'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_3'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_4'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_5'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_6'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_7'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_8'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_9'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_10'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_11'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_12'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_13'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_14'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['q_15'] }}</td>
                                    <td>{{ $student_enroll->externalSeventyMark['total'] }}</td>
                                    <td class="text-center">
                                        <a class="btn btn-info " href="{{ route('external.seventy-percetn-mark.edit',['course_e_id'=>$course_e->id,'student_id'=>$student_enroll->student->id]) }}">Edit </a>
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
