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
				<h4>{{ strtolower($chairman->semester->semester) }} semester Course List</h4>
				<h4>Exam Time: {{ $chairman->exam_time->exam_month.' '.$chairman->exam_time->exam_year }} </h4>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
					<ul class="list-group">
						@foreach ($courses as $c)
							<a href="{{ route('third-examiner.course-details',['c_id'=>$c->course_id,'s_id'=>$c->semester_id,'et_id'=>$chairman->exam_time_id,]) }}"><li class="list-group-item">{{ $c->name }}</li></a>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
