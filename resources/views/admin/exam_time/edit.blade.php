@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Update Exam Time</h2>
            </div>

            <div class="panel-body">
                {{-- some change need
                must be set form action
                --}}

                <form class="form-horizontal" action="{{ route('exam-time.update', $exam_time->id) }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }} {{ method_field('put')}}
                    @include('includes.errors')

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Exam Month</label>
                        <div class="col-sm-6">
                            <select name="exam_month" class="form-control">
                                <option value='{{ $exam_time->exam_month }}'>{{ $exam_time->exam_month }}</option>
                                <option value='Janaury'>Janaury</option>
                                <option value='February'>February</option>
                                <option value='March'>March</option>
                                <option value='April'>April</option>
                                <option value='May'>May</option>
                                <option value='June'>June</option>
                                <option value='July'>July</option>
                                <option value='August'>August</option>
                                <option value='September'>September</option>
                                <option value='October'>October</option>
                                <option value='November'>November</option>
                                <option value='December'>December</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Exam Year</label>
                        <div class="col-sm-6">
                            <input type="text" pattern="\d*" maxlength="4" name="exam_year" class="form-control" value="{{ $exam_time->exam_year }}">
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
