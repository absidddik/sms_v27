<?php

namespace App\Http\Controllers\Teacher\Internal;

use Auth;
use Session;
use App\Models\Admin\Course;
use Illuminate\Http\Request;
use App\Models\Admin\Student;
use App\Models\Admin\Semester;
use App\Models\Teacher\VivaVoce;
use App\Models\Admin\CourseEnroll;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;
use App\Models\StudentEnroll\StudentEnroll;
use App\Models\Teacher\InternalSeventyPercentMark as ISPM;

class VivaVoceMarkController extends Controller
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
            'total'      => 'required|numeric|min:0|max:25',
        ]);

        $ispm = new ISPM;

        $ispm->semester_id        = $request->semester_id;
        $ispm->course_id          = $request->course_id;
        $ispm->student_id         = $request->student_id;
        $ispm->exam_time_id       = $request->exam_time_id;
        $ispm->is_absent          = $request->is_absent;
        $ispm->teacher_id         = Auth::user()->user_id;

        $ispm->q_1=$ispm->q_2=$ispm->q_3=$ispm->q_4=$ispm->q_5=$ispm->q_6=$ispm->q_7=$ispm->q_8=$ispm->q_9=$ispm->q_10=$ispm->q_11=$ispm->q_12=$ispm->q_13=$ispm->q_14=$ispm->q_15=0;

        if ($request->is_absent) {
            $ispm->total = 0;
        }else {
            $ispm->total = $request->total;
        }

        

        if ($ispm->save()) {
            Session::flash('success', 'Viva Voce Mark update successfull.');
        }

        return redirect()->route('internal.result.viva-voce.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
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

        $viva_voce_mark = ISPM::where('course_id',$course_e->course_id)
                                ->where('teacher_id',Auth::user()->user_id)
                                ->where('student_id',$student_id)
                                ->where('semester_id',$course_e->semester_id)
                                ->where('exam_time_id',$course_e->exam_time_id)
                                ->first();

        return view('teacher.result.viva_voce.create')
                ->with('course_e',$course_e)
                ->with('viva_voce_mark',$viva_voce_mark)
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
            'total'      => 'required|numeric|min:0|max:25',
        ]);

        $ispm = ISPM::find($id);

        $ispm->semester_id        = $request->semester_id;
        $ispm->course_id          = $request->course_id;
        $ispm->student_id         = $request->student_id;
        $ispm->exam_time_id       = $request->exam_time_id;
        $ispm->is_absent          = $request->is_absent;
        $ispm->teacher_id         = Auth::user()->user_id;

        $ispm->q_1=$ispm->q_2=$ispm->q_3=$ispm->q_4=$ispm->q_5=$ispm->q_6=$ispm->q_7=$ispm->q_8=$ispm->q_9=$ispm->q_10=$ispm->q_11=$ispm->q_12=$ispm->q_13=$ispm->q_14=$ispm->q_15=0;

        if ($request->is_absent) {
            $ispm->total = 0;
        }else {
            $ispm->is_absent = 0;
            $ispm->total = $request->total;
        }

        if ($ispm->save()) {
            Session::flash('success', 'Viva Voce Mark update successfull.');
        }

        return redirect()->route('internal.result.viva-voce.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
    }
}
