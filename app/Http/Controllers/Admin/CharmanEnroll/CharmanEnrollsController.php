<?php

namespace App\Http\Controllers\Admin\CharmanEnroll;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Models\Admin\ExamTime;
use App\Models\Admin\Semester;
use App\Models\Admin\UserRole;
use App\Models\Admin\CharmanEnroll;
use App\Http\Controllers\Controller;

class CharmanEnrollsController extends Controller
{
    /**
       * Display a listing of the resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function index()
      {
          return view('admin.charmanEnroll.index')
          ->with('semesters', Semester::pluck('semester','id')->all());
      }

      /**
       * Show the form for creating a new resource.
       *
       * @return \Illuminate\Http\Response
       */
      public function create()
      {
          $teacher_role = UserRole::where('name', User::TEACHER)->first();
          return view('admin.charmanEnroll.create')
          ->with('semesters', Semester::pluck('semester','id')->all())
          ->with('exam_times', ExamTime::get())
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
              'semester' => 'required|numeric|unique:charman_enrolls,semester_id',
              'exam_time' => 'required|numeric',
              'charman' => 'required|numeric',
          ]);

          $c_enroll = new CharmanEnroll();
          $c_enroll->supervisor_id = Auth::user()->user_id;
          $c_enroll->semester_id = $request->semester;
          $c_enroll->exam_time_id = $request->exam_time;
          $c_enroll->charman_id = $request->charman;

          if ($c_enroll->save()) {
              Session::flash('success','Charman enroll successfull');
          }

          return redirect()->back();
      }

      public function getBySemester(Request $request)
      {
          $this->validate($request,[
              'semester' => 'required|numeric',
          ]);

          $charmanEnrolls = CharmanEnroll::where('semester_id',$request->semester)->get();

           return view('admin.charmanEnroll.index')
           ->with('semesters', Semester::pluck('semester','id')->all())
           ->with('charmanEnrolls', $charmanEnrolls);
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

          $charmanEnrolls = CharmanEnroll::where('semester_id',$request->semester_id)->get();

           return view('admin.charmanEnroll.index')
           ->with('semesters', Semester::pluck('semester','id')->all())
           ->with('charmanEnrolls', $charmanEnrolls);
      }

      /**
       * Show the form for editing the specified resource.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function edit(CharmanEnroll $charmanEnroll)
      {
          $teacher_role = UserRole::where('name','teacher')->first();
          return view('admin.charmanEnroll.edit')
          ->with('charmanEnroll', $charmanEnroll)
          ->with('semesters', Semester::pluck('semester','id')->all())
          ->with('exam_times', ExamTime::get())
          ->with('charmans', $teacher_role->users);
      }

      /**
       * Update the specified resource in storage.
       *
       * @param  \Illuminate\Http\Request  $request
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function update(Request $request, charmanEnroll $charmanEnroll)
      {
          $this->validate($request,[
              'semester' => 'required|numeric',
              'exam_time' => 'required|numeric',
              'charman' => 'required|numeric',
          ]);

          $c_enroll = $charmanEnroll;
          $c_enroll->supervisor_id = Auth::user()->user_id;
          $c_enroll->semester_id = $request->semester;
          $c_enroll->charman_id = $request->charman;
          $c_enroll->exam_time_id = $request->exam_time;

          if ($c_enroll->save()) {
              Session::flash('success','Charman enroll update successfull');
          }

          return redirect()->back();
      }

      /**
       * Remove the specified resource from storage.
       *
       * @param  int  $id
       * @return \Illuminate\Http\Response
       */
      public function destroy(charmanEnroll $charmanEnroll)
      {
          if ($charmanEnroll->delete()) {
              Session::flash('success','Charman enroll delete successfull');
          }

          return redirect()->back();

      }
  }
