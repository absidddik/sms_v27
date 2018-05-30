<?php

namespace App\Http\Controllers\Teacher\Supplementary;

use Auth;
use Session;
use App\Models\Admin\Course;
use Illuminate\Http\Request;
use App\Models\Admin\Student;
use App\Models\Admin\Semester;
use App\Models\Admin\CourseEnroll;
use App\Models\Teacher\SuppLabMark;
use App\Http\Controllers\Controller;
use App\Models\SuppEnroll\SuppEnroll;
use App\Models\Result\SubmittedResult;
use App\Models\StudentEnroll\StudentEnroll;
use App\Models\Teacher\InternalSeventyPercentMark as ISPM;

class LabMarkController extends Controller
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
            'tutorial'         => 'required|numeric|min:0|max:5',
            'mid_term'         => 'required|numeric|min:0|max:5',
            'attendance'       => 'required|numeric|min:0|max:5',
            'lab_seventy_mark' => 'required|numeric|min:0|max:35',
            'total'            => 'required|numeric|min:0|max:50',
        ]);

        $lab_mark = new SuppLabMark;

        $lab_mark->semester_id      = $request->semester_id;
        $lab_mark->course_id        = $request->course_id;
        $lab_mark->student_id       = $request->student_id;
        $lab_mark->exam_time_id     = $request->exam_time_id;
        $lab_mark->teacher_id       = Auth::user()->user_id;
        
        $lab_mark->tutorial         = $request->tutorial;
        $lab_mark->mid_term         = $request->mid_term;
        $lab_mark->attendance       = $request->attendance;
        $lab_mark->lab_seventy_mark = $request->lab_seventy_mark;
        $lab_mark->total            = $request->total;

        if ($lab_mark->save()) {
            Session::flash('success', 'Lab Mark update successfull.');
        }

        return redirect()->route('internal.supp-result.lab-mark.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($supp_e_id,$student_id)
    {
        $supp_e = SuppEnroll::find($supp_e_id);
        $course_e = CourseEnroll::find($supp_e->course_e_id);
        //.....check result is submitted or not
        $isSubmitted = false;
        $sr = SubmittedResult::where('exam_time_id',$supp_e->exam_time_id)
                                ->where('course_id',$course_e->course_id)
                                ->where('semester_id',$course_e->semester_id)
                                ->where('teacher_id', Auth::user()->user_id)
                                ->first();
        if ($sr) {
            $isSubmitted = true;
        }



        $lab_mark = SuppLabMark::where('course_id',$course_e->course_id)
                                ->where('teacher_id',Auth::user()->user_id)
                                ->where('student_id',$student_id)
                                ->where('semester_id',$course_e->semester_id)
                                ->where('exam_time_id',$supp_e->exam_time_id)
                                ->first();

        return view('teacher.result.supp.lab_mark.create')
                ->with('course_e',$course_e)
                ->with('supp_e',$supp_e)
                ->with('lab_mark',$lab_mark)
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
            'tutorial'         => 'required|numeric|min:0|max:5',
            'mid_term'         => 'required|numeric|min:0|max:5',
            'attendance'       => 'required|numeric|min:0|max:5',
            'lab_seventy_mark' => 'required|numeric|min:0|max:35',
            'total'            => 'required|numeric|min:0|max:50',
        ]);

        $lab_mark = SuppLabMark::find($id);

        $lab_mark->semester_id      = $request->semester_id;
        $lab_mark->course_id        = $request->course_id;
        $lab_mark->student_id       = $request->student_id;
        $lab_mark->exam_time_id     = $request->exam_time_id;
        $lab_mark->teacher_id       = Auth::user()->user_id;
        
        $lab_mark->tutorial         = $request->tutorial;
        $lab_mark->mid_term         = $request->mid_term;
        $lab_mark->attendance       = $request->attendance;
        $lab_mark->lab_seventy_mark = $request->lab_seventy_mark;
        $lab_mark->total            = $request->total;

        if ($lab_mark->save()) {
            Session::flash('success', 'Lab Mark update successfull.');
        }

        return redirect()->route('internal.supp-result.lab-mark.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
    }
}
