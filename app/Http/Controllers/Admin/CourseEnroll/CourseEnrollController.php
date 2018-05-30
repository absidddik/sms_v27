<?php

namespace App\Http\Controllers\Admin\CourseEnroll;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Models\Admin\Course;
use App\Models\Admin\ExamTime;
use App\Models\Admin\Semester;
use App\Models\Admin\UserRole;
use App\Models\Admin\courseEnroll;
use App\Http\Controllers\Controller;

class CourseEnrollController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.courseEnroll.index')
        ->with('semesters', Semester::pluck('semester','id')->all());
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $teacher_role = UserRole::where('name','teacher')->first();
        return view('admin.courseEnroll.create')
        ->with('semesters', Semester::pluck('semester','id')->all())
        ->with('exam_times', ExamTime::get())
        ->with('courses', Course::pluck('name','id')->all())
        ->with('teachers', $teacher_role->users);
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
            'semester' => 'required|numeric',
            'course' => 'required|numeric',
            'exam_time' => 'required|numeric',
            'teacher' => 'required|numeric',
        ]);

        $c_enroll = new CourseEnroll();
        $c_enroll->supervisor_id = Auth::user()->user_id;
        $c_enroll->semester_id = $request->semester;
        $c_enroll->course_id = $request->course;
        $c_enroll->exam_time_id = $request->exam_time;
        $c_enroll->teacher_id = $request->teacher;

        if ($c_enroll->save()) {
            Session::flash('success','Course enroll successfull');
        }

        return redirect()->back();
    }


    public function getBySemester(Request $request)
    {
        $this->validate($request,[
            'semester' => 'required|numeric',
        ]);

        $courseEnrolls = CourseEnroll::where('semester_id',$request->semester)->get();

         return view('admin.courseEnroll.index')
         ->with('semesters', Semester::pluck('semester','id')->all())
         ->with('courseEnrolls', $courseEnrolls);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Models\Admin\courseEnroll  $courseEnroll
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request)
    {
        $this->validate($request,[
            'semester_id' => 'required|numeric',
        ],[
            'semester_id.required' => 'The semester field is required.',
        ]);

        $courseEnrolls = CourseEnroll::where('semester_id',$request->semester_id)->get();

         return view('admin.courseEnroll.index')
         ->with('semesters', Semester::pluck('semester','id')->all())
         ->with('courseEnrolls', $courseEnrolls);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Admin\courseEnroll  $courseEnroll
    * @return \Illuminate\Http\Response
    */
    public function edit(CourseEnroll $courseEnroll)
    {
        $teacher_role = UserRole::where('name','teacher')->first();
        return view('admin.courseEnroll.edit')
        ->with('courseEnroll', $courseEnroll)
        ->with('semesters', Semester::pluck('semester','id')->all())
        ->with('exam_times', ExamTime::get())
        ->with('courses', Course::pluck('name','id')->all())
        ->with('teachers', $teacher_role->users);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Admin\courseEnroll  $courseEnroll
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, courseEnroll $courseEnroll)
    {
        $this->validate($request,[
            'semester' => 'required|numeric',
            'course' => 'required|numeric',
            'exam_time' => 'required|numeric',
            'teacher' => 'required|numeric',
        ]);

        $c_enroll = $courseEnroll;
        $c_enroll->supervisor_id = Auth::user()->user_id;
        $c_enroll->semester_id = $request->semester;
        $c_enroll->course_id = $request->course;
        $c_enroll->exam_time_id = $request->exam_time;
        $c_enroll->teacher_id = $request->teacher;

        if ($c_enroll->save()) {
            Session::flash('success','course enroll update successfull');
        }

        return redirect()->back();
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Admin\courseEnroll  $courseEnroll
    * @return \Illuminate\Http\Response
    */
    public function destroy(courseEnroll $courseEnroll)
    {
        if ($courseEnroll->delete()) {
            Session::flash('success','course enroll delete successfull');
        }

        return redirect()->back();
    }
}
