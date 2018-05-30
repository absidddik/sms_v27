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
		<a class="btn btn-default" href="{{route('internal.result.thirty.show', ['course_e_id'=>$course_e->id,'semester_id'=>$course_e->semester_id])}}">Back</a>
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
					<h4>30% Mark</h4>
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
					{!! Form::open(['route' => $route ,'method'=>'post','class'=>'form-horizontal','id'=>'myform']) !!}
		                @include('includes.errors')
						<div class="form-group">
							{!! Form::label('tutorial_1','Tutorial 1', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('tutorial_1','0', ['class'=>'form-control itpm','id'=>'tutorial_1','min'=>0,'max'=>10]) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('tutorial_2','Tutorial 2', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('tutorial_2','0', ['class'=>'form-control itpm','id'=>'tutorial_2','min'=>0,'max'=>10]) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('tutorial_3','Tutorial 3', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('tutorial_3','0', ['class'=>'form-control itpm','id'=>'tutorial_3','min'=>0,'max'=>10]) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('prefer_tutorial','Prefer Tutorial', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-3">
								{!! Form::select('prefer_tutorial_id', $prefer_tutorial, null, ['class'=>'form-control itpm','id'=>'prefer_tutorial','min'=>0,'max'=>10]) !!}
							</div>
							<div class="col-md-3">
								{!! Form::number('prefer_tutorial','0', ['class'=>'readonly_input','readonly'=>'readonly','id'=>'pt_result']) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('mid_term','Mid-term', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('mid_term','0', ['class'=>'form-control itpm','id'=>'mid_term','min'=>0,'max'=>10]) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('attendance','Attendance', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('attendance','0', ['class'=>'form-control itpm','id'=>'attendance','min'=>0,'max'=>10]) !!}
							</div>
						</div>
						<div class="form-group">
							{!! Form::label('total','Total', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('total','0', ['class'=>'readonly_input','readonly'=>'readonly','id'=>'total']) !!}
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
		$('.itpm').keyup(function(){


    		var tutorial_1 = parseFloat($('#tutorial_1').val());
    		var tutorial_2 = parseFloat($('#tutorial_2').val());
    		var tutorial_3 = parseFloat($('#tutorial_3').val());
    		var prefer_tutorial = $('#prefer_tutorial').val();
    		var mid_term = parseFloat($('#mid_term').val());
    		var attendance = parseFloat($('#attendance').val());

    		var tutorials = new Array();

    		tutorials[0] = tutorial_1;
    		tutorials[1] = tutorial_2;
    		tutorials[2] = tutorial_3;


    		function sortNumber(a,b) {
			    return a - b;
			}

    		tutorials.sort(sortNumber);

    		var pt_result = 0;

    		switch(prefer_tutorial) {
    		    case '1':
    		        pt_result = tutorials[2];
    		        break;
    		    case '2':
    		        pt_result = (tutorials[2]+tutorials[1])/2;
    		        break;
    		    case '3':
    		        pt_result = (tutorial_1+tutorial_2+tutorial_3)/3;
    		        break;
    		}
    		$('#pt_result').val(Math.ceil(pt_result));
    		$('#total').val(Math.ceil(pt_result+mid_term+attendance));
		});

		$('.itpm').change(function(){


    		var tutorial_1 = parseFloat($('#tutorial_1').val());
    		var tutorial_2 = parseFloat($('#tutorial_2').val());
    		var tutorial_3 = parseFloat($('#tutorial_3').val());
    		var prefer_tutorial = $('#prefer_tutorial').val();
    		var mid_term = parseFloat($('#mid_term').val());
    		var attendance = parseFloat($('#attendance').val());

    		var tutorials = new Array();

    		tutorials[0] = tutorial_1;
    		tutorials[1] = tutorial_2;
    		tutorials[2] = tutorial_3;


    		function sortNumber(a,b) {
			    return a - b;
			}

    		tutorials.sort(sortNumber);

    		var pt_result = 0;

    		switch(prefer_tutorial) {
    		    case '1':
    		        pt_result = tutorials[2];
    		        break;
    		    case '2':
    		        pt_result = (tutorials[2]+tutorials[1])/2;
    		        break;
    		    case '3':
    		        pt_result = (tutorial_1+tutorial_2+tutorial_3)/3;
    		        break;
    		}
    		$('#pt_result').val(Math.ceil(pt_result));
    		$('#total').val(Math.ceil(pt_result+mid_term+attendance));
		});


		$(document).ready(function(){

			var credit = parseInt($('#credit').val());

			if (credit == 2) {
				$('#tutorial_1').prop('max',5);
				$('#tutorial_2').prop('max',5);
				$('#tutorial_3').prop('max',5);
				$('#mid_term').prop('max',5);
				$('#attendance').prop('max',5);
			}

    	});



		$(document).ready(function(){

    		//validation
    		$(function(){

    			$("#myform").validate({
    				rules:
    				{

    				}
    			});
    		});

    	});
	</script>
@endsection
