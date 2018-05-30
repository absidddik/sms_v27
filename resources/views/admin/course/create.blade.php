@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Add Course</h2>
            </div>

            <div class="panel-body">

                {{Form::open(['route'=>'course.store','method'=>'post','class'=>'form-horizontal'])}}
                    @include('includes.errors')


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Course Type</label>
                        <div class="col-sm-6">
                            {{Form::select('type',[''=>'Choose']+$types,1,['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Course Name</label>
                        <div class="col-sm-6">
                            {{Form::text('name',null,['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Course Code</label>
                        <div class="col-sm-6">
                            {{Form::text('code',null,['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Course Credit</label>
                        <div class="col-sm-6">
                            {{Form::select('credit',[''=>'Choose']+$credits,3,['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Course Mark</label>
                        <div class="col-sm-6">
                            {{Form::select('mark',[''=>'Choose']+$marks,100,['class'=>'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Course Content</label>
                        <div class="col-sm-6">
                            {{Form::textarea('content',null,['class'=>'form-control summernote'])}}
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
