<?php

namespace App\Http\Controllers\Result\Submit;

use Auth;
use Session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;

class SubmitController extends Controller
{
    public function submit(Request $request)
    {
        $sr               = new SubmittedResult();
        $sr->teacher_id   = Auth::user()->user_id;
        $sr->exam_time_id = $request->exam_time_id;
        $sr->course_id    = $request->course_id;
        $sr->semester_id  = $request->semester_id;

        if ($sr->save()) {
            Session::flash('success','Result Submitted');
        }

        return redirect()->back();
    }
}
