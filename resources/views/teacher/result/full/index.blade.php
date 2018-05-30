@extends('layouts.user')

@section('content')

    <style media="screen">
    .tablemy>thead>tr>th, .tablemy>tbody>tr>th, .tablemy>tfoot>tr>th, .tablemy>thead>tr>td, .tablemy>tbody>tr>td, .tablemy>tfoot>tr>td {
        padding: 2px;
        line-height: 1.42857143;
        vertical-align: top;
        border-top: 1px solid #ddd;
    }
    .page-container .page-content {
        min-height: 100%;
        margin-left: 220px;
        background: white;
        position: relative;
        zoom: 1;
    }
</style>

<div class="col-sm-12" style="margin-bottom:10px">
    <div class="col-sm-6">
        <div class="text-center">
            <p style="font-size: 30px">Gono Bishwabidyalay</p>
            <p>Nolam, Mirzanagar, Savar, Dhaka-1344</p>
            <p style="font-size: 25px">Examination Detail Number</p>
            <p style="font-size: 18px">
                {{ strtolower($ce_detail->semester->semester) }} Semester Final Examination
                {{ $ce_detail->exam_time->exam_month.' '.$ce_detail->exam_time->exam_year }}
            </p>
            <p style="font-size: 15px"><b>Subject:</b> {{ $ce_detail->course->name }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total:</b> {{ $ce_detail->course->mark }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Course No:</b> {{ $ce_detail->course->code }}</p>
        </div>
    </div>
    <div class="col-sm-6">
        <table class="tablemy table-bordered pull-right">
            <thead>
                <th>Numerical Grade</th>
                <th>Letter Grade</th>
                <th>Grade Point</th>
            </thead>
            <tbody>
                <tr>
                    <td>80% and above</td>
                    <td style="text-align:center" >A+</td>
                    <td style="text-align:center" >4.00</td>
                </tr>
                <tr>
                    <td>75% to less than 80%</td>
                    <td style="text-align:center" >A</td>
                    <td style="text-align:center" >3.75</td>
                </tr>
                <tr>
                    <td>70% to less than 75%</td>
                    <td style="text-align:center" >A-</td>
                    <td style="text-align:center" >3.50</td>
                </tr>
                <tr>
                    <td>65% to less than 70%</td>
                    <td style="text-align:center" >B+</td>
                    <td style="text-align:center" >3.25</td>
                </tr>
                <tr>
                    <td>60% to less than 65%</td>
                    <td style="text-align:center" >B</td>
                    <td style="text-align:center" >3.00</td>
                </tr>
                <tr>
                    <td>55% to less than 60%</td>
                    <td style="text-align:center" >B-</td>
                    <td style="text-align:center" >2.75</td>
                </tr>
                <tr>
                    <td>50% to less than 55%</td>
                    <td style="text-align:center" >C+</td>
                    <td style="text-align:center" >2.50</td>
                </tr>
                <tr>
                    <td>45% to less than 50%</td>
                    <td style="text-align:center" >C</td>
                    <td style="text-align:center" >2.25</td>
                </tr>
                <tr>
                    <td>40% to less than 45%</td>
                    <td style="text-align:center" >D</td>
                    <td style="text-align:center" >2.00</td>
                </tr>
                <tr>
                    <td>Less than 40%</td>
                    <td style="text-align:center" >F</td>
                    <td style="text-align:center" >0.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="col-sm-12">
    <table class="table table-bordered text-center">
        <tr>
            <th class="text-center" rowspan="2">Exam Roll <br>No.</th>
            <th class="text-center" rowspan="2">Theoretical <br>Marks <br>70/35</th>
            <th class="text-center" colspan="3">Continuous Evaluation Marks 30/15</th>
            <th class="text-center" rowspan="2">Total <br>100/50</th>
            <th class="text-center" rowspan="2">Grade</th>
        </tr>
        <tr>
            <td>Attendance <br>10/5</td>
            <td>Class Test/Home <br>Assignment/<br>Language Viva <br>10/5</td>
            <td>Midterm/<br>Card Final <br>10/5</td>
        </tr>


        @if ($results)
            @foreach ($results as $result)
                <tr>
                    <td>{{ $result->exam_roll }}</td>
                    @if ($result->is_absent)
                        <td>
                            AB
                        </td>
                    @else
                        <td>{{ round($result->seventy_total) }}</td>
                    @endif

                    <td>{{ round($result->attendance) }}</td>
                    <td>{{ round($result->class_test) }}</td>
                    <td>{{ round($result->mid_term) }}</td>
                    <td>{{ round($result->total) }}</td>
                    <td>{{ $result->grade }}</td>
                </tr>
            @endforeach
        @endif



    </table>

    <div class="col-sm-12">
        <a class="btn btn-info" href="{{ route('pdf.thirty-percetn-mark',[$exam_time_id, $course_id, $semester_id]) }}">Full Result PDF</a><br> <br>
        @if (!$isSubmitted)
            {{Form::open(['route'=>'result.submit','method'=>'POST'])}}
                <input type="hidden" name="exam_time_id" value="{{$exam_time_id}}">
                <input type="hidden" name="course_id" value="{{$course_id}}">
                <input  type="hidden" name="semester_id" value="{{$semester_id}}">
                <input class="btn btn-primary" type="submit" name="" value="Submit Result">
            {{Form::close()}}
        @else
            <h3>You already submitted this result</h3>
        @endif
        <br><br>
    </div>
</div>
@endsection
