<?php

namespace App\Http\Controllers\Admin\ExamTime;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Models\Admin\ExamTime;
use App\Http\Controllers\Controller;

class ExamTimesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.exam_time.index')
                ->with('exam_times', ExamTime::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.exam_time.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'exam_month' => 'required',
            'exam_year' => 'required|numeric',
        ]);

        $exam_time = new ExamTime();

        $exam_time->supervisor_id = Auth::user()->user_id;
        $exam_time->exam_month = $request->exam_month;
        $exam_time->exam_year = $request->exam_year;
        $exam_time->slug = str_slug($request->exam_month.' '.$request->exam_year);

        if ($exam_time->save()) {
            Session::flash('success','Exam Time create successfull');
        }else {
            Session::flash('fail','Exam Time create failed');
        }
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ExamTime $exam_time)
    {
        return view('admin.exam_time.edit')
                ->with('exam_time', $exam_time);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,ExamTime $exam_time)
    {
        $this->validate($request, [
            'exam_month' => 'required',
            'exam_year' => 'required|numeric',
        ]);

        $exam_time->supervisor_id = Auth::user()->user_id;
        $exam_time->exam_month = $request->exam_month;
        $exam_time->exam_year = $request->exam_year;
        $exam_time->slug = str_slug($request->exam_month.' '.$request->exam_year);

        if ($exam_time->save()) {
            Session::flash('success','Exam Time create successfull');
        }else {
            Session::flash('fail','Exam Time create failed');
        }
        return redirect()->route('exam-time.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExamTime $exam_time)
    {
        if ($exam_time->delete()) {
            Session::flash('success','Exam Time delete successfull');
        }

        return redirect()->back();
    }
}
