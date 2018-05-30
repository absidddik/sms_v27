@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Batch Enroll Info</h3>
            </div>

            <div class="panel-body">

                {{Form::open(['route'=>'batch-enroll.show','method'=>'get','class'=>'form-horizontal'])}}
                    @include('includes.errors')

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
                        <div class="col-sm-3">
                            <input class="btn btn-success" type="submit" value="Get Info">
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>All Batches</h3>
            </div>

            <div class="panel-body">

                @if (isset($batchEnrolls) && count($batchEnrolls))
                    <table class="table table-border datatable">
                        <thead>
                            <th width="45%">Semester</th>
                            <th width="30%">Batch</th>
                            <th width="25%">Action</th>
                        </thead>

                        <tbody>
                            @foreach ($batchEnrolls as $enroll)
                                <tr>
                                    <td>{{ strtolower($enroll->semester->semester) }} Semester</td>
                                    <td>{{ $enroll->batch->batch_number }}</td>
                                    <td>
                                            {{Form::open(['route'=>['batch-enroll.destroy',$enroll->id],'method'=>'delete'])}}
                                            <a class="btn btn-xs btn-primary" href="{{route('batch-enroll.edit', $enroll->id)}}"><span class="fa fa-edit"> Edit</span></a>
                                            <button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#{{ $enroll->id }}"><span class="glyphicon glyphicon-trash"></span>Delete</button>
                                            <!--  delete Pop Up  -->
                                            <div class="modal fade" id="{{ $enroll->id }}" role="dialog">
                                                @include('includes.delete')
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No batch found!</p>
                @endif

            </div>
        </div>
    </div>


</div>
@endsection
