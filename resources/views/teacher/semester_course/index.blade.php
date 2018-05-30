@extends('layouts.user')
@section('styles')
	<style type="text/css">
		/*li.borderless {
		  border: 0 none;
		}*/
	</style>
@endsection
@section('content')

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Semester Course</h4>
				</div>
				<div class="panel-body">
					<div class="col-md-6" style="font-size: 15px">
						@php
							echo $semester_course;
						@endphp
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
