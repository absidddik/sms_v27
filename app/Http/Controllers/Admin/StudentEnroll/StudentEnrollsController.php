<?php

namespace App\Http\Controllers\Admin\StudentEnroll;

use Auth;
use Session;
use App\Models\Admin\Batch;
use Illuminate\Http\Request;
use App\Models\Admin\Student;
use App\Models\Admin\Semester;
use App\Models\Admin\ExamTime;
use App\Http\Controllers\Controller;
use App\Models\StudentEnroll\StudentEnroll;

class StudentEnrollsController extends Controller
{
	public function index(Request $request)
	{
		$batch_id     = $request->batch_id;
		$semester_id  = $request->semester_id;
		$exam_time_id = $request->exam_time_id;

		if ($batch_id == null) {
			return redirect()->route('student-enroll.create');
		}

		$students = Student::select('id', 'image', 'batch_id', 'reg_no', 'exam_roll', 'name', 'email')
								->Where('batch_id', $batch_id)
								->get();

		$jsonData = '';
		if(!empty($students))
		{
			foreach ($students as $student) {
				$jsonData .= '
				<div style="padding-bottom: 10px;" class="col-md-4">
				<div class="col-md-2">
				<input name="student_id[]" type="checkbox" class="checkbox pull-left" value="' . $student->id . '"/>
				</div>
				<div class="col-md-4" >';

				if ($student->image) {
					$jsonData .= '<img width="64" height="64" src="'  . asset('storage/student/' . $student->image) .  '" alt="N/A">';
				}else {
					$jsonData .= '<img width="64" height="64" src="'. asset('images/default/student.jpg') .'" alt="No Image">';
				}

				$jsonData .= '</div>
				<div class="col-md-6" >
				' . $student->name . '<br>
				' . $student->exam_roll . '<br>
				' . $student->reg_no . '<br>
				</div>
				</div>';
			}
		}
		else{
			$jsonData .= "No data found";
		}

		return json_encode($jsonData);
	}





	public function create()
	{
		return view('admin.student_enroll.create')
		->with('batches', Batch::all())
		->with('exam_times', ExamTime::get())
		->with('semesteres', Semester::all());
	}



	public function store(Request $request)
	{
		$this->validate($request, [
			'batch_id' => 'required|numeric',
			'semester_id' => 'required|numeric',
			'exam_time' => 'required|numeric',
			'student_id' => 'required',

		]);

		$input = $request->all();
		$student_id = $request->input('student_id');

		for ($i = 0; $i < count($student_id); $i++) {
			$data[$i]['supervisor_id'] = Auth::user()->user_id;
			$data[$i]['batch_id']      = $input['batch_id'];
			$data[$i]['semester_id']   = $input['semester_id'];
			$data[$i]['exam_time_id']  = $input['exam_time'];
			$data[$i]['student_id']    = $student_id[$i];
		}

		if (StudentEnroll::insert($data)) {
			Session::flash('success', 'Student Enroll create successfull');
		} else {
			Session::flash('fail', 'Student Enroll create failed');
		}

		return redirect()->back();
	}




	public function enrolls_show()
	{
		return view('admin.student_enroll.view')
		->with('exam_times', ExamTime::get())
		->with('semesteres', Semester::all());
	}





	public function student_unroll(Request $request)
	{
		$ids          = $request->input('enroll_id');
		$semester_id  = $request->input('semester_id');
		$exam_time_id = $request->input('exam_time_id');

		if (is_string($ids)) {
			$ids = explode(",", $ids);
		}
		StudentEnroll::destroy($ids);

		if ($semester_id == null) {
			return redirect()->route('student-enroll.create');
		}

		$jsonData = $this->get_jeson_data($semester_id,$exam_time_id);
		return json_encode($jsonData);
	}





	public function get_data_by_json_where_semester_id(Request $request)
	{
		$semester_id = $request->input('semester_id');
		$exam_time_id = $request->input('exam_time_id');

		if ($semester_id == null) {
			return redirect()->route('student-enroll.create');
		}

		$jsonData = $this->get_jeson_data($semester_id,$exam_time_id);
		return json_encode($jsonData);

	}






	public function get_jeson_data( $semester_id = "",$exam_time_id = "")
	{
		$student_enrolls = StudentEnroll::where('semester_id', $semester_id)
											->where('exam_time_id', $exam_time_id)
											->get();

		$jsonData = '';
		if ($student_enrolls)
		{
			foreach ($student_enrolls as $student_enroll) {
				$jsonData .= '
				<div style="padding-bottom: 10px;" class="col-md-4">
				<div class="col-md-4">
				<input name="student_id[]" type="checkbox" class="checkbox pull-left" value="' . $student_enroll->id . '"/>';

				if ($student_enroll->student->image) {
					$jsonData .= '<img width="64" height="64" src="'  . asset('storage/student/' . $student_enroll->student->image) .  '" alt="N/A">';
				}else {
					$jsonData .= '<img width="64" height="64" src="'. asset('images/default/student.jpg') .'" alt="No Image">';
				}

				$jsonData .= '</div>
				<div class="col-md-6">
				<b>'. $student_enroll->student->name . '</b><br>
				' . $student_enroll->student->exam_roll . '<br>
				' . $student_enroll->student->reg_no . '<br>
				<input type="button" class="btn-danger" value="Unroll" onclick="unroll(this, '. $student_enroll->id .')">\'<br>
				</div>
				</div>';
			}
		}
		else{
			$jsonData .= "No data found";
		}
		return $jsonData;
	}
}
