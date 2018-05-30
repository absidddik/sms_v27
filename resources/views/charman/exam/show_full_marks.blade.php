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
                        <p>{{$c->name}}</p>
                        <p>{{$c->mark}}</p>

                        @if ($c->has_external)
                            <table class="table border_top inner_table" style="margin-bottom: 0;">
                                <tr>
                                    <td style="padding:5px;">I</td>
                                    <td style="padding:5px">E</td>
                                    <td style="padding:5px;">3rd</td>
                                    <td style="padding:5px">70</td>
                                    <td style="padding:5px">30</td>
                                    <td style="border-right: 0px solid black;padding:5px">100</td>
                                </tr>
                            </table>
                        @endif
                    </td>
                @endforeach
            </tr>



            @foreach ($full_results as $roll => $course_results)
                <tr>
                    <td style="padding:5px">{{$roll}}</td>
                    @foreach ($course_results['result'] as $r)
                        @if ($r)
                            @if ($r->external_seventy)
                                <td>
                                    @if ($r->is_absent)
                                        AB
                                    @else
                                        <table class="table  inner_table" style="margin-bottom: 0;">
                                            <tr>
                                                <td style="border-top:0px;padding:5px">{{round($r->seventy)}}</td>
                                                <td style="border-top:0px;padding:5px">{{round($r->external_seventy)}}</td>
                                                <td style="border-top:0px;padding:5px">
                                                    @if ($r->third_ex_seventy)
                                                        {{round($r->third_ex_seventy)}}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td style="border-top:0px;padding:5px">{{$r->seventy_total}}</td>
                                                <td style="border-top:0px;padding:5px">{{round($r->thirty)}}</td>
                                                <td style="border-top:0px;border-right: 0px solid black;">
                                                    <table>
                                                        <tr>
                                                            <td style="border-right:0px;">
                                                                {{$r->total}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border-right:0px;border-top:2px solid black">
                                                                {{$r->grade}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                            @else
                                <td>
                                    @if ($r->is_absent)
                                        AB
                                    @else
                                        <table class="custom_table">
                                            <tr>
                                                <td style="border-right:0px;">
                                                    {{round($r->seventy)}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-right:0px;border-top:2px solid black">{{$r->grade}}</td>
                                            </tr>
                                        </table>
                                    @endif
                                </td>
                            @endif
                        @endif

                    @endforeach
                </tr>
            @endforeach

        </tbody>
    </table>

</div>
<a class="btn btn-primary btn-sm" href="{{route('pdf.charman-result-full-mark.show',[$exam_id,$semester_id])}}">Full Mark PDF</a>
<br><br><br><br>
@endsection
