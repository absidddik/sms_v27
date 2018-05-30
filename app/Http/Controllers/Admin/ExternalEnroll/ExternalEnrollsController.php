<?php

namespace App\Http\Controllers\Admin\ExternalEnroll;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Models\Admin\Course;
use App\Models\Admin\ExamTime;
use App\Models\Admin\Semester;
use App\Models\Admin\UserRole;
use App\Models\Admin\ExternalEnroll;
use App\Http\Controllers\Controller;

class ExternalEnrollsController extends Controller
{
    /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
          return view('admin.externalEnroll.index')
          ->with('semesters', Semester::pluck('semester','id')->all());
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
          $teacher_role = UserRole::where('name', 'teacher')->first();
          return view('admin.externalEnroll.create')
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

          $c_enroll = new ExternalEnroll();
          $c_enroll->supervisor_id = Auth::user()->user_id;
          $c_enroll->semester_id = $request->semester;
          $c_enroll->course_id = $request->course;
          $c_enroll->exam_time_id = $request->exam_time;
          $c_enroll->teacher_id = $request->teacher;

          if ($c_enroll->save()) {
              Session::flash('success','External teacher enroll successfull');
          }

          return redirect()->back();
      }

      public function getBySemester(Request $request)
      {
          $this->validate($request,[
              'semester' => 'required|numeric',
          ]);

          $courseEnrolls = ExternalEnroll::where('semester_id',$request->semester)->get();

           return view('admin.courseEnroll.index')
           ->with('semesters', Semester::pluck('semester','id')->all())
           ->with('courseEnrolls', $courseEnrolls);
      }

      /**
       * Display the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function show(Request $request)
      {
          $this->validate($request,[
              'semester_id' => 'required|numeric',
          ],[
              'semester_id.required' => 'The semester field is required.',
          ]);

          $externalEnrolls = ExternalEnroll::where('semester_id',$request->semester_id)->get();

           return view('admin.externalEnroll.index')
           ->with('semesters', Semester::pluck('semester','id')->all())
           ->with('externalEnrolls', $externalEnrolls);
      }

      /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function edit(ExternalEnroll $externalEnroll)
      {
          $teacher_role = UserRole::where('name','external teacher')->first();
          return view('admin.externalEnroll.edit')
          ->with('externalEnroll', $externalEnroll)
          ->with('semesters', Semester::pluck('semester','id')->all())
          ->with('exam_times', ExamTime::get())
          ->with('courses', Course::pluck('name','id')->all())
          ->with('teachers', $teacher_role->users);
      }

      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, ExternalEnroll $externalEnroll)
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
              Session::flash('success','External teacher enroll update successfull');
          }

          return redirect()->back();
      }

      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function destroy(ExternalEnroll $externalEnroll)
      {
          if ($externalEnroll->delete()) {
              Session::flash('success','External teacher enroll delete successfull');
          }

          return redirect()->back();

      }
  }
