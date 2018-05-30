@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Due Student Enrolled List</h3>
                </div>

                <div class="panel-body">
                    {{-- some change need
                    must be set form action
                    --}}


                    <div class="form-horizontal">
                        {{ csrf_field() }}
                        @include('includes.errors')
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Exam Time</label>
                            <div class="col-sm-6">
                                <select id="exam_time_id" name="exam_time_id" class="form-control select">
                                    <option value="">Select Exam Time</option>
                                    @if ($exam_times)
                                        @foreach ($exam_times as $exam_time)
                                            <option value="{{ $exam_time->id }}">{{ $exam_time->exam_month.' '.$exam_time->exam_year }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Semester</label>
                                <div class="col-sm-6">
                                    <select id="semester" name="semester_id" class="form-control select">
                                        <option value="">Select Semester</option>
                                        @if ($semesteres)
                                            @foreach ($semesteres as $semester)
                                                <option value="{{ $semester->id }}">{{ $semester->semester }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <div id="unhide" hidden="" class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Student List</h3><input type="checkbox" id="select_all"/> <b>Select All</b>
                    </div>
                    <div class="panel-body">
                        <div id="show_data"></div>
                    </div>
                    <div class="panel-footer">
                        <div class="pull-right">
                            <input type="submit" class="btn btn-danger" value="All Unroll" onclick="unrolls()">
                            <input type="submit" class="btn btn-danger" value="Unroll" id="btn_" >
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#select_all').on('click', function () {
                if (this.checked) {
                    $('.checkbox').each(function () {
                        this.checked = true;
                    });
                } else {
                    $('.checkbox').each(function () {
                        this.checked = false;
                    });
                }
            });

            $('.checkbox').on('click', function () {
                if ($('.checkbox:checked').length == $('.checkbox').length) {
                    $('#select_all').prop('checked', true);
                } else {
                    $('#select_all').prop('checked', false);
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#semester').on('change', function () {

                var semester_id = $(this).val();
                var exam_time_id = $('#exam_time_id').val();
                if (semester_id == '') {
                    $('#unhide').prop('hidden', true);
                } else {
                    $('#unhide').prop('hidden', false);
                    $.ajax({
                        url: "{{ route('due.student-enrolls.get_data') }}",
                        type: "get",
                        data: {'semester_id': semester_id,'exam_time_id': exam_time_id},
                        dataType: "json",
                        success: function (data) {
                            $('#show_data').html(data);
                        },
                        error: function () {
                            $('#show_data').html("No data found");
                        }
                    });
                }
            });
        });
    </script>

    <script>
        function unroll(elmnt, enroll_id) {
            var semester_id = $('#semester').val();
            var exam_time_id = $('#exam_time_id').val();
            $.ajax({
                url: "{{ route('due.student-enrolls.unroll') }}",
                type: "get",
                data: {'enroll_id': enroll_id , 'semester_id': semester_id,'exam_time_id': exam_time_id},
                dataType: "json",
                success: function (data) {
                    $('#unhide').prop('hidden', false);
                    $('#show_data').html(data);
                },
                error: function () {
                    $('#show_data').html("No data found");
                }
            });
        }
    </script>

    <script>
        function unrolls() {

            var semester_id = $('#semester').val();
            var exam_time_id = $('#exam_time_id').val();
            var enroll_id = $("input[name='student_id[]']")
                .map(function(){return $(this).val();}).get();
            $.ajax({
                url: "{{ route('due.student-enrolls.unroll') }}",
                type: "get",
                data: {'enroll_id': enroll_id , 'semester_id': semester_id,'exam_time_id': exam_time_id},
                dataType: "json",
                success: function (data) {
                    $('#unhide').prop('hidden', false);
                    $('#show_data').html(data);
                },
                error: function () {
                    $('#show_data').html("No data found");
                }
            });
        }
    </script>

    <script type="text/javascript">
        $("#btn_").on('click', function () {
            var enroll_id = "";
            var ischecked = "";
            $(":checkbox").each(function () {
                var ischecked = $(this).is(":checked");
                if (ischecked && $(this).val() != 'on') {
                    enroll_id += $(this).val()+ ",";
                }
            });
            if(enroll_id)
            {
                var semester_id = $('#semester').val();
                var exam_time_id = $('#exam_time_id').val();
                $.ajax({
                    url: "{{ route('due.student-enrolls.unroll') }}",
                    type: "get",
                    data: {'enroll_id': enroll_id , 'semester_id': semester_id,'exam_time_id': exam_time_id},
                    dataType: "json",
                    success: function (data) {
                        $('#unhide').prop('hidden', false);
                        $('#show_data').html(data);
                    },
                    error: function () {
                        $('#show_data').html("No data found");
                    }
                });
            }
        });
    </script>

@endsection
