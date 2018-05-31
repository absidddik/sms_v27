
@extends('layouts.admin')

@section('content')
    <div class="row">
        <form class="form-horizontal" action="{{ route('student-enroll.store') }}" method="post" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Create Student Enroll</h3>
                    </div>

                    <div class="panel-body">
                        {{-- some change need
                        must be set form action
                        --}}


                        {{ csrf_field() }}

                        @include('includes.errors')
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Semester</label>
                            <div class="col-sm-6">
                                <select id="semester_id" name="semester_id" class="form-control select test">
                                    <option value="">Select Semester</option>
                                    @if ($semesteres)
                                        @foreach ($semesteres as $semester)
                                            <option value="{{ $semester->id }}">{{ $semester->semester }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Exam Time</label>
                            <div class="col-sm-6">
                                <select id="exam_time_id" class="form-control select test" name="exam_time">
                                    <option value="">Select Exam Time</option>
                                    @if ($exam_times)
                                        @foreach ($exam_times as $exam_time)
                                            <option value="{{ $exam_time->id }}">{{ $exam_time->exam_month.' '.$exam_time->exam_year }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Batch</label>
                            <div class="col-sm-6">
                                <select id="batch" name="batch_id" class="form-control select test">
                                    <option value="">Select Batch</option>
                                    @if ($batches)
                                        @foreach ($batches as $batch)
                                            <option value="{{ $batch->id }}">{{ $batch->batch_number }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div id="unhide" hidden="" class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Student List</h3><input type="checkbox" id="select_all" /> <b>Select All</b>
                    </div>
                    <div class="panel-body">
                        <div id="show_data"></div>
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <input class="btn btn-success" type="submit" value="Save">
                            <input class="btn btn-danger" type="reset" value="Reset">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
    </script>

    <script type="text/javascript">
    $(document).ready(function () {
        $('.test').on('change', function () {

            var batch_id = $('#batch').val();
            var semester_id = $('#semester_id').val();
            var exam_time_id = $('#exam_time_id').val();

            if (batch_id == '') {
                $('#unhide').prop('hidden', true);
            } else {
                $('#unhide').prop('hidden', false);
                $.ajax({
                    url: "{{ route('student-enroll.index') }}",
                    type: "get",
                    data: {'batch_id': batch_id,'semester_id': semester_id,'exam_time_id': exam_time_id},
                    dataType: "json",
                    success: function (data) {
                        $('#show_data').html(data);
                    },
                    error: function () {
                        $('#show_data').html("no data found");
                    }
                });
            }
            // alert(semester_id+exam_time_id+batch_id)
        });
    });
    </script>
@endsection
