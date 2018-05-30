<?php

namespace App\Http\Controllers\Teacher\Supplementary;

use Auth;
use Session;
use App\Models\Admin\Course;
use Illuminate\Http\Request;
use App\Models\Admin\Student;
use App\Models\Admin\Semester;
use App\Models\Admin\CourseEnroll;
use App\Models\Teacher\SuppVivaVoce;
use App\Http\Controllers\Controller;
use App\Models\SuppEnroll\SuppEnroll;
use App\Models\Result\SubmittedResult;
use App\Models\StudentEnroll\StudentEnroll;

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
            'viva_voce'      => 'required|numeric|min:0|max:25',
        ]);

        $vv   = new SuppVivaVoce;

        $vv->semester_id        = $request->semester_id;
        $vv->course_id          = $request->course_id;
        $vv->student_id         = $request->student_id;
        $vv->exam_time_id       = $request->exam_time_id;
        $vv->teacher_id         = Auth::user()->user_id;

        $vv->viva_voce          = $request->viva_voce;
        $vv->total              = $request->viva_voce;

        if ($vv->save()) {
            Session::flash('success', 'Viva Voce Mark update successfull.');
        }

        return redirect()->route('internal.supp-result.viva-voce.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
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



        $viva_voce_mark = SuppVivaVoce::where('course_id',$course_e->course_id)
                                ->where('teacher_id',Auth::user()->user_id)
                                ->where('student_id',$student_id)
                                ->where('semester_id',$course_e->semester_id)
                                ->where('exam_time_id',$supp_e->exam_time_id)
                                ->first();

        return view('teacher.result.supp.viva_voce.create')
                ->with('course_e',$course_e)
                ->with('supp_e',$supp_e)
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
            'viva_voce'      => 'required|numeric|min:0|max:25',
        ]);

        $vv = SuppVivaVoce::find($id);

        $vv->semester_id        = $request->semester_id;
        $vv->course_id          = $request->course_id;
        $vv->student_id         = $request->student_id;
        $vv->exam_time_id       = $request->exam_time_id;
        $vv->teacher_id         = Auth::user()->user_id;

        $vv->viva_voce          = $request->viva_voce;
        $vv->total              = $request->viva_voce;

        if ($vv->save()) {
            Session::flash('success', 'Viva Voce Mark update successfull.');
        }

        return redirect()->route('internal.supp-result.viva-voce.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
    }
}
