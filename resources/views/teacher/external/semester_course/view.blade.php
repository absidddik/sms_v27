@extends('layouts.user')

@section('content')
	<div class="row">
		<div class="col-md-5">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Course Details</h4>
				</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<tr>
							<td width="50%">Exam Time</td>
							<td width="50%">{{ $course_e->exam_time->exam_time }}</td>
						</tr>
						<tr>
							<td width="50%">Semester</td>
							<td width="50%">{{ $course_e->semester->semester }}</td>
						</tr>
						<tr>
							<td width="50%">Course Name</td>
							<td width="50%">{{ $course_e->course->name }}</td>
						</tr>
						<tr>
							<td width="50%">Course Code</td>
							<td width="50%">{{ $course_e->course->code }}</td>
						</tr>
						<tr>
							<td width="50%">Credit</td>
							<td width="50%">{{ $course_e->course->credit }}</td>
						</tr>
						<tr>
							<td width="50%">Mark</td>
							<td width="50%">{{ $course_e->course->mark }}</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-body text-center">
					<a href="{{route('external.full-marks.index', [$course_e->exam_time->id, $course_e->course->id, $course_e->semester->id])}}" class="btn btn-info">View Full Result</a>
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Student List</h4>
				</div>
				<div class="panel-body">
					<table class="table table-bordered datatable">
						<thead>
							<th width="25%">Exam Roll</th>
							<th width="50%">Name</th>
							<th width="25%">Action</th>
						</thead>
						<tbody>
							@foreach ($student_enrolls as $student_enroll)
								<tr>
									<td>{{ $student_enroll->student->exam_roll }}</td>
									<td>{{ $student_enroll->student->name }}</td>
									<td class="text-center">
										<a class="btn btn-success" href="{{ route('external.seventy-percetn-mark.edit',['course_e_id'=>$course_e->id,'student_id'=>$student_enroll->student->id]) }}">70% Mark</a></li>

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
