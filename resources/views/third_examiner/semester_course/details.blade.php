@extends('layouts.user')

@section('styles')
<style media="screen">
	.error {
		color:red;
	}
</style>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Course Details</h4>
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tr>
								<td width="25%"><b>Exam Time</b></td>
								<td width="25%">{{ $exam_time->exam_month.' '.$exam_time->exam_year }}</td>
								<td width="25%"><b>Semester</b></td>
								<td width="25%">{{ $semester->semester }}</td>
							</tr>
							<tr>
								<td width="25%"><b>Course Name</b></td>
								<td width="25%">{{ $course->name }}</td>
								<td width="25%"><b>Course Code</b></td>
								<td width="25%">{{ $course->code }}</td>
							</tr>
							<tr>
								<td width="25%"><b>Credit</b></td>
								<td width="25%">{{ $course->credit }}</td>
								<td width="25%"><b>Mark</b></td>
								<td width="25%">{{ $course->mark }}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Difference Mark List</h4>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<ul class="list-group">
						<table class="table table-bordered">
							<thead>
								<th>Exam Roll</th>
								<th>Internal Examiner 70% Mark</th>
								<th>External Examiner 70% Mark</th>
								<th>Difference Mark</th>
								<th>Third Examiner 70% Mark</th>
								<th>Action</th>
							</thead>
							<tbody>
								@foreach ($results as $r)
									<tr>
										<td>{{ $r->stu_exam_roll }}</td>
										<td>{{ $r->inter_total }}</td>
										<td>{{ $r->ex_total }}</td>
										<td>{{ $r->difference }}</td>
										<td>{{ $r->third_total }}</td>
										<td><a class="btn btn-info btn-sm" href="{{ route('third-examiner.seventy-percetn-mark.edit',['course_e_id'=>$r->course_e_id,'student_id'=>$r->student_id]) }}">Edit</a></td>
									</tr>
								@endforeach
							</tbody>
						</table>

						
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
