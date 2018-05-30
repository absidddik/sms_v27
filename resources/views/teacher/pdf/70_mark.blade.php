<!DOCTYPE html>
<html>
<head>
	<title> .</title>
	<link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/bootstrap.css')}}"/>
	<style type="text/css">
        .bordersolid{
        	
        }
        table tr th,table tr td{
        	line-height: 20px !important;
        	padding: 0 !important;
        	margin:  !important;
        	border-color: 1px solid black!important;
        }
    </style>
</head>
<body>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="text-center">
				<p style="font-size: 30px">Gono Bishwabidyalay</p>
				<p>Nolam, Mirzanagar, Savar, Dhaka-1344</p>
				<p style="font-size: 25px">Examination Detail Number</p>
				<p style="font-size: 18px">
					{{ strtolower($ce_detail->semester->semester) }} Semester Final Examination
					{{ $ce_detail->exam_time->exam_month.' '.$ce_detail->exam_time->exam_year }}
				</p>
				<p><b>Subject:</b> {{ $ce_detail->course->name }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Total:</b> {{ $ce_detail->course->mark }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Course No:</b> {{ $ce_detail->course->code }}</p>
			</div>
		</div>
	</div>

	<br><br><br>

	<div class="row">
		<div class="col-xs-12">
			<table class="table table-bordered text-center">
				<tr>
					<th class="text-center fs" rowspan="2">Exam Roll</th>
					<th class="text-center fs" colspan="15">Mark</th>
					<th class="text-center fs" rowspan="2">Total</th>
				</tr>
				<tr>
					
					<th class="text-center fs">1</th>
					<th class="text-center fs">2</th>
					<th class="text-center fs">3</th>
					<th class="text-center fs">4</th>
					<th class="text-center fs">5</th>
					<th class="text-center fs">6</th>
					<th class="text-center fs">7</th>
					<th class="text-center fs">8</th>
					<th class="text-center fs">9</th>
					<th class="text-center fs">10</th>
					<th class="text-center fs">11</th>
					<th class="text-center fs">12</th>
					<th class="text-center fs">13</th>
					<th class="text-center fs">14</th>
					<th class="text-center fs">15</th>
				</tr>

				@php
					$i=0;
					$j=0;
				@endphp

				@if ($results)
					@foreach ($results as $r)
						@if ($r->is_absent===0)
							<tr>
								<td>{{ $r->student->exam_roll }}</td>
								<td>{{ round($r->q_1) }}</td>
								<td>{{ round($r->q_2) }}</td>
								<td>{{ round($r->q_3) }}</td>
								<td>{{ round($r->q_4) }}</td>
								<td>{{ round($r->q_5) }}</td>
								<td>{{ round($r->q_6) }}</td>
								<td>{{ round($r->q_7) }}</td>
								<td>{{ round($r->q_8) }}</td>
								<td>{{ round($r->q_9) }}</td>
								<td>{{ round($r->q_10) }}</td>
								<td>{{ round($r->q_11) }}</td>
								<td>{{ round($r->q_12) }}</td>
								<td>{{ round($r->q_13) }}</td>
								<td>{{ round($r->q_14) }}</td>
								<td>{{ round($r->q_15) }}</td>
								<td>{{ round($r->total) }}</td>
							</tr>
						@endif
					@endforeach
				@endif
			</table>
		</div>
	</div>
</body>
</html>