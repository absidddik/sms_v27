@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Update Batch</h2>
            </div>

            <div class="panel-body">
                {{-- some change need
                must be set form action
                --}}

                <form class="form-horizontal" action="{{ route('batch.update', $batch->id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }} {{ method_field('put')}}
                    @include('includes.errors')


                    <div class="form-group">
                        <label class="col-sm-3 control-label">Batch Number</label>
                        <div class="col-sm-6">
                            <input type="text" name="batch_number" class="form-control" value="{{ $batch->batch_number }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Session</label>
                        <div class="col-sm-6">
                            <input type="text" name="session" class="form-control" value="{{ $batch->session }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"></label>
                        <div class="col-sm-6">
                            <div class="pull-right">
                                <input class="btn btn-success" type="submit" value="Update">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
