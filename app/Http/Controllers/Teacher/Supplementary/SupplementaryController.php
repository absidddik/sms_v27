<?php

namespace App\Http\Controllers\Teacher\Supplementary;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\Admin\Student;
use App\Models\Admin\Semester;
use App\Models\Teacher\SuppMark;
use App\Models\Admin\courseEnroll;
use App\Http\Controllers\Controller;
use App\Models\SuppEnroll\SuppEnroll;
use App\Models\Result\SubmittedResult;

class SupplementaryController extends Controller
{
    public function index()
    {
        $semesters = SuppEnroll::where('teacher_id',Auth::user()->user_id)->distinct()->get(['semester_id']);

        $output = '';
        $output .= '<ul class="list-group">';
        foreach ($semesters as $semester) {
            $output .= '<li class="list-group-item active">'.'Semester '.$semester->semester->semester.'
            <ol class="list-group">';
            $courses = SuppEnroll::where('teacher_id',Auth::user()->user_id)->where('semester_id',$semester->semester_id)->distinct()->get(['course_id','course_e_id']);
            foreach ($courses as $course) {
                if(strpos(strtolower($course->course->name), 'viva voce') !== false){
                    $output .='<li class="list-group-item"><a href="'.
                    route('internal.supp-result.viva-voce.show',['course_id'=>$course->course_e_id,'semester_id'=>$semester->semester_id]).'">'.$course->course->name
                    .'</a></li>';
                }else if(strpos(strtolower($course->course->name), 'lab') !== false){
                    $output .='<li class="list-group-item"><a href="'.
                    route('internal.supp-result.lab-mark.show',['course_id'=>$course->course_e_id,'semester_id'=>$semester->semester_id]).'">'.$course->course->name
                    .'</a></li>';
                }else{
                    $output .='<li class="list-group-item"><a href="'.
                    route('result.supp.show',['course_id'=>$course->course_e_id,'semester_id'=>$semester->semester_id]).'">'.$course->course->name
                    .'</a></li>';
                }
            }
            $output .='</ol>
            </li>';
        }
        $output .='<br></ul>';

        // echo '<pre>';
        // print_r($courses); exit;
        // echo '</pre>';

        return view('teacher.supp.index')->with('semester_course',$output);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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

        $supp_mark = new SuppMark;

        $supp_mark->semester_id = $request->semester_id;
        $supp_mark->course_id   = $request->course_id;
        $supp_mark->exam_time_id= $request->exam_time_id;
        $supp_mark->student_id  = $request->student_id;
        $supp_mark->teacher_id  = Auth::user()->user_id;

        $supp_mark->q_1   = $request->q_1;
        $supp_mark->q_2   = $request->q_2;
        $supp_mark->q_3   = $request->q_3;
        $supp_mark->q_4   = $request->q_4;
        $supp_mark->q_5   = $request->q_5;
        $supp_mark->q_6   = $request->q_6;
        $supp_mark->q_7   = $request->q_7;
        $supp_mark->q_8   = $request->q_8;
        $supp_mark->q_9   = $request->q_9;
        $supp_mark->q_10  = $request->q_10;
        $supp_mark->q_11  = $request->q_11;
        $supp_mark->q_12  = $request->q_12;
        $supp_mark->q_13  = $request->q_13;
        $supp_mark->q_14  = $request->q_14;
        $supp_mark->q_15  = $request->q_15;
        $supp_mark->total = $request->total;

        if ($supp_mark->save()) {
            Session::flash('success', 'Seventy Percent Mark update successfull.');
        }

        return redirect()->route('result.supp.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
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

        $supp_mark = SuppMark::where('course_id',$course_e->course_id)
                                ->where('teacher_id',Auth::user()->user_id)
                                ->where('student_id',$student_id)
                                ->where('semester_id',$course_e->semester_id)
                                ->where('exam_time_id',$supp_e->exam_time_id)
                                ->first();

        if (!empty($supp_mark)) {
            return view('teacher.result.supp.seventy.edit')
            ->with('course_e',$course_e)
            ->with('supp_e',$supp_e)
            ->with('supp_mark',$supp_mark)
            ->with('route','supplementary-mark.update')
            ->with('student',Student::where('id',$student_id)->first())
            ->with('isSubmitted', $isSubmitted);
        }else{
            return view('teacher.result.supp.seventy.create')
            ->with('course_e',$course_e)
            ->with('supp_e',$supp_e)
            ->with('semester',Semester::find($course_e->semester_id))
            ->with('route','supplementary-mark.store')
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

        $supp_mark = SuppMark::find($id);

        $supp_mark->semester_id = $request->semester_id;
        $supp_mark->course_id   = $request->course_id;
        //$supp_mark->student_id  = $request->student_id;
        $supp_mark->exam_time_id= $request->exam_time_id;
        $supp_mark->teacher_id  = Auth::user()->user_id;

        $supp_mark->q_1   = $request->q_1;
        $supp_mark->q_2   = $request->q_2;
        $supp_mark->q_3   = $request->q_3;
        $supp_mark->q_4   = $request->q_4;
        $supp_mark->q_5   = $request->q_5;
        $supp_mark->q_6   = $request->q_6;
        $supp_mark->q_7   = $request->q_7;
        $supp_mark->q_8   = $request->q_8;
        $supp_mark->q_9   = $request->q_9;
        $supp_mark->q_10  = $request->q_10;
        $supp_mark->q_11  = $request->q_11;
        $supp_mark->q_12  = $request->q_12;
        $supp_mark->q_13  = $request->q_13;
        $supp_mark->q_14  = $request->q_14;
        $supp_mark->q_15  = $request->q_15;
        $supp_mark->total = $request->total;

        if ($supp_mark->save()) {
            Session::flash('success', 'Seventy Percent Mark update successfull.');
        }

        return redirect()->route('result.supp.show',['course_e_id'=>$request->course_e_id,'semester_id'=>$request->semester_id]);
    }
}
