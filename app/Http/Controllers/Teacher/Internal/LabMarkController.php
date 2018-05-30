<?php

namespace App\Http\Controllers\Teacher\Internal;

use Auth;
use Session;
use App\Models\Admin\Course;
use Illuminate\Http\Request;
use App\Models\Admin\Student;
use App\Models\Admin\Semester;
use App\Models\Teacher\LabMark;
use App\Models\Admin\CourseEnroll;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;
use App\Models\StudentEnroll\StudentEnroll;
use App\Models\Teacher\InternalThirtyPercentMark as ITPM;
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
        ]);

        if ($request->lab_seventy_mark) {
            $ispm = new ISPM;

            $ispm->semester_id      = $request->semester_id;
            $ispm->course_id        = $request->course_id;
            $ispm->student_id       = $request->student_id;
            $ispm->exam_time_id     = $request->exam_time_id;
            $ispm->is_absent        = $request->is_absent;
            $ispm->teacher_id       = Auth::user()->user_id;

            $ispm->q_1=$ispm->q_2=$ispm->q_3=$ispm->q_4=$ispm->q_5=$ispm->q_6=$ispm->q_7=$ispm->q_8=$ispm->q_9=$ispm->q_10=$ispm->q_11=$ispm->q_12=$ispm->q_13=$ispm->q_14=$ispm->q_15=0;

            if ($request->is_absent) {
                $ispm->total = 0;
            }else {
                $ispm->total = $request->lab_seventy_mark;
            }
        }

        $itpm = new ITPM;

        $itpm->semester_id      = $request->semester_id;
        $itpm->course_id        = $request->course_id;
        $itpm->student_id       = $request->student_id;
        $itpm->exam_time_id     = $request->exam_time_id;
        $itpm->teacher_id       = Auth::user()->user_id;

        $itpm->tutorial_2=$itpm->tutorial_3=$itpm->prefer_tutorial_id=$itpm->prefer_tutorial=0;
        $tutorial=$mid_term=$attendance=0;

        if ($request->tutorial) {
           $tutorial = $request->tutorial;
        }

        if ($request->mid_term) {
           $mid_term = $request->mid_term;
        }

        if ($request->attendance) {
           $attendance = $request->attendance;
        }

        $itpm->tutorial_1       = $tutorial;
        $itpm->mid_term         = $mid_term;
        $itpm->attendance       = $attendance;
        
        $itpm->total            = $tutorial + $mid_term + $attendance;

        if ($itpm->save()) {
            if ($request->lab_seventy_mark) {
                $ispm->save();
            }
            
            Session::flash('success', 'Lab Mark update successfull.');
        }

        return redirect()->route('internal.result.lab-mark.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
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

        $lab_mark = StudentEnroll::leftjoin('students','students.id','=','student_enrolls.student_id')

                    ->leftjoin('course_enrolls','course_enrolls.semester_id','=','student_enrolls.semester_id')

                    ->leftjoin('internal_thirty_percent_marks AS inter_thirty',function($join){
                        $join->on('course_enrolls.course_id', '=', 'inter_thirty.course_id');
                        $join->on('student_enrolls.student_id', '=', 'inter_thirty.student_id');
                    })

                    ->leftjoin('internal_seventy_percent_marks AS inter_seventy',function($join){
                        $join->on('course_enrolls.course_id', '=', 'inter_seventy.course_id');
                        $join->on('student_enrolls.student_id', '=', 'inter_seventy.student_id');
                    })

                    ->select('student_enrolls.student_id', 'students.exam_roll', 'inter_thirty.tutorial_1 as tutorial',
                    'inter_thirty.mid_term','inter_thirty.attendance','inter_thirty.total AS inter_thirty_total','inter_thirty.id AS inter_thirty_id',
                    'inter_seventy.total AS lab_seventy_mark','inter_seventy.id AS inter_seventy_id','inter_seventy.is_absent')

                    ->where('student_enrolls.semester_id',$course_e->semester_id)
                    ->where('course_enrolls.course_id',$course_e->course_id)
                    ->where('course_enrolls.exam_time_id',$course_e->exam_time_id)
                    ->where('course_enrolls.teacher_id',$course_e->teacher_id)
                    ->where('student_enrolls.student_id',$student_id)
                    ->first();

        
        if($lab_mark->lab_seventy_mark){
            $lab_mark['total'] .= $lab_mark->lab_seventy_mark + $lab_mark->tutorial;
        }else{
            $lab_mark['total'] .= $lab_mark->tutorial;
        }

        return view('teacher.result.lab_mark.create')
                ->with('course_e',$course_e)
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
    public function update(Request $request, $inter_thirty_id)
    {
        $this->validate($request,[
            'tutorial'         => 'required|numeric|min:0|max:5',
        ]);

        if ($request->lab_seventy_mark) {
            if ($request->inter_seventy_id) {
                $ispm = ISPM::find($request->inter_seventy_id);
            }else {
                $ispm = new ISPM;
            }
            
            $ispm->semester_id      = $request->semester_id;
            $ispm->course_id        = $request->course_id;
            $ispm->student_id       = $request->student_id;
            $ispm->exam_time_id     = $request->exam_time_id;
            $ispm->is_absent        = $request->is_absent;
            $ispm->teacher_id       = Auth::user()->user_id;

            $ispm->q_1=$ispm->q_2=$ispm->q_3=$ispm->q_4=$ispm->q_5=$ispm->q_6=$ispm->q_7=$ispm->q_8=$ispm->q_9=$ispm->q_10=$ispm->q_11=$ispm->q_12=$ispm->q_13=$ispm->q_14=$ispm->q_15=0;

            if ($request->is_absent) {
                $ispm->total = 0;
            }else {
                $ispm->is_absent = 0;
                $ispm->total     = $request->lab_seventy_mark;
            }
        }

        $itpm = ITPM::find($inter_thirty_id);

        $itpm->semester_id      = $request->semester_id;
        $itpm->course_id        = $request->course_id;
        $itpm->student_id       = $request->student_id;
        $itpm->exam_time_id     = $request->exam_time_id;
        $itpm->teacher_id       = Auth::user()->user_id;

        $itpm->tutorial_2=$itpm->tutorial_3=$itpm->prefer_tutorial_id=$itpm->prefer_tutorial=0;
        $tutorial=$mid_term=$attendance=0;

        if ($request->tutorial) {
           $tutorial = $request->tutorial;
        }

        if ($request->mid_term) {
           $mid_term = $request->mid_term;
        }

        if ($request->attendance) {
           $attendance = $request->attendance;
        }

        $itpm->tutorial_1       = $tutorial;
        $itpm->mid_term         = $mid_term;
        $itpm->attendance       = $attendance;
        
        $itpm->total            = $tutorial + $mid_term + $attendance;

        if ($itpm->save()) {
            if ($request->lab_seventy_mark) {
                $ispm->save();
            }
            
            Session::flash('success', 'Lab Mark update successfull.');
        }

        return redirect()->route('internal.result.lab-mark.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
    }
}
