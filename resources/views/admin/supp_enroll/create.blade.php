
@extends('layouts.admin')

@section('content')
    <div class="row">
        <form class="form-horizontal" action="{{ route('supplementary-enroll.store') }}" method="post" enctype="multipart/form-data">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Create Supplementary / Improvement Enroll</h3>
                    </div>

                    <div class="panel-body">

                        {{ csrf_field() }}

                        @include('includes.errors')
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Course</label>
                            <div class="col-sm-6">
                                <select name="course_e_id" class="form-control select">
                                    <option value="">Select Course</option>
                                    @if ($c_enrolls)
                                        @foreach ($c_enrolls as $c_enroll)
                                            <option value="{{ $c_enroll->id }}">{{ $c_enroll->course->name }} ( {{ $c_enroll->course->code }} )
                                                <br> <i>{{ $c_enroll->teacher->name }}</i></option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Exam Time</label>
                            <div class="col-sm-6">
                                <select name="exam_time_id" class="form-control select">
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
                            <label class="col-sm-3 control-label">Exam Type</label>
                            <div class="col-sm-6">
                                <select name="exam_type" class="form-control select">
                                    <option value="">Select Exam Type</option>
                                    @foreach ($exam_types as $key => $exam_type)
                                        <option value="{{ $key }}">{{ $exam_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Batch</label>
                            <div class="col-sm-6">
                                <select id="batch" name="batch_id" class="form-control select">
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
        $('#batch').on('change', function () {

            var batch_id = $(this).val();
            if (batch_id == '') {
                $('#unhide').prop('hidden', true);
            } else {
                $('#unhide').prop('hidden', false);
                $.ajax({
                    url: "{{ route('supplementary-enroll.index') }}",
                    type: "get",
                    data: {'batch_id': batch_id},
                    dataType: "json",
                    success: function (data) {
                        $('#show_data').html(data);
                    },
                    error: function () {
                        $('#show_data').html("noo data found");
                    }
                });
            }
        });
    });
    </script>
@endsection
