@extends('layouts.user')



@section('content')
    <div class="col-sm-12" style="background:white">
        <div class="col-sm-8 col-sm-offset-2" style="padding-bottom:10px;margin-bottom:5px;">
            <h3 class="text-center">{{ ucfirst($exam->exam->slug)}} -- {{$exam->semester->semester}} Semester</h3>
            <hr>
            @if ($unsubbmited_result)
                <label for="">Result not show due to unsubbmitted courses</label>

                <ul class="list-group">
                    @foreach ($unsubbmited_result as $r)
                        <li class="list-group-item" style="color:red;">{{$r->name}}</li>
                    @endforeach
                </ul>
            @else
                <ul class="list-group">
                    <li class="list-group-item" style="border-bottom:1px solid silver">
                        <div class="text-center">
                            <a class="btn btn-success btn-sm" href="{{route('charman-result-full-mark.show',[$exam->exam_time_id,$exam->semester_id])}}">Full Mark</a>
                            <a class="btn btn-primary btn-sm" href="{{route('charman-result-with-mark.show',[$exam->exam_time_id,$exam->semester_id])}}">With Mark</a>
                            <a class="btn btn-info btn-sm" href="{{route('charman-result-without-mark.show',[$exam->exam_time_id,$exam->semester_id])}}">Without Mark</a>
                        </div>

                    </li>
                </ul>
            @endif
            <br><br>
        </div>
    </div>
@endsection
