@extends('layouts.user')

@section('content')

<div class="col-sm-12">
    <table class="table table-bordered text-center">
        <tr>
            <th class="text-center" rowspan="2">Exam Roll <br>No.</th>
            <th class="text-center" rowspan="2">Theoretical <br>Marks <br>70/35</th>
        
        </tr>


        <tbody>
            @if ($results)
                @foreach ($results as $result)
                    <tr>
                        <td>{{ $result->exam_roll }}</td>
                        <td>{{ round($result->seventy_total) }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>



    </table>

    <div class="col-sm-12">
        @if (!$isSubmitted)
            {{Form::open(['route'=>'result.submit','method'=>'POST'])}}
            <input type="hidden" name="exam_time_id" value="{{$exam_time_id}}">
            <input type="hidden" name="course_id" value="{{$course_id}}">
            <input  type="hidden" name="semester_id" value="{{$semester_id}}">
            <input class="btn btn-primary" type="submit" name="" value="Submit Result">
            {{Form::close()}}
            @else
                <h3>You already submitted this result</h3>
        @endif
    </div>
</div>
@endsection
