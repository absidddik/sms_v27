<!DOCTYPE html>
<html>
<head>
	<title> .</title>
	<link rel="stylesheet" type="text/css" id="theme" href="{{asset('css/bootstrap.css')}}"/>
	<style type="text/css">
		.borderless td, .borderless th {
			border: none !important;
		}

        .bordersolid{
        	border-color: 1px solid black!important;
        }
    </style>
</head>
<body>
	
	<div class="row">
		<div class="col-xs-12">
			<table>
				<tbody>
					<tr>
						<td width="70%">
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
						</td>
						<td width="30%">
							<table border="1">
								<thead>
									<tr>
										<th width="70%">Numerical Grade</th>
										<th width="15%">Letter Grade</th>
										<th width="15%">Grade Point</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>80% and above</td>
										<td style="text-align:center">A+</td>
										<td style="text-align:center">4.00</td>
									</tr>
									<tr>
										<td>75% to less than 80%</td>
										<td style="text-align:center">A</td>
										<td style="text-align:center">3.75</td>
									</tr>
									<tr>
										<td>70% to less than 75%</td>
										<td style="text-align:center">A-</td>
										<td style="text-align:center">3.50</td>
									</tr>
									<tr>
										<td>65% to less than 70%</td>
										<td style="text-align:center">B+</td>
										<td style="text-align:center">3.25</td>
									</tr>
									<tr>
										<td>60% to less than 65%</td>
										<td style="text-align:center">B</td>
										<td style="text-align:center">3.00</td>
									</tr>
									<tr>
										<td>55% to less than 60%</td>
										<td style="text-align:center">B-</td>
										<td style="text-align:center">2.75</td>
									</tr>
									<tr>
										<td>50% to less than 55%</td>
										<td style="text-align:center">C+</td>
										<td style="text-align:center">2.50</td>
									</tr>
									<tr>
										<td>45% to less than 50%</td>
										<td style="text-align:center">C</td>
										<td style="text-align:center">2.25</td>
									</tr>
									<tr>
										<td>40% to less than 45%</td>
										<td style="text-align:center">D</td>
										<td style="text-align:center">2.00</td>
									</tr>
									<tr>
										<td>Less than 40%</td>
										<td style="text-align:center">F</td>
										<td style="text-align:center">0.00</td>
									</tr>
								</tbody>
							</table>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<br><br><br>

	<div class="row">
		<div class="col-xs-12">
			<table class="table table-bordered text-center">
				<tr>
					<th class="text-center bordersolid" rowspan="2"><br><br>Exam Roll <br>No.</th>
					<th class="text-center bordersolid" rowspan="2"><br><br>Theoretical <br>Marks <br>70/35</th>
					<th class="text-center bordersolid" colspan="3"><br>Continuous Evaluation Marks 30/15</th>
					<th class="text-center bordersolid" rowspan="2"><br><br>Total <br>100/50</th>
					<th class="text-center bordersolid" rowspan="2"><br><br>Grade</th>
				</tr>
				<tr>
					<td class="bordersolid">Attendance <br>10/5</td>
					<td class="bordersolid">Class Test/Home <br>Assignment/<br>Language Viva <br>10/5</td>
					<td class="bordersolid">Midterm/<br>Card Final <br>10/5</td>
				</tr>

				@php
					$i=0;
					$j=0;
				@endphp

				@if ($results)
					@foreach ($results as $result)
						<tr>
							<td class="bordersolid">{{ $result->exam_roll }}</td>
							<td class="bordersolid">{{ round($result->seventy_total) }}</td>
							<td class="bordersolid">{{ round($result->attendance) }}</td>
							<td class="bordersolid">{{ round($result->prefer_tutorial) }}</td>
							@if ($c_show['t'])
								<td class="bordersolid">{{ round($result->mid_term) }}</td>
							@endif
							<td class="bordersolid">{{ round($result->seventy_total + $result->total) }}</td>
							<td class="bordersolid">{{ grade($result->seventy_total + $result->total) }}</td>
						</tr>

						@php
							$j++;
							$i++;
						@endphp

						@if ($i==13 || $j==22)
							<tr>
								<th class="text-center bordersolid" rowspan="2"><br><br>Exam Roll <br>No.</th>
								<th class="text-center bordersolid" rowspan="2"><br><br>Theoretical <br>Marks <br>70/35</th>
								<th class="text-center bordersolid" colspan="3"><br>Continuous Evaluation Marks 30/15</th>
								<th class="text-center bordersolid" rowspan="2"><br><br>Total <br>100/50</th>
								<th class="text-center bordersolid" rowspan="2"><br><br>Grade</th>
							</tr>
							<tr>
								<td class="bordersolid">Attendance <br>10/5</td>
								<td class="bordersolid">Class Test/Home <br>Assignment/<br>Language Viva <br>10/5</td>
								<td class="bordersolid">Midterm/<br>Card Final <br>10/5</td>
							</tr>
							@php
								$j=0;
							@endphp
						@endif
					@endforeach
				@endif
			</table>
		</div>
	</div>
</body>
</html>