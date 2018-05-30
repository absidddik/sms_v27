<?php

namespace App\Http\Controllers\Admin\Course;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\Admin\Course;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.course.index')
        ->with('courses', Course::all());
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('admin.course.create')
        ->with('types', Course::COURSE_TYPES)
        ->with('credits', Course::COURSE_CREDITS)
        ->with('marks', Course::COURSE_MARKS);
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
            'type' => 'required|numeric',
            'name' => 'required|min:2|max:150|unique:courses',
            'code' => 'required|min:2|max:150|unique:courses',
            'credit' => 'required|numeric',
            'mark' => 'required|numeric',
            'content' => 'required',
        ]);

        $input = $request->all();
        $input['user_id'] = Auth::user()->user_id;
        $input['name'] = ucwords($request->name);
        $input['code'] = strtoupper($request->code);

        if (Course::create($input)) {
            Session::flash('success','Course create successfull.');
        }
        return redirect()->back();
    }



    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Admin\course  $course
    * @return \Illuminate\Http\Response
    */
    public function edit(course $course)
    {
        return view('admin.course.edit')
        ->with('types', Course::COURSE_TYPES)
        ->with('credits', Course::COURSE_CREDITS)
        ->with('marks', Course::COURSE_MARKS)
        ->with('course', $course);

    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Models\Admin\course  $course
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, course $course)
    {
        $this->validate($request,[
            'type' => 'required|numeric',
            'name' => 'required|min:2|max:150|unique:courses,name,'.$course->id,
            'code' => 'required|min:2|max:150|unique:courses,code,'.$course->id,
            'credit' => 'required|numeric',
            'mark' => 'required|numeric',
            'content' => 'required|',
        ]);

        $input = $request->all();
        $input['name'] = ucwords($request->name);
        $input['code'] = strtoupper($request->code);

        if ($course->update($input)) {
            Session::flash('success','Course update successfull.');
        }
        return redirect()->route('course.index');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Admin\course  $course
    * @return \Illuminate\Http\Response
    */
    public function destroy(course $course)
    {
        if ($course->delete()) {
            Session::flash('success','Course delete successfull.');
        }
        return redirect()->route('course.index');
    }
}
