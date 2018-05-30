@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Charman Enroll Info</h3>
            </div>

            <div class="panel-body">

                {{Form::open(['route'=>'charman-enroll.show','method'=>'get','class'=>'form-horizontal'])}}
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
                <h3>All Charman</h3>
            </div>

            <div class="panel-body">

                @if (isset($charmanEnrolls) && count($charmanEnrolls))
                    <table class="table table-border datatable">
                        <thead>
                            <th>Charman</th>
                            <th>Action</th>
                        </thead>

                        <tbody>
                            @foreach ($charmanEnrolls as $enroll)
                                <tr>
                                    <td>
                                        <p><b>{{ $enroll->charman->name }}</b></p>
                                        <p style="margin:0">{{ $enroll->charman->email }}</p>
                                    </td>
                                    <td>
                                            {{Form::open(['route'=>['charman-enroll.destroy',$enroll->id],'method'=>'delete'])}}
                                            <a class="btn btn-xs btn-primary" href="{{route('charman-enroll.edit', $enroll->id)}}"><span class="fa fa-edit"> Edit</span></a>
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
