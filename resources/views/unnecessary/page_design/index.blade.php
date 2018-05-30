@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>List of </h2>  
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
                        <tr>
                            <td>1</td>
                            <td>ab siddik</td>
                            <td>absiddik@gmail.com</td>
                            <td>
                                <form action="" method="post">
                                    {{ csrf_field() }} {{ method_field('delete') }}

                                    <a class="btn btn-success" href="{{ route('design.view') }}"><span class="fa fa-eye"> View</span></a>
                                    <a class="btn btn-primary" href=""><span class="fa fa-edit"> Edit</span></a>


                                    {{-- some change need 
                                            data-target 1 changed by databse id
                                            and then id of the next line changed by the same database id
                                            and must be set form action 
                                    --}}

                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#{{ 1 }}"><span class="glyphicon glyphicon-trash"></span>Delete</button>
                                    <!-- -------------------- delete Pop Up --------------------------- -->
                                    <div class="modal fade" id="{{ 1 }}" role="dialog">
                                        @include('includes.delete')
                                    </div>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
