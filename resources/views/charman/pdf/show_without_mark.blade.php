
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/bootstrap.css')}}"/>
    <style>

        .inner_table{
            text-align: center;
            line-height: 20px;
            border-top: 1px solid black;
        }

        .z_padding{
            padding: 0!important;
        }
        .table tr  th,.table  tr  td{
            text-align: center;
            line-height: 15px !important;
            font-size: 11px !important;
            border-color: 1px solid black !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        table tr  th,table  tr  td{
            text-align: center;
            line-height: 15px !important;
            border-color: 1px solid black !important;
            padding: 0 !important;
            margin: 0 !important;
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
        .tp tbody tr td {
            padding-left: 5px !important;
            padding-right: 5px !important;
        }
</style>
</head>
<body>
    <div class="col-sm-12">
        <table>
            <tr>
                <td width="425px">
                    <div class="col-sm-4">
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
                </td>
                <td width="450px">
                    <div class="col-sm-4 text-center">
                        <h3 class="topview">Gono Bishwabidyalay</h3>
                        <h3 class="topview">Savar,Dhaka</h3>
                    </div>
                </td>
                <td width="400px">
                    <div class="col-sm-4">
                        <table style="border: 3px solid black;">
                                <td style="font-size: 25px;"><p style="padding: 10px 10px 20px 10px !important">Computer Science <br><br> & Engineering</p></td>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
        <div class="col-sm-12 text-center">
            <p><b><i>Provisional Result of B.Sc (Hons.) CSE {{ strtolower($batch_e->semester->semester) }} semester ({{ $batch_e->batch->batch_number }} Batch) Final Examination - {{ $batch_e->exam_time->exam_month.','.$batch_e->exam_time->exam_year }}</i></b></p>
        </div>
    </div>
    <div class="col-sm-12" style="padding-top: 15px;">
        <table class="table table-bordered">
            @php
                $i=0;
                $j=0;
            @endphp
            @foreach ($full_results as $roll => $course_results)
                @if ($j==0 || $i==13 || $j==22 )
                    @php
                        $j=1;
                    @endphp
                    <tr>
                        <th class="text-center">Exam <br>Roll <br>No.</th>
                        <th class="text-center">Name of the Students</th>
                        @if (!empty($courses))
                            @foreach ($courses as $c)
                                <th class="z_padding">
                                    <table style="width: 100%">
                                            <tr>
                                                <th style="height: 60px" class="inner_table" colspan="2">{{$c->name}}</th>
                                            </tr>
                                            <tr>
                                                <th class="inner_table" colspan="2">{{$c->code}}</th>
                                            </tr>
                                            <tr>
                                                <th class="inner_table" colspan="2">{{$c->mark}}</th>
                                            </tr>
                                            <tr>
                                                <th class="inner_table" style="border-right: 1px solid black">Marks</th>
                                                <th class="inner_table">Grade</th>
                                            </tr>
                                    </table>
                                </th>
                            @endforeach
                        @endif
                        <th class="text-center">Result</th>
                    </tr>
                @endif
                @php
                    $i++;
                    $j++;
                @endphp
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
        </table>
        <p><b>&nbsp;&nbsp;&nbsp;NB: This result is provisionally published subject to the approval of the Syndicate</b></p>
    </div>

    <div style="padding-top: 20px;" class="col-sm-12">
        <table>
            <tbody>
                <tr>
                    <td width="500px">
                        <div style="text-align: left">
                            <p class="bottomview">Copy to</p>
                            <ol style="padding-left: 40px; ">     
                                <li>Rell-istrar, GB.</li> 
                                <li>Dean of the Faculty of the Physical and Mathematical Sciences, GB.</li> 
                                <li>Head of the Department of CSE, GB. </li>
                                <li>Chief Accounts Officer, GB.</li> 
                                <li>Notice Board.</li> 
                                <li>Office File. </li>
                            </ol>
                        </div>
                    </td>
                    <td width="300px"></td>
                    <td width="400px">
                        <br>
                        <div class="text-center"">
                            <p class="bottomview">Controller of Examinations</p>
                            <p class="bottomview">Gono Bishwabidyalay</p>
                            <p class="bottomview">Savar, Dhaka. </p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

