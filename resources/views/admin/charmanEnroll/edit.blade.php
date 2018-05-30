@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left" style="margin-right: 10px;">
                    {{Form::open(['route'=>'charman-enroll.show','method'=>'get'])}}
                        <input type="hidden" name="semester_id" value="{{ $charmanEnroll->semester_id }}">
                        <input class="btn btn-xs btn-default" type="submit" value="<< Back">
                    </form>
                </div>
                <h3>Edit Charman Enroll</h3>
            </div>

            <div class="panel-body">

                {{Form::model($charmanEnroll,['route'=>['charman-enroll.update',$charmanEnroll->id],'method'=>'put','class'=>'form-horizontal'])}}
                    @include('includes.errors')


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Exam Time</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="exam_time">
                                <option value="{{ $charmanEnroll->exam_time_id }}">{{ $charmanEnroll->exam_time->exam_month.' '.$charmanEnroll->exam_time->exam_year }}</option>
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
                        <label class="col-sm-3 control-label">Semester</label>
                        <div class="col-sm-6">
                            {{Form::select('semester',[''=>'Choose']+$semesters,$charmanEnroll->semester_id,['class'=>'form-control'])}}
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-3 control-label">Charman</label>
                        <div class="col-sm-6">
                            <select class="form-control" name="charman">
                                <option value="{{ $charmanEnroll->charman_id }}">{{ $charmanEnroll->charman->name }} [{{ $charmanEnroll->charman->email }}]</option>
                                <option value="">Choose</option>
                                @if ($charmans)
                                    @foreach ($charmans as $charman)
                                        <option value="{{ $charman->user_id }}">{{ $charman->name }} [{{ $charman->email }}]</option>
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

                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@endsection
