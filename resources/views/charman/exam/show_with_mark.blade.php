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
        /* width: 16.17%; */
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
    .topview{
        padding: 0 !important;
        line-height: 30px !important;
        margin: 0 !important;
    }

</style>
@endsection

@section('content')
    <div class="col-sm-12 text-center">
        <h3 class="topview">Gono Bishwabidyalay</h3>
        <h3 class="topview">Department of Computer Science & Engineering</h3>
        <h3 class="topview">{{ strtolower($semester->semester) }} Semester Final Examination, {{ $exam_time->exam_month.'-'.$exam_time->exam_year }}</h3>
        <br>
    </div>
    <div class="col-sm-12" style="overflow-x: auto;color:black">
        <table class="table table-bordered">
            <tr>
                <td style="padding-top:5px;">Roll</td>
                @foreach ($courses as $c)
                    <td style="padding-top:5px;">
                        <p>{{$c->code}}</p>
                        <p style="min-height:50px;max-height:100px;">{{$c->name}}</p>
                        <p>{{$c->mark}}</p>

                        <table class="table border_top inner_table" style="margin-bottom: 0;">
                            @if ($c->credit == 1)
                                <tr>
                                    <td width="35%" style="padding:5px;">25</td>
                                    <td width="66%" style="border-right: 0px solid black;padding:5px">Grade</td>
                                </tr>
                            @elseif ($c->credit == 2)
                                @if ($c->getType() == 'LAB')
                                    <tr>
                                        <td width="50%" style="padding:5px;">50</td>
                                        <td width="50%" style="border-right: 0px solid black;padding:5px">Grade</td>
                                    </tr>
                                @else
                                    <tr>
                                        <td width="18%" style="padding:5px;">35</td>
                                        <td width="20%" style="padding:5px">15</td>
                                        <td width="26%" style="padding:5px;">50</td>
                                        <td width="36%" style="border-right: 0px solid black;padding:5px">Grade</td>
                                    </tr>
                                @endif
                            @else
                                <tr>
                                    <td width="20%" style="padding:5px;">70</td>
                                    <td width="20%" style="padding:5px">30</td>
                                    <td width="20%" style="padding:5px;">100</td>
                                    <td width="35%" style="border-right: 0px solid black;padding:5px">Grade</td>
                                </tr>
                            @endif
                        </table>
                    </td>
                @endforeach
            </tr>



            @foreach ($full_results as $roll => $course_results)
                <tr>
                    <td style="padding:5px">{{$roll}}</td>
                    @foreach ($course_results['result'] as $r)
                        @if ($r)
                            <td>
                                @if ($r->is_absent)
                                    AB
                                @else
                                    <table class="table  inner_table" style="margin-bottom: 0;">
                                        @if ($r->course_credit == 1)
                                            <tr>
                                                <td width="35%" style="border-top:0px;padding:5px">{{sprintf("%02d",$r->total)}}</td>
                                                <td width="65%" style="border-right:0px;border-top:0px solid black">{{$r->grade}}</td>
                                            </tr>
                                        @elseif ($r->course_credit == 2)
                                            @if ($r->course_type == 'LAB')
                                                <tr>
                                                    <td width="50%" style="border-top:0px;padding:5px">{{sprintf("%02d",$r->total)}}</td>
                                                    <td width="50%" style="border-right:0px;border-top:0px solid black">{{$r->grade}}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td width="18%" style="border-top:0px;padding:5px">{{sprintf("%02d",$r->seventy_total)}}</td>
                                                    <td width="20%" style="border-top:0px;padding:5px">{{sprintf("%02d",$r->thirty)}}</td>
                                                    <td width="26%" style="border-top:0px;padding:5px">{{sprintf("%02d",$r->total)}}</td>
                                                    <td width="36%" style="border-right:0px;border-top:0px solid black">{{$r->grade}}</td>
                                                </tr>
                                            @endif
                                        @else
                                            <tr>
                                                <td width="18%" style="border-top:0px;padding:5px">{{sprintf("%02d",$r->seventy_total)}}</td>
                                                <td width="20%" style="border-top:0px;padding:5px">{{sprintf("%02d",$r->thirty)}}</td>
                                                <td width="26%" style="border-top:0px;padding:5px">{{sprintf("%02d",$r->total)}}</td>
                                                <td width="36%" style="border-right:0px;border-top:0px solid black">{{$r->grade}}</td>
                                            </tr>
                                        @endif

                                    </table>
                                @endif
                            </td>
                        @endif

                    @endforeach
                </tr>
            @endforeach

        </tbody>
    </table>

</div>
<a class="btn btn-primary btn-sm" href="{{route('pdf.charman-result-with-mark.show',[$exam_id,$semester_id])}}">With Mark PDF</a>
<br><br><br><br>
@endsection
