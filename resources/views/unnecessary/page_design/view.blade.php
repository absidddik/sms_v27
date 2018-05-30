@extends('layouts.admin')

@section('breadcrumb')
<ul class="breadcrumb">
    <li><a href="{{ route('design.index') }}">List of</a></li>                    
    <li class="active">Item</li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            
            <div class="panel-body">
                <table class="table no-border">
                    <tr>
                        <td width="15%">Name</td>
                        <td width="1%">:</td>
                        <td width="84%">ab siddik</td>
                    </tr>
                    <tr>
                        <td width="15%">Email</td>
                        <td width="1%">:</td>
                        <td width="84%">absiddik@gmail.com</td>
                    </tr>
                    <tr>
                        <td width="15%">Date of birth</td>
                        <td width="1%">:</td>
                        <td width="84%">08-06-1993</td>
                    </tr>
                    <tr>
                        <td width="15%">image</td>
                        <td width="1%">:</td>
                        <td width="84%">
                            <img width="50%" src="https://static.pexels.com/photos/20974/pexels-photo.jpg" alt="No Image Found">
                        </td>
                    </tr>
                    <tr>
                        <td width="15%">Website URL</td>
                        <td width="1%">:</td>
                        <td width="84%"><a target="_blank" href="https://semicolonitbd.com/">Semi-colon IT Solution</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
