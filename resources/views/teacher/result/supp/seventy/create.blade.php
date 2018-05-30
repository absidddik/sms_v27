@extends('layouts.user')

@section('styles')
	<style media="screen">
	    .table-bordered>tbody>tr>td, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>td, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>thead>tr>th {
	        border: 1px solid #ddd;
	        padding: 3px;
	    }
	    .form-horizontal .form-group {
	        margin-right: -15px;
	        margin-left: -15px;
	        margin: 1px;
	    }
	    .form-control {
	        display: block;
	        width: 100%;
	        height: auto;
	        padding: 3px;
	        font-size: 12px;
	        line-height: 1.42857143;
	        color: #555;
	        background-color: #fff;
	        background-image: none;
	        border: 1px solid #ccc;
	        border-radius: 4px;
	        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	        box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
	        -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
	        -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	        transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	    }
	    .form-horizontal .control-label {
	        font-weight: normal;;
	    }
	    .error {
	        color:red;
	    }
	</style>
@endsection

@section('content')
<div class="row">

	<div class="col-sm-5">
		<a class="btn btn-default" href="{{route('result.supp.show', ['course_e_id'=>$course_e->id,'semester_id'=>$course_e->semester_id])}}">Back</a>
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
								<td width="50%">{{ $supp_e->exam_time->exam_month.' '.$supp_e->exam_time->exam_year }}</td>
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
					<h4>Supplementary / Improvement Mark</h4>
				</div>
				<style type="text/css">
					.readonly_input{
						border: 0 none;
						border-color: white;
						background-color: white;
						padding-top: 7px;
						padding-left: 4px;
					}
				</style>
				<div class="panel-body">
					{!! Form::open(['route' => $route ,'method'=>'post','class'=>'form-horizontal','id'=>'myform']) !!}
		                @include('includes.errors')

						<div class="form-group">
							{!! Form::label('q_1','Question 1', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_1','0', ['class'=>'form-control q','id'=>'q_1','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_2','Question 2', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_2','0', ['class'=>'form-control q','id'=>'q_2','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_3','Question 3', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_3','0', ['class'=>'form-control q','id'=>'q_3','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_4','Question 4', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_4','0', ['class'=>'form-control q','id'=>'q_4','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_5','Question 5', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_5','0', ['class'=>'form-control q','id'=>'q_5','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_6','Question 6', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_6','0', ['class'=>'form-control q','id'=>'q_6','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_7','Question 7', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_7','0', ['class'=>'form-control q','id'=>'q_7','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_8','Question 8', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_8','0', ['class'=>'form-control q','id'=>'q_8','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_9','Question 9', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_9','0', ['class'=>'form-control q','id'=>'q_9','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_10','Question 10', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_10','0', ['class'=>'form-control q','id'=>'q_10','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_11','Question 11', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_11','0', ['class'=>'form-control q','id'=>'q_11','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_12','Question 12', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_12','0', ['class'=>'form-control q','id'=>'q_12','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_13','Question 13', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_13','0', ['class'=>'form-control q','id'=>'q_13','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_14','Question 14', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_14','0', ['class'=>'form-control q','id'=>'q_14','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('q_15','Question 15', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('q_15','0', ['class'=>'form-control q','id'=>'q_15','min'=>0,'max'=>14]) !!}
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('total','Total', ['class'=>'control-label col-md-3']) !!}
							<div class="col-md-6">
								{!! Form::number('total','0', ['class'=>'readonly_input','readonly'=>'readonly','id'=>'total','min'=>0,'max'=>70]) !!}
							</div>
						</div>


						<input type="hidden" name="semester_id"	value="{{ $course_e->semester_id }}">
						<input type="hidden" name="course_id"	value="{{ $course_e->course_id }}">
						<input type="hidden" id="credit" name="credit" value="{{ $course_e->course->credit }}">
						<input type="hidden" name="student_id"	value="{{ $student->id }}">
						<input type="hidden" name="exam_time_id"	value="{{ $supp_e->exam_time_id }}">
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

	$(document).ready(function(){

		var credit = parseInt($('#credit').val());

		if (credit == 2) {
			// $('#q_1').prop('max',14);
			// $('#q_2').prop('max',14);
			// $('#q_3').prop('max',14);
			// $('#q_4').prop('max',14);
			// $('#q_5').prop('max',14);
			// $('#q_6').prop('max',14);
			// $('#q_7').prop('max',14);
			// $('#q_8').prop('max',14);
			// $('#q_9').prop('max',14);
			// $('#q_10').prop('max',14);
			// $('#q_11').prop('max',14);
			// $('#q_12').prop('max',14);
			// $('#q_13').prop('max',14);
			// $('#q_14').prop('max',14);
			// $('#q_15').prop('max',14);

			$('#total').prop('max',35);
		}

	});

	$(document).ready(function(){

    //validation
    $(function()
    {
    	$("#myform").validate(
    	{
    		rules:
    		{
    			q_1:
    			{

    				range:[0,14]
    			},

    			q_2:
    			{

    				range:[0,14]
    			},

    			q_3:
    			{

    				range:[0,14]
    			},

    			q_4:
    			{

    				range:[0,14]
    			},

    			q_5:
    			{

    				range:[0,14]
    			},

    			q_6:
    			{

    				range:[0,14]
    			},

    			q_7:
    			{

    				range:[0,14]
    			},

    			q_8:
    			{

    				range:[0,14]
    			},

    			q_9:
    			{

    				range:[0,14]
    			},

    			q_10:
    			{

    				range:[0,14]
    			},

    			q_11:
    			{

    				range:[0,14]
    			},

    			q_12:
    			{

    				range:[0,14]
    			},

    			q_13:
    			{

    				range:[0,14]
    			},

    			q_14:
    			{

    				range:[0,14]
    			},

    			q_15:
    			{

    				range:[0,14]
    			},
    		}
    	});
    });

        //iterate through each textboxes and add keyup
        //handler to trigger sum event
        $(".q").each(function() {

        	$(this).keyup(function(){
        		calculateSum();
        	});
        });

    });

	function calculateSum() {

		var sum = 0;
        //iterate through each textboxes and add the values
        $(".q").each(function() {

            //add only if the value is number
            if(!isNaN(this.value) && this.value.length!=0) {
            	sum += parseFloat(this.value);
            }

        });
        //.toFixed() method will roundoff the final sum to 2 decimal places
        $("#total").val(Math.ceil(sum));
    }
</script>
@endsection
