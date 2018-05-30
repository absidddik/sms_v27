@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>List of Teacher</h3>
                </div>
                <div class="panel-body">
                    <table class="table datatable">
                        <thead>
                            <th width="10%">Serial No</th>
                            <th width="30%">Name</th>
                            <th width="30%">Email</th>
                            <th width="30%">Action</th>
                        </thead>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @if(!empty($teachers))
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $teacher->name }}</td>
                                        <td>{{ $teacher->email }}</td>
                                        <td>
                                            <a class="btn btn-success" href="{{ route('profile.show',$teacher->user_id) }}"><span class="fa fa-eye"> Profile</span></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
