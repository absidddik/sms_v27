@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>External Enroll Info</h3>
            </div>

            <div class="panel-body">

                {{Form::open(['route'=>'external-enroll.show','method'=>'get','class'=>'form-horizontal'])}}
                    @include('includes.errors')

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Semester</label>
                        <div class="col-sm-4">
                            {{Form::select('semester_id',[''=>'Choose']+$semesters,null,['class'=>'form-control'])}}
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
                <h3>All External</h3>
            </div>

            <div class="panel-body">

                @if (isset($externalEnrolls) && count($externalEnrolls))
                    <table class="table table-border datatable">
                        <thead>
                            <th>Course</th>
                            <th>Course Code</th>
                            <th>External Teacher</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            @foreach ($externalEnrolls as $enroll)
                                <tr>
                                    <td>{{ $enroll->course->name }}</td>
                                    <td>{{ $enroll->course->code }}</td>
                                    <td>
                                        <p><b>{{ $enroll->teacher->name }}</b></p>
                                        <p style="margin:0">{{ $enroll->teacher->email }}</p>
                                    </td>
                                    <td>
                                            {{Form::open(['route'=>['external-enroll.destroy',$enroll->id],'method'=>'delete'])}}
                                            <a class="btn btn-xs btn-primary" href="{{route('external-enroll.edit', $enroll->id)}}"><span class="fa fa-edit"> Edit</span></a>
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
                    <p>No course found!</p>
                @endif

            </div>
        </div>
    </div>


</div>
@endsection
