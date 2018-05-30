<?php

namespace App\Http\Controllers\Admin\BatchEnroll;

use Auth;
use Session;
use App\User;
use Illuminate\Http\Request;
use App\Models\Admin\Batch;
use App\Models\Admin\ExamTime;
use App\Models\Admin\Semester;
use App\Models\Admin\BatchEnroll;
use App\Http\Controllers\Controller;

class BatchEnrollsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.batchEnroll.index')
        ->with('exam_times', ExamTime::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.batchEnroll.create')
                ->with('exam_times', ExamTime::get())
                ->with('semesters', Semester::pluck('semester','id')->all())
                ->with('batches', Batch::pluck('batch_number','id')->all());
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
            'semester'  => 'required|numeric',
            'batch'   => 'required|numeric',
            'exam_time' => 'required|numeric',
        ]);

        $b_enroll = new BatchEnroll();

        $b_enroll->supervisor_id = Auth::user()->user_id;
        $b_enroll->semester_id   = $request->semester;
        $b_enroll->batch_id      = $request->batch;
        $b_enroll->exam_time_id  = $request->exam_time;

        if ($b_enroll->save()) {
            Session::flash('success','Batch enroll successfull');
        }

        return redirect()->back();
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
            'exam_time' => 'required|numeric',
        ],[
            'exam_time.required' => 'The exam time field is required.',
        ]);

        $batchEnrolls = BatchEnroll::where('exam_time_id',$request->exam_time)->get();

         return view('admin.batchEnroll.index')
         ->with('exam_times', ExamTime::all())
         ->with('batchEnrolls', $batchEnrolls);
    }

    public function getByExanTime(Request $request)
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BatchEnroll $batch_enroll)
    {
        return view('admin.batchEnroll.edit')
                ->with('batch_enroll', $batch_enroll)
                ->with('exam_times', ExamTime::get())
                ->with('semesters', Semester::pluck('semester','id')->all())
                ->with('batches', Batch::pluck('batch_number','id')->all());
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
            'semester'  => 'required|numeric',
            'batch'   => 'required|numeric',
            'exam_time' => 'required|numeric',
        ]);

        $b_enroll = BatchEnroll::find($id);

        $b_enroll->supervisor_id = Auth::user()->user_id;
        $b_enroll->semester_id   = $request->semester;
        $b_enroll->batch_id      = $request->batch;
        $b_enroll->exam_time_id  = $request->exam_time;

        if ($b_enroll->save()) {
            Session::flash('success','Batch enroll update successfull');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BatchEnroll $batch_enroll)
    {
        if ($batch_enroll->delete()) {
            Session::flash('success','Batch enroll delete successfull');
        }
        
        return redirect()->back();
    }
}
