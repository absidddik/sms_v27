@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Batch Enroll</h3>
            </div>

            <div class="panel-body">

                {{Form::open(['route'=>'batch-enroll.store','method'=>'post','class'=>'form-horizontal'])}}
                    @include('includes.errors')


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Semester</label>
                        <div class="col-sm-6">
                            {{Form::select('semester',[''=>'Choose']+$semesters,null,['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Batch</label>
                        <div class="col-sm-6">
                            {{Form::select('batch',[''=>'Choose']+$batches,null,['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Exam Time</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="exam_time">
                                <option value="">Choose</option>
                                @if ($exam_times)
                                    @foreach ($exam_times as $exam_time)
                                        <option value="{{ $exam_time->id }}">{{ $exam_time->exam_month.' '.$exam_time->exam_year }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <input class="btn btn-success" type="submit" value="Save">
                                <input class="btn btn-danger" type="reset" value="Reset">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
