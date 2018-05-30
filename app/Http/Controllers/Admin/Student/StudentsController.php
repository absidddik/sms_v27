<?php

namespace App\Http\Controllers\Admin\Student;

use Auth;
use Image;
use Session;
use App\Models\Admin\Batch;
use App\Models\Admin\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StudentCreateRequest;
use App\Http\Requests\StudentUpdateRequest;

class StudentsController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('admin.student.index')
                ->with('students', Student::select('id', 'image', 'batch_id','reg_no','class_roll','exam_roll', 'name', 'email')
                ->get());
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('admin.student.create')
        ->with('batches', Batch::all())
        ->with('default_password', Student::DEFAULT_PASSWORD);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(StudentCreateRequest $request)
    {
        $input = $request->all();

        if ($image = $request->file('image')) {
            $new_name       = str_slug($request->reg_no) . time() . '.' .$image->getClientOriginalExtension();
            $input['image'] = $new_name;
            //........processing image to storage
            $img = Image::make($image->getRealPath());
            $img->resize(240, 320, function ($constraint) {});
            $img->stream();
            //........saving to studen disk
            Storage::disk('student')->put($new_name, $img,'public');
        }

        $input['name']       = ucwords($request->name);
        $input['guardian']   = ucwords($request->guardian);
        $input['password']   = bcrypt($request->password);
        $input['supervisor_id']    = Auth::user()->user_id;
        $input['is_present'] = Student::PRESENT_STUDENT;

        if (Student::create($input)) {
            Session::flash('success', 'Student create successfull');
        } else {
            Session::flash('fail', 'Student create failed');
        }

        return redirect()->back();
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Student $student)
    {
        return view('admin.student.view')
                ->with('student', $student);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Student $student)
    {
        return view('admin.student.edit')
                ->with('student', $student)
                ->with('batches', Batch::all());
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(StudentUpdateRequest $request, Student $student)
    {
        //.......validation only for email and registration no update
        $this->validate($request,[
            'reg_no' => 'required|unique:students,reg_no,'.$student->id,
            'email' => 'required|email|unique:students,email,'.$student->id,
        ]);

        $input = $request->all();

        if ($image = $request->file('image')) {
            $input['image'] = $student->image;
            //........processing image to storage
            $img = Image::make($image->getRealPath());
            $img->resize(240, 320, function ($constraint) {});
            $img->stream();
            //........saving to studen disk
            Storage::disk('student')->put($student->image, $img,'public');
        }

        //..........manipulate password
        if ($request->password) {
            $pass = $request->password;
            if (strlen($pass) < 6) {
                Session::flash('info','Password length at least 6.');
                return redirect()->back();
            }
            $input['password'] = bcrypt($request->password);
        }else{
            $input['password'] = $student->password;
        }

        $input['supervisor_id'] = Auth::user()->user_id;

        if ($student->update($input)) {
            Session::flash('success', 'Student update successfull');
        } else {
            Session::flash('fail', 'Student update failed');
        }
        return redirect()->route('student.index');

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Student $student)
    {
        if ($student->delete()) {
            //......delete file form disk
            Storage::disk('student')->delete($student->image);
            Session::flash('success', 'Student delete successfull');
        } else {
            Session::flash('fail', 'Student delete failed');
        }
        return redirect()->back();
    }
}
