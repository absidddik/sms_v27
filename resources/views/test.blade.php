@extends('layouts.user')

@section('content')
    <table class="table datatable">
        <thead>
            <th>Exam Roll</th>
            <th>Tut 1</th>
        </thead>
        <tbody>
            @foreach ($students as $s)
                <tr>
                    <td>{{$s->student->exam_roll}}</td>
                    <td>{{$s->thirtyMark['tutorial_1']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
