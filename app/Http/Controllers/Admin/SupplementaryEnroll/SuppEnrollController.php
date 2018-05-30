<?php

namespace App\Http\Controllers\Admin\SupplementaryEnroll;

use Auth;
use Session;
use App\Models\Admin\Batch;
use Illuminate\Http\Request;
use App\Models\Admin\Student;
use App\Models\Admin\ExamTime;
use App\Models\Admin\Semester;
use App\Models\Admin\courseEnroll;
use App\Http\Controllers\Controller;
use App\Models\SuppEnroll\SuppEnroll;

class SuppEnrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $batch_id = $request->batch_id;
        if ($batch_id == null) {
            return redirect()->route('supplementary-enroll.create');
        }
        $students = Student::orderBy('exam_roll')->where('students.batch_id', $batch_id)->get();

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.supp_enroll.create')
                ->with('batches', Batch::all())
                ->with('exam_types', SuppEnroll::EXAM_TYPES)
                ->with('exam_times', ExamTime::orderby('id','desc')->get())
                ->with('c_enrolls', courseEnroll::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'course_e_id'  => 'required|numeric',
            'exam_time_id' => 'required|numeric',
            'batch_id'     => 'required|numeric',
            'exam_type'    => 'required|numeric',
            'student_id'   => 'required',

        ]);

        $input = $request->all();
        $course_e = courseEnroll::find($request->course_e_id);
        $student_id = $request->input('student_id');

        for ($i = 0; $i < count($student_id); $i++) {
            $data[$i]['supervisor_id'] = Auth::user()->user_id;
            $data[$i]['batch_id'] = $input['batch_id'];
            $data[$i]['course_e_id'] = $input['course_e_id'];
            $data[$i]['course_id'] = $course_e->course_id;
            $data[$i]['semester_id'] = $course_e->semester_id;
            $data[$i]['teacher_id'] = $course_e->teacher_id;
            $data[$i]['exam_time_id'] = $input['exam_time_id'];
            $data[$i]['exam_type'] = $input['exam_type'];
            $data[$i]['student_id'] = $student_id[$i];
        }

        if (SuppEnroll::insert($data)) {
            Session::flash('success', 'Supplementary Student Enroll successfull');
        } else {
            Session::flash('fail', 'Supplementary Student Enroll failed');
        }

        return redirect()->back();
    }





    public function enrolls_show()
    {
        return view('admin.supp_enroll.view')
        ->with('supp_enrolls', courseEnroll::select('course_enrolls.*')->distinct('course_enrolls.id')
                                            ->join('supp_enrolls', 'supp_enrolls.course_e_id','=','course_enrolls.id')->get());
    }





    public function supp_unroll(Request $request)
    {
        $ids         = $request->input('enroll_id');
        $course_e_id = $request->input('course_e_id');

        if (is_string($ids)) {
            $ids = explode(",", $ids);
        }
        SuppEnroll::destroy($ids);

        if ($course_e_id == null) {
            return redirect()->route('supplementary-enroll.create');
        }

        $jsonData = $this->get_jeson_data($course_e_id);
        return json_encode($jsonData);
    }





    public function get_data_by_json_where_course_e_id(Request $request)
    {
        $course_e_id = $request->input('course_e_id');
        if ($course_e_id == null) {
            return redirect()->route('supplementary-enroll.create');
        }

        $jsonData = $this->get_jeson_data($course_e_id);
        return json_encode($jsonData);

    }






    public function get_jeson_data( $course_e_id = "")
    {
        $supp_student_enrolls = SuppEnroll::where('course_e_id', $course_e_id)->get();

        $jsonData = '';
        if ($supp_student_enrolls)
        {
            foreach ($supp_student_enrolls as $student_enroll) {
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
                ' . $student_enroll->student->batch->batch_number . 'th batch <br>
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
