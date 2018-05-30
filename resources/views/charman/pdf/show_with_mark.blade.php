
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/bootstrap.css')}}"/>
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
            border: 1px solid black;
        }
        .inner_table tr td{
            width: 16.17%;
            border-right: 1px solid black;
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
        .z_p{
            padding-bottom: 0 !important; 
        }

        table tr td{
            border-color: 1px solid black !important;
            padding: 0 !important;
        }

        .topview{
            padding: 0 !important;
            line-height: 30px !important;
            margin: 0 !important;
        }
        .bottomview{
            padding: 0 !important;
            line-height: 20px !important;
            margin: 0 !important;
        }
    </style>
</head>
<body >
    <div class="col-sm-12 text-center">
        <h3 class="topview">Gono Bishwabidyalay</h3>
        <h3 class="topview">Department of Computer Science & Engineering</h3>
        <h3 class="topview">{{ strtolower($semester->semester) }} Semester Final Examination, {{ $exam_time->exam_month.'-'.$exam_time->exam_year }}</h3>
        <br>
    </div>

    <div class="col-sm-12" style="overflow-x: auto;color:black">
        <table class="table table-bordered">
            @php
                $i=$j=0;       
            @endphp   
            
            @foreach ($full_results as $roll => $course_results)
                @if ($j==0 || $i==17 || $j==23)
                    @php
                        $j=1;
                    @endphp
                    <tr>
                        <td style="padding-top:5px;">Roll</td>
                        @foreach ($courses as $c)
                        <td style="padding-top:5px;">
                            <p>{{$c->code}}</p>
                            <p style="height: 70px; min-height: 50px;">{{$c->name}}</p>
                            <p>{{$c->mark}}</p>

                            @if ($c->credit == 1)
                                <table class="table border_top inner_table" style="margin-bottom: 0;">
                                    <tr>
                                        <td style="padding:5px">25</td>
                                        <td style="border-right: 0px;padding:5px">Grade</td>
                                    </tr>
                                </table>
                            @elseif ($c->credit == 2)
                                @if ($c->getType() == 'LAB')
                                    <table class="table border_top inner_table" style="margin-bottom: 0;">
                                        <tr>
                                            <td style="padding:5px">50</td>
                                            <td style="border-right: 0px;padding:5px">Grade</td>
                                        </tr>
                                    </table>
                                @else
                                    <table class="table border_top inner_table" style="margin-bottom: 0;">
                                        <tr>
                                            <td style="padding:5px">35</td>
                                            <td style="padding:5px">15</td>
                                            <td style="padding:5px">50</td>
                                            <td style="border-right: 0px;padding:5px">Grade</td>
                                        </tr>
                                    </table>
                                @endif
                            @else
                                <table class="table border_top inner_table" style="margin-bottom: 0;">
                                    <tr>
                                        <td style="padding:5px">70</td>
                                        <td style="padding:5px">30</td>
                                        <td style="padding:5px">100</td>
                                        <td style="border-right: 0px;padding:5px">Grade</td>
                                    </tr>
                                </table>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                @endif
                @php
                    $i++;
                    $j++;
                @endphp
               
                <tr>
                    <td style="padding:5px;border-right: 1px solid black;">{{$roll}}</td>
                    @foreach ($course_results['result'] as $r)
                        @if ($r)
                            @if ($r->is_absent)
                                <td>
                                    <table class="table inner_table" style="margin-bottom: 0;">
                                        <tr>
                                            <td style="border-top:0px;">
                                                AB
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            @else
                                @if ($r->course_credit == 1)
                                    <td>
                                        <table class="table inner_table" style="margin-bottom: 0;">
                                            <tr>
                                                <td style="border-top:0px;">
                                                    {{sprintf("%02d",$r->total)}}
                                                </td>
                                                <td style="border-top:0px;">
                                                    {{sprintf("%02d",$r->total)}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                @elseif ($r->course_credit == 2)
                                    @if ($r->course_type == 'LAB')
                                        <td>
                                            <table class="table inner_table" style="margin-bottom: 0;">
                                                <tr>
                                                    <td style="border-top:0px;">
                                                        {{sprintf("%02d",$r->total)}}
                                                    </td>
                                                    <td style="border-top:0px;">
                                                        {{$r->grade}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @else
                                        <td>
                                            <table class="table inner_table" style="margin-bottom: 0;">
                                                <tr>
                                                    <td style="border-top:0px;">
                                                        {{sprintf("%02d",$r->seventy_total)}}
                                                    </td>
                                                    <td style="border-top:0px;">
                                                        {{sprintf("%02d",$r->thirty)}}
                                                    </td>
                                                    <td style="border-top:0px;">
                                                        {{sprintf("%02d",$r->total)}}
                                                    </td>
                                                    <td style="border-top:0px;">
                                                        {{$r->grade}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        <table class="table inner_table" style="margin-bottom: 0;">
                                            <tr>
                                                <td style="border-top:0px;">
                                                    {{sprintf("%02d",$r->seventy_total)}}
                                                </td>
                                                <td style="border-top:0px;">
                                                    {{sprintf("%02d",$r->thirty)}}
                                                </td>
                                                <td style="border-top:0px;">
                                                    {{sprintf("%02d",$r->total)}}
                                                </td>
                                                <td style="border-top:0px;">
                                                    {{$r->grade}}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                @endif
                            @endif
                        @endif

                    @endforeach
                </tr>
            @endforeach
        </table>
    </div>

    <div style="padding-top: 100px;" class="col-sm-12">
        <table>
            <tbody>
                <tr>
                    <td width="100px">
                        <div class="text-center">
                            <p class="bottomview">Chairman</p>
                            <p class="bottomview">{{ strtolower($semester->semester) }} Semester Examination Committee</p>
                        </div>
                    </td>
                    <td width="745px"></td>
                    <td width="100px">
                        <div class="text-center"">
                            <p class="bottomview">Tebulator</p>
                            <p class="bottomview">{{ strtolower($semester->semester) }} Semester Examination Committee</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>
