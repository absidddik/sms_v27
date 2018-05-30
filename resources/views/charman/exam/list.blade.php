@extends('layouts.user')



@section('content')
    <div class="col-sm-12" style="background:white">
        <div class="col-sm-8 col-sm-offset-2" style="padding-bottom:10px;margin-bottom:5px;">
            <ul class="list-group">
                <h3 class="text-center">All results for charman</h3>
                <hr>
                @foreach ($charman_e as $exam)
                    <li class="list-group-item" style="border-bottom:1px solid silver">
                        <div>
                            <a style="width:100%" class="btn btn-info btn-sm" href="{{route('charman-result.show',[$exam->exam_time_id,$exam->semester_id])}}">{{ ucfirst($exam->exam->slug)}} -- {{$exam->semester->semester}} Semester</a>
                        </div>

                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
