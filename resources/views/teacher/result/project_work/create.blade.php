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
	<div class="col-sm-5">
		<a class="btn btn-default" href="{{route('internal.result.viva-voce.show', ['course_e_id'=>$course_e->id,'semester_id'=>$course_e->semester_id])}}">Back</a>
	</div>
	<br><br>
	<div class="col-sm-12">
		<div class="col-md-5">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Course Details</h4>
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tr>
								<td width="50%">Exam Time</td>
								<td width="50%">{{ $course_e->exam_time->exam_month.' '.$course_e->exam_time->exam_year }}</td>
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
			</div>
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4>Student Details</h4>
					</div>
					<div class="panel-body">
						<table class="table table-bordered">
							<tr>
								<td width="50%">Name</td>
								<td width="50%">{{ $student->name }}</td>
							</tr>
							<tr>
								<td width="50%">Exam Roll</td>
								<td width="50%">{{ $student->exam_roll }}</td>
							</tr>
							<tr>
								<td width="50%">Reg. No</td>
								<td width="50%">{{ $student->reg_no }}</td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-7">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Project Work Mark</h4>
				</div>
				<style type="text/css">
					.readonly_input{
						border: 0 none;
						border-color: white;
						background-color: white;
						padding-top: 7px;
						padding-left: 13px;
					}
				</style>
				<div class="panel-body">
					@if (isset($project_work_mark))
					{!! Form::model($project_work_mark,['route' => ['internal.project-work-mark.update',$project_work_mark->id] ,'method'=>'put','class'=>'form-horizontal','id'=>'myform']) !!}
					@else	
					{!! Form::open(['route' => 'internal.project-work-mark.store' ,'method'=>'post','class'=>'form-horizontal','id'=>'myform']) !!}
					@endif

		                @include('includes.errors')
						<div class="form-group">
							{!! Form::label('total','Project Work', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('total',null, ['class'=>'form-control itpm','id'=>'total','required'=>'required','min'=>0,'max'=>100]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('is_absent','Absent', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								<div class="checkbox">
									<label>{{ Form::checkbox('is_absent') }}</label>
								</div>
								
							</div>
						</div>

						<input type="hidden" name="semester_id"	value="{{ $course_e->semester_id }}">
						<input type="hidden" name="course_id"	value="{{ $course_e->course_id }}">
						<input type="hidden" id="credit" name="credit" value="{{ $course_e->course->credit }}">
						<input type="hidden" name="student_id"	value="{{ $student->id }}">
						<input type="hidden" name="exam_time_id"	value="{{ $course_e->exam_time_id }}">
						<input type="hidden" name="course_e_id"	value="{{ $course_e->id }}">

						<div class="form-group">
							{!! Form::label(null,null, ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								<div class="pull-right">
									@if (!$isSubmitted)
										{!! Form::submit('Save', ['class'=>'btn btn-success']) !!}
										@else
											<h3>You already submitted this result.</h3>
									@endif
								</div>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection


@section('scripts')
<script type="text/javascript" src="{{asset('js/jquery/jquery.validate.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery/additional-methods.min.js')}}"></script>

<script type="text/javascript">

	jQuery(document).ready(function() {
	    jQuery('#is_absent').change(function() {
	    	if($(this).prop('checked')==true){
	    		var r = confirm("Are you sure ,this student is absent?\nBecause every question mark is to be 0 if he/she is absent");
	            if (r == true) {
	                $(this).prop('checked', true);
	            }else{
					$(this).prop('checked', false);
	            }
	    	}
	    });
	});
	
</script>
@endsection
