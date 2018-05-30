@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Create</h2>  
            </div>

            <div class="panel-body">
                {{-- some change need             
                must be set form action 
                --}}

                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @include('includes.errors')


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-6">
                            <input type="text" name="" class="form-control">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-6">
                            <input type="text" name="" class="form-control">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Password</label>
                        <div class="col-sm-6">
                            <input type="password" name="" class="form-control">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Date of birth</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input name="" type="text" class="form-control datepicker" value="" placeholder="yyyy-mm-dd"> 
                                <span class="input-group-addon"><span class="fa fa-calendar"></span>
                            </div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Gender</label>
                        <div class="col-sm-6">                                                                                            
                            <select name="" class="form-control select">
                                <option value="">Select Gender</option>
                                <option value="1">Male</option>
                                <option value="2">Female</option>
                                <option value="3">Other's</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Address</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" rows="6" name=""></textarea>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Education Qualification</label>
                        <div class="col-sm-6">
                            <textarea class="form-control summernote" rows="6" name=""></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Web Url</label>
                        <div class="col-sm-6">
                            <input type="text" name="" class="form-control" value="http://www.facebook.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Image</label>
                        <div class="col-sm-6">
                            <input class="fileinput btn-primary" type="file" name="" value="">
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
            <div class="panel-footer">
                <div class="pull-right">
                    <input class="btn btn-success" type="submit" value="Save">
                    <input class="btn btn-danger" type="reset" value="Reset">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
