@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>List of Batch</h2>
            </div>
            <div class="panel-body">
                <table class="table datatable">
                    <thead>
                      <th>Batch Number</th>
                      <th>Session</th>
                      <th>Action</th>
                    </thead>
                    <tbody>
                      @if ($batches)
                        @foreach ($batches as $batch)
                        <tr>
                          <td>{{ $batch->batch_number }}</td>
                          <td>{{ $batch->session }}</td>
                            <td>
                                <form action="{{ route('batch.destroy', $batch->id) }}" method="post">
                                    {{ csrf_field() }} {{ method_field('delete') }}

                                    <a class="btn btn-primary" href="{{route('batch.edit', $batch->id)}}"><span class="fa fa-edit"> Edit</span></a>


                                    {{-- some change need
                                            data-target 1 changed by databse id
                                            and then id of the next line changed by the same database id
                                            and must be set form action
                                    --}}

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#{{ $batch->id }}"><span class="glyphicon glyphicon-trash"></span>Delete</button>
                                    <!-- -------------------- delete Pop Up --------------------------- -->
                                    <div class="modal fade" id="{{ $batch->id }}" role="dialog">
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
