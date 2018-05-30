<?php

namespace App\Http\Controllers\Teacher\Third_Ex;

use Auth;
use Session;
use App\Models\Admin\Course;
use Illuminate\Http\Request;
use App\Models\Admin\Student;
use App\Models\Admin\Semester;
use App\Models\Admin\CourseEnroll;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;
use App\Models\StudentEnroll\StudentEnroll;
use App\Models\Teacher\ThirdExaminerSeventyMark as TESM;

class SeventyPercentMarkController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'total'      => 'required|numeric|min:0|max:70',
        ]);

        $tesm   = new TESM;

        $tesm->semester_id  = $request->semester_id;
        $tesm->course_id    = $request->course_id;
        $tesm->student_id   = $request->student_id;
        $tesm->exam_time_id = $request->exam_time_id;
        $tesm->teacher_id   = Auth::user()->user_id;
        
        $tesm->total        = $request->total;

        if ($tesm->save()) {
            Session::flash('success', 'Third Examiner Seventy Mark update successfull.');
        }

        return redirect()->route('third-examiner.course-details', ['c_id'=>$tesm->course_id,'s_id'=>$tesm->semester_id,'et_id'=>$tesm->exam_time_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_e_id,$student_id)
    {
        $course_e = CourseEnroll::find($course_e_id);

        //.....check result is submitted or not
        $isSubmitted = false;
        $sr = SubmittedResult::where('exam_time_id',$course_e->exam_time_id)
                                ->where('course_id',$course_e->course_id)
                                ->where('semester_id',$course_e->semester_id)
                                ->where('teacher_id', Auth::user()->user_id)
                                ->first();
        if ($sr) {
            $isSubmitted = true;
        }



        $tesms = TESM::where('course_id',$course_e->course_id)
                        ->where('teacher_id',Auth::user()->user_id)
                        ->where('student_id',$student_id)
                        ->where('semester_id',$course_e->semester_id)
                        ->where('exam_time_id',$course_e->exam_time_id)
                        ->first();

        return view('third_examiner.result.seventy.create')
                ->with('course_e',$course_e)
                ->with('tesms',$tesms)
                ->with('student',Student::where('id',$student_id)->first())
                ->with('isSubmitted', $isSubmitted);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'total' => 'required|numeric|min:0|max:70',
        ]);

        $tesm = TESM::find($id);

        $tesm->semester_id  = $request->semester_id;
        $tesm->course_id    = $request->course_id;
        $tesm->student_id   = $request->student_id;
        $tesm->exam_time_id = $request->exam_time_id;
        $tesm->teacher_id   = Auth::user()->user_id;
        
        $tesm->total        = $request->total;

        if ($tesm->save()) {
            Session::flash('success', 'Third Examiner Seventy Mark update successfull.');
        }

        return redirect()->route('third-examiner.course-details', ['c_id'=>$tesm->course_id,'s_id'=>$tesm->semester_id,'et_id'=>$tesm->exam_time_id]);
    }
}
