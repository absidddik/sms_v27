@extends('layouts.user')


@section('styles')
    <style media="screen">
    .table>thead>tr>th, .table>tbody>tr>th, .table>tfoot>tr>th, .table>thead>tr>td, .table>tbody>tr>td, .table>tfoot>tr>td {
        padding: 0px;
        line-height: 1.42857143;
        vertical-align: top;
        overflow: hidden;
    }
    .border_top{
        border-top: 0px;
    }
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
        border-color: black;
        border-width: 2px;
    }
    .inner_table tr td{
        width: 16.17%;
        border-right: 2px solid black;
        border-top: 0px;
    }
    .table td {
        text-align: center;
    }
    .custom_table{
        width: 100%;
    }
    .custom_table td{
        text-align: center;
    }
    .border_top{
        border-top:2px solid black;
        margin-bottom: 0px;
    }
    .border_bottom{
        border-bottom:2px solid black;
    }
    .padding_top{

    }
    .topview{
        padding: 0 !important;
        line-height: 30px !important;
        margin: 0 !important;
    }
    .tp tbody tr td {
        padding-left: 5px !important;
        padding-right: 5px !important;
    }
</style>
@endsection

@section('content')
    <div class="col-sm-12">
        
        <div class="col-sm-4 pull-left">
            <table class="tp" style="border: 1px solid black;">
                <tbody>
                    <tr>
                        <td style="padding-top: 5px !important" class="text-left">1. 80% and Above -  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;A+</td>
                        <td style="padding-top: 5px !important" class="text-left">6. 55% to less than 60% &nbsp;&nbsp;&nbsp;B-</td>
                    </tr>
                    <tr>
                        <td class="text-left">2. 75% to less than 80% &nbsp;&nbsp;&nbsp;A</td>
                        <td class="text-left">7. 50% to less than 55% &nbsp;&nbsp;&nbsp;C+</td>
                    </tr>
                    <tr>
                        <td class="text-left">3. 70% to less than 75% &nbsp;&nbsp;&nbsp;A-</td>
                        <td class="text-left">8. 45% to less than 50% &nbsp;&nbsp;&nbsp;C</td>
                    </tr>
                    <tr>
                        <td class="text-left">4. 65% to less than 70% &nbsp;&nbsp;&nbsp;B+</td>
                        <td class="text-left">9. 40% to less than 45% &nbsp;&nbsp;&nbsp;D</td>
                    </tr>
                    <tr >
                        <td style="padding-bottom: 5px !important" class="text-left">5. 60% to less than 65% &nbsp;&nbsp;&nbsp;B</td>
                        <td style="padding-bottom: 5px !important" class="text-left"> &nbsp;&nbsp;&nbsp;&nbsp;Less than 40% - F</td>
                    </tr>
                </tbody>
                <br><br>
            </table>
        </div>
    
        <div class="col-sm-4 text-center">
            <div style="padding-left: 20px">
                <h3 class="topview">Gono Bishwabidyalay</h3>
                <h3 class="topview">Savar,Dhaka</h3>
            </div>
        </div>
    
        <div class="col-sm-4">
            <div class="pull-right">
                <table style="border: 3px solid black;">
                        <td style="font-size: 25px;"><p style="padding: 10px 10px 20px 10px !important">Computer Science <br><br> & Engineering</p></td>
                </table>
            </div>
        </div>
        <div class="col-sm-12 text-center">
            <p><b><i>Provisional Result of B.Sc (Hons.) CSE {{ strtolower($batch_e->semester->semester) }} semester ({{ $batch_e->batch->batch_number }} Batch) Final Examination - {{ $batch_e->exam_time->exam_month.','.$batch_e->exam_time->exam_year }}</i></b></p>
        </div>
    </div>
    <div class="col-sm-12" style="overflow-x: auto;color:black">
        <table class="table table-bordered">
            <tr>
                <td style="padding-top:5px;font-weight:bold">Exam <br>Roll <br>No.</td>
                <td style="padding-top:5px;font-weight:bold">Name of the Students</td>
                @foreach ($courses as $c)
                    <td style="font-weight:bold;">
                        <p style="min-height:50px;max-height:100px;">{{$c->name}}</p>
                        <p class="border_top">{{$c->code}}</p>
                        <p class="border_top border_bottom">{{$c->mark}}</p>

                        <table class="" style="margin-bottom:0px;width:100%">
                            {{-- <tr>
                            <td>{{$c->name}}</td>
                        </tr>
                        <tr>
                        <td>{{$c->code}}</td>
                    </tr>
                    <tr>
                    <td>{{$c->mark}}</td>
                </tr> --}}
                <tr>
                    <td  style="border-right:2px solid black">Marks</td>
                    <td>Grade</td>
                </tr>
            </table>
        </td>
    @endforeach
    <td class="border_top" style="padding-top:5px;font-weight:bold">Result</td>
</tr>



@foreach ($full_results as $roll => $course_results)
    <tr>
        <td style="padding:3px">{{$roll}}</td>
        <td style="padding:3px">{{$course_results['result'][0]->name}}</td>

        @foreach ($course_results['result'] as $r)
            @if ($r)
                <td>
                    @if ($r->due)
                        -
                    @else
                        {{$r->grade}}
                    @endif

                </td>
            @endif
        @endforeach

        <td>
            @if ($course_results['due'])
                <p><b>{{$course_results['due']}}</b></p>
            @else
                @if ($course_results['status']['absent'] || $course_results['status']['failed'])
                    <ul style="margin:0;padding:0">
                        <li style="list-style:none">
                            <p>
                                <b>
                                    @if ($course_results['status']['all_absent'])
                                        {{$course_results['status']['all_absent']}}
                                    @else
                                        @if ($course_results['status']['absent'])
                                            Absent in C No
                                        @endif

                                        @foreach ($course_results['status']['absent'] as $s)
                                            {{$s}},
                                        @endforeach
                                    @endif
                                </b>
                            </p>
                        </li>

                        <li style="list-style:none">
                            <p>
                                <b>
                                    @if ($course_results['status']['all_failed'])
                                        {{$course_results['status']['all_failed']}}
                                    @else
                                        @if ($course_results['status']['failed'])
                                            Failed in C No
                                        @endif

                                        @foreach ($course_results['status']['failed'] as $s)
                                            {{$s}},
                                        @endforeach
                                    @endif
                                </b>
                            </p>
                        </li>


                    </ul>
                @else
                    <p>Passed</p>
                @endif
            @endif
        </td>
    </tr>
@endforeach

</tbody>
</table>

</div>
<a class="btn btn-primary btn-sm" href="{{route('pdf.charman-result-without-mark.show',[$exam_id,$semester_id])}}">Without Mark PDF</a>
<br><br><br><br>
@endsection
