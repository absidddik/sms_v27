<?php

namespace App\Http\Controllers\Teacher\Internal;

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
use App\Models\Teacher\InternalThirtyPercentMark as ITPM;

class ThirtyPercentMarkController extends Controller
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
            'tutorial_1'      => 'required|numeric|min:0|max:10',
            'tutorial_2'      => 'required|numeric|min:0|max:10',
            'tutorial_3'      => 'required|numeric|min:0|max:10',
            'prefer_tutorial' => 'required|numeric|min:0|max:10',
            'mid_term'        => 'required|numeric|min:0|max:10',
            'attendance'      => 'required|numeric|min:0|max:10',
            'total'           => 'required|numeric|min:0|max:30',
        ]);

        $itpm = new ITPM;

        $itpm->semester_id        = $request->semester_id;
        $itpm->course_id          = $request->course_id;
        $itpm->student_id         = $request->student_id;
        $itpm->exam_time_id       = $request->exam_time_id;
        $itpm->teacher_id         = Auth::user()->user_id;

        $itpm->tutorial_1         = $request->tutorial_1;
        $itpm->tutorial_2         = $request->tutorial_2;
        $itpm->tutorial_3         = $request->tutorial_3;
        $itpm->prefer_tutorial_id = $request->prefer_tutorial_id;
        $itpm->prefer_tutorial    = $request->prefer_tutorial;
        $itpm->mid_term           = $request->mid_term;
        $itpm->attendance         = $request->attendance;
        $itpm->total              = $request->total;

        if ($itpm->save()) {
            Session::flash('success', 'Thirty Percent Mark update successfull.');
        }

        return redirect()->route('internal.result.thirty.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
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
        ->where('course_id',$course_e->course->id)
        ->where('semester_id',$course_e->semester->id)
        ->where('teacher_id', Auth::user()->user_id)
        ->first();
        if ($sr) {
            $isSubmitted = true;
        }



        $thirty_per_mark = ITPM::where('course_id',$course_e->course->id)
                                ->where('teacher_id',Auth::user()->user_id)
                                ->where('student_id',$student_id)
                                ->where('semester_id',$course_e->semester->id)
                                ->first();

        if (!empty($thirty_per_mark)) {
            return view('teacher.result.30_percent.edit')
                    ->with('course_e',$course_e)
                    ->with('thirty_per_mark',$thirty_per_mark)
                    ->with('prefer_tutorial',ITPM::PREFER_TUTORIALS)
                    ->with('route','internal.thirty-percetn-mark.update')
                    ->with('student',Student::where('id',$student_id)->first())
                    ->with('isSubmitted', $isSubmitted);
        }else{
            return view('teacher.result.30_percent.create')
                    ->with('course_e',$course_e)
                    ->with('prefer_tutorial',ITPM::PREFER_TUTORIALS)
                    ->with('route','internal.thirty-percetn-mark.store')
                    ->with('student',Student::where('id',$student_id)->first())
                    ->with('isSubmitted', $isSubmitted);;
        }
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
            'tutorial_1'      => 'required|numeric|min:0|max:10',
            'tutorial_2'      => 'required|numeric|min:0|max:10',
            'tutorial_3'      => 'required|numeric|min:0|max:10',
            'prefer_tutorial' => 'required|numeric|min:0|max:10',
            'mid_term'        => 'required|numeric|min:0|max:10',
            'attendance'      => 'required|numeric|min:0|max:10',
            'total'           => 'required|numeric|min:0|max:30',
        ]);

        $itpm = ITPM::find($id);

        $itpm->semester_id        = $request->semester_id;
        $itpm->course_id          = $request->course_id;
        $itpm->student_id         = $request->student_id;
        $itpm->exam_time_id       = $request->exam_time_id;
        $itpm->teacher_id         = Auth::user()->user_id;

        $itpm->tutorial_1         = $request->tutorial_1;
        $itpm->tutorial_2         = $request->tutorial_2;
        $itpm->tutorial_3         = $request->tutorial_3;
        $itpm->prefer_tutorial_id = $request->prefer_tutorial_id;
        $itpm->prefer_tutorial    = $request->prefer_tutorial;
        $itpm->mid_term           = $request->mid_term;
        $itpm->attendance         = $request->attendance;
        $itpm->total              = $request->total;

        if ($itpm->save()) {
            Session::flash('success', 'Thirty Percent Mark update successfull.');
        }

        return redirect()->route('internal.result.thirty.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
    }

}
