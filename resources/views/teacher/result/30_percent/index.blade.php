@extends('layouts.user')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Semester Course</h4>
				</div>
				<div class="panel-body">
					@php
						echo $semester_course;
					@endphp
				</div>
			</div>
		</div>
	</div>
@endsection
