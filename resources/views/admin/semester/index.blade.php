@extends('layouts.admin')

@section('content')
    <div class="col-sm-12">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">Create Semester</div>
                @include('includes.errors')
                <div class="panel-body">
                    {{Form::open(['route'=>'semester.store','method'=>'post'])}}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Semester:</label>
                        <div class="col-sm-9">
                            {{Form::text('semester',null,['class'=>'form-control'])}}
                        </div>
                    </div>
                    <br><br><br>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="pull-right">
                                {{Form::submit('Submit',['class'=>'btn btn-success'])}}
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">All Semester</div>
                <div class="panel-body">
                    @if (isset($semesters) && count($semesters))
                        <table class="table table-border">
                            <thead>
                                <th>semester semester</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($semesters as $semester)
                                    <tr>
                                        <td>{{$semester->semester}}</td>
                                        <td>
                                            <a href="{{route('semester.edit',$semester->id)}}" class="btn btn-info pull-left">Edit</a>
                                            {{Form::open(['route'=>['semester.destroy',$semester->id],'method'=>'delete'])}}
                                            &nbsp;&nbsp;&nbsp;
                                            {{Form::submit('Delete',['class'=>'btn btn-danger','onclick' => 'return confirm("Are you sure you want to delete?")'])}}
                                            {{Form::close()}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <p>No data found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
