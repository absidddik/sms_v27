@extends('layouts.admin')

@section('breadcrumb')
    <ul class="breadcrumb">
        <li><a href="{{ route('student.index') }}">List of Student</a></li>
        <li class="active">{{ $student->name }}</li>
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-sm-4">
                        @if ($student->image)
                            <img class="img-responsive" src="{{ asset('storage/student/'.$student->image)}}" alt="N/A">
                        @else
                            <img class="img-responsive" src="{{ asset('images/default/student.jpg')}}" alt="No Image">
                        @endif
                    </div>
                    <div class="col-sm-8">
                        <table class="table no-border">
                            <tr>
                                <td width="40%">Name</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->name }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Email</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->email }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Batch</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->batch->batch_number }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Class Roll</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->class_roll }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Exam Roll</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->exam_roll }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Registration</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->reg_no }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Gender</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->gender }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Phone</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->phone }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Blood Group</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->blood_group }}</td>
                            </tr>

                            <tr>
                                <td width="40%">Guardian</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->guardian }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Guardian Contact</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->guardian_contact }}</td>
                            </tr>
                            <tr>
                                <td width="40%">Status</td>
                                <td width="1%">:</td>
                                <td width="59%">{{ $student->isActive()?'Active':'Deactive' }}</td>
                            </tr>
                        </table>
                        <form action="{{ route('student.destroy', $student->id) }}" method="post">
                            {{ csrf_field() }} {{ method_field('delete') }}

                            <a class="btn btn-primary" href="{{ route('student.edit', $student->id) }}"><span class="fa fa-edit"> Edit</span></a>

                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#{{ $student->id }}"><span class="glyphicon glyphicon-trash"></span>Delete</button>
                            <!-- -------------------- delete Pop Up --------------------------- -->
                            <div class="modal fade" id="{{ $student->id }}" role="dialog">
                                @include('includes.delete')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
