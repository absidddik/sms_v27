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
use App\Models\Teacher\InternalSeventyPercentMark as ISPM;

class SeventyPercentMarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id,$semester_id)
    {
        return view('teacher.result.70_percent.index')
                ->with('seventy_per_marks', ISPM::where('course_id',$course_id)->where('semester_id',$semester_id)->get());
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'q_1'  => 'required|numeric|min:0|max:14',
            'q_2'  => 'required|numeric|min:0|max:14',
            'q_3'  => 'required|numeric|min:0|max:14',
            'q_4'  => 'required|numeric|min:0|max:14',
            'q_5'  => 'required|numeric|min:0|max:14',
            'q_6'  => 'required|numeric|min:0|max:14',
            'q_7'  => 'required|numeric|min:0|max:14',
            'q_8'  => 'required|numeric|min:0|max:14',
            'q_9'  => 'required|numeric|min:0|max:14',
            'q_10' => 'required|numeric|min:0|max:14',
            'q_11' => 'required|numeric|min:0|max:14',
            'q_12' => 'required|numeric|min:0|max:14',
            'q_13' => 'required|numeric|min:0|max:14',
            'q_14' => 'required|numeric|min:0|max:14',
            'q_15' => 'required|numeric|min:0|max:14',
            'total' => 'required|numeric|min:0|max:70',
        ]);

        $ispm = new ISPM;

        $ispm->semester_id = $request->semester_id;
        $ispm->course_id   = $request->course_id;
        $ispm->exam_time_id= $request->exam_time_id;
        $ispm->student_id  = $request->student_id;
        $ispm->teacher_id  = Auth::user()->user_id;

        $ispm->q_1       = $request->q_1;
        $ispm->q_2       = $request->q_2;
        $ispm->q_3       = $request->q_3;
        $ispm->q_4       = $request->q_4;
        $ispm->q_5       = $request->q_5;
        $ispm->q_6       = $request->q_6;
        $ispm->q_7       = $request->q_7;
        $ispm->q_8       = $request->q_8;
        $ispm->q_9       = $request->q_9;
        $ispm->q_10      = $request->q_10;
        $ispm->q_11      = $request->q_11;
        $ispm->q_12      = $request->q_12;
        $ispm->q_13      = $request->q_13;
        $ispm->q_14      = $request->q_14;
        $ispm->q_15      = $request->q_15;
        $ispm->is_absent = $request->is_absent;
        $ispm->total     = $request->total;

        if($request->is_absent){
            $ispm->q_1=$ispm->q_2=$ispm->q_3=$ispm->q_4=$ispm->q_5=$ispm->q_6=$ispm->q_7=$ispm->q_8=$ispm->q_9=$ispm->q_10=$ispm->q_11=$ispm->q_12=$ispm->q_13=$ispm->q_14=$ispm->q_15=$ispm->total=0;
        }

        if ($ispm->save()) {
            Session::flash('success', 'Seventy Percent Mark update successfull.');
        }

        return redirect()->route('internal.result.seventy.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
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

        $seventy_per_mark = ISPM::where('course_id',$course_e->course->id)
                                ->where('teacher_id',Auth::user()->user_id)
                                ->where('student_id',$student_id)
                                ->where('semester_id',$course_e->semester->id)
                                ->first();

        if (!empty($seventy_per_mark)) {
            return view('teacher.result.70_percent.edit')
                    ->with('course_e',$course_e)
                    ->with('seventy_per_mark',$seventy_per_mark)
                    ->with('route','internal.seventy-percetn-mark.update')
                    ->with('student',Student::where('id',$student_id)->first())
                    ->with('isSubmitted', $isSubmitted);
        }else{
            return view('teacher.result.70_percent.create')
                    ->with('course_e',$course_e)
                    ->with('semester',Semester::find($course_e->semester->id))
                    ->with('route','internal.seventy-percetn-mark.store')
                    ->with('student',Student::where('id',$student_id)->first())
                    ->with('isSubmitted', $isSubmitted);
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
            'q_1'  => 'required|numeric|min:0|max:14',
            'q_2'  => 'required|numeric|min:0|max:14',
            'q_3'  => 'required|numeric|min:0|max:14',
            'q_4'  => 'required|numeric|min:0|max:14',
            'q_5'  => 'required|numeric|min:0|max:14',
            'q_6'  => 'required|numeric|min:0|max:14',
            'q_7'  => 'required|numeric|min:0|max:14',
            'q_8'  => 'required|numeric|min:0|max:14',
            'q_9'  => 'required|numeric|min:0|max:14',
            'q_10' => 'required|numeric|min:0|max:14',
            'q_11' => 'required|numeric|min:0|max:14',
            'q_12' => 'required|numeric|min:0|max:14',
            'q_13' => 'required|numeric|min:0|max:14',
            'q_14' => 'required|numeric|min:0|max:14',
            'q_15' => 'required|numeric|min:0|max:14',
            'total' => 'required|numeric|min:0|max:70',
        ]);

        $ispm = ISPM::find($id);

        $ispm->semester_id = $request->semester_id;
        $ispm->course_id   = $request->course_id;
        $ispm->student_id  = $request->student_id;
        $ispm->exam_time_id= $request->exam_time_id;
        $ispm->teacher_id  = Auth::user()->user_id;

        $ispm->q_1       = $request->q_1;
        $ispm->q_2       = $request->q_2;
        $ispm->q_3       = $request->q_3;
        $ispm->q_4       = $request->q_4;
        $ispm->q_5       = $request->q_5;
        $ispm->q_6       = $request->q_6;
        $ispm->q_7       = $request->q_7;
        $ispm->q_8       = $request->q_8;
        $ispm->q_9       = $request->q_9;
        $ispm->q_10      = $request->q_10;
        $ispm->q_11      = $request->q_11;
        $ispm->q_12      = $request->q_12;
        $ispm->q_13      = $request->q_13;
        $ispm->q_14      = $request->q_14;
        $ispm->q_15      = $request->q_15;
        $ispm->is_absent = $request->is_absent;
        $ispm->total     = $request->total;

        if($request->is_absent){
            $ispm->q_1=$ispm->q_2=$ispm->q_3=$ispm->q_4=$ispm->q_5=$ispm->q_6=$ispm->q_7=$ispm->q_8=$ispm->q_9=$ispm->q_10=$ispm->q_11=$ispm->q_12=$ispm->q_13=$ispm->q_14=$ispm->q_15=$ispm->total=0;
        }else {
            $ispm->is_absent = 0;
        }

        if ($ispm->save()) {
            Session::flash('success', 'Seventy Percent Mark update successfull.');
        }

        return redirect()->route('internal.result.seventy.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
    }
}
