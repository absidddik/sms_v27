@extends('layouts.user')

@section('styles')
	<style type="text/css">
		.fs{
			font-size: 300px;
		}
	</style>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>70% mark</h4>
			</div>
			<div class="panel-body">
				<table class="table table-bordered datatable">
					<thead>
						<b style="font-size: 30px">
						<tr>
							<th class="text-center fs" rowspan="2">Exam Roll</th>
							<th class="text-center fs" colspan="15">Mark</th>
							<th class="text-center fs" rowspan="2">Total Mark</th>
						</tr>
						<tr>
							
							<th class="text-center fs">Q 1</th>
							<th class="text-center fs">Q 2</th>
							<th class="text-center fs">Q 3</th>
							<th class="text-center fs">Q 4</th>
							<th class="text-center fs">Q 5</th>
							<th class="text-center fs">Q 6</th>
							<th class="text-center fs">Q 7</th>
							<th class="text-center fs">Q 8</th>
							<th class="text-center fs">Q 9</th>
							<th class="text-center fs">Q 10</th>
							<th class="text-center fs">Q 11</th>
							<th class="text-center fs">Q 12</th>
							<th class="text-center fs">Q 13</th>
							<th class="text-center fs">Q 14</th>
							<th class="text-center fs">Q 15</th>
						</tr>
						</b>
					</thead>
					<tbody>
						
						@if ($seventy_per_marks)
							@foreach ($seventy_per_marks as $seventy_per_mark)
								<tr>
									<td>{{ $seventy_per_mark->student->exam_roll }}</td>
									<td>{{ $seventy_per_mark->q_1 }}</td>
									<td>{{ $seventy_per_mark->q_2 }}</td>
									<td>{{ $seventy_per_mark->q_3 }}</td>
									<td>{{ $seventy_per_mark->q_4 }}</td>
									<td>{{ $seventy_per_mark->q_5 }}</td>
									<td>{{ $seventy_per_mark->q_6 }}</td>
									<td>{{ $seventy_per_mark->q_7 }}</td>
									<td>{{ $seventy_per_mark->q_8 }}</td>
									<td>{{ $seventy_per_mark->q_9 }}</td>
									<td>{{ $seventy_per_mark->q_10 }}</td>
									<td>{{ $seventy_per_mark->q_11 }}</td>
									<td>{{ $seventy_per_mark->q_12 }}</td>
									<td>{{ $seventy_per_mark->q_13 }}</td>
									<td>{{ $seventy_per_mark->q_14 }}</td>
									<td>{{ $seventy_per_mark->q_15 }}</td>
									<td>{{ $seventy_per_mark->total }}</td>
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