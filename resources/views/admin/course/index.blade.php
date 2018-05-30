@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>List of course</h3>
                </div>
                <div class="panel-body">
                    <table class="table datatable">
                        <thead>
                            <th>Course Type</th>
                            <th>Course Name</th>
                            <th>Course Code</th>
                            <th>Course Credit</th>
                            <th>Course Mark</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @if ($courses)
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $course->getType() }}</td>
                                        <td>{{ $course->name }}</td>
                                        <td>{{ $course->code }}</td>
                                        <td>{{ $course->credit }}</td>
                                        <td>{{ $course->mark }}</td>
                                        <td>
                                            <form action="{{ route('course.destroy', $course->id) }}" method="post">
                                                {{ csrf_field() }} {{ method_field('delete') }}

                                                <a class="btn btn-primary" href="{{route('course.edit', $course->id)}}"><span class="fa fa-edit"> Edit</span></a>

                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#{{ $course->id }}"><span class="glyphicon glyphicon-trash"></span>Delete</button>
                                                <!--  delete Pop Up  -->
                                                <div class="modal fade" id="{{ $course->id }}" role="dialog">
                                                    @include('includes.delete')
                                                </div>
                                            </form>
                                        </td>
                                    @endforeach
                                @endif
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
