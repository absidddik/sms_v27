@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>List of Exam Time</h2>
            </div>
            <div class="panel-body">
                <table class="table datatable">
                    <thead>
                      <th width="20%">Serial No</th>
                      <th width="50%">Exam Time</th>
                      <th width="30%">Action</th>
                    </thead>
                    <tbody>
                    @php
                        $i = 1;
                    @endphp
                      @if ($exam_times)
                        @foreach ($exam_times as $exam_time)
                        <tr>
                          <td>{{ $i++ }}</td>
                          <td>{{ $exam_time->exam_month.' '.$exam_time->exam_year }}</td>
                            <td>
                                <form action="{{ route('exam-time.destroy', $exam_time->id) }}" method="post">
                                    {{ csrf_field() }} {{ method_field('delete') }}

                                    <a class="btn btn-primary" href="{{route('exam-time.edit', $exam_time->id)}}"><span class="fa fa-edit"> Edit</span></a>


                                    {{-- some change need
                                            data-target 1 changed by databse id
                                            and then id of the next line changed by the same database id
                                            and must be set form action
                                    --}}

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#{{ $exam_time->id }}"><span class="glyphicon glyphicon-trash"></span>Delete</button>
                                    <!-- -------------------- delete Pop Up --------------------------- -->
                                    <div class="modal fade" id="{{ $exam_time->id }}" role="dialog">
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
