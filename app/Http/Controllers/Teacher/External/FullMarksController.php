<?php

namespace App\Http\Controllers\Teacher\External;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;
use App\Models\Teacher\ExternalSeventyPercentMark as ISPM;

class FullMarksController extends Controller
{
    public $isSubmitted = false;

    public function index($e_id, $c_id, $s_id)
    {
        $sr = SubmittedResult::where('exam_time_id',$e_id)
        ->where('course_id',$c_id)
        ->where('semester_id',$s_id)
        ->where('teacher_id', Auth::user()->user_id)
        ->first();
        if ($sr) {
            $this->isSubmitted = true;
        }
        // $result =  ISPM::select('external_seventy_percent_marks.total as seventy_total', 'external_thirty_percent_marks.*')
        // ->join('external_thirty_percent_marks', 'external_seventy_percent_marks.exam_time_id', '=', 'external_thirty_percent_marks.exam_time_id')
        // ->where('external_seventy_percent_marks.teacher_id', 'external_thirty_percent_marks.teacher_id')
        // ->get();

        $sql = 'SELECT external_seventy_percent_marks.total as seventy_total, students.exam_roll ';
        $sql .= 'FROM external_seventy_percent_marks ';
        $sql .= 'INNER JOIN students ';
        $sql .= 'ON external_seventy_percent_marks.student_id = students.id ';
        $sql .= 'WHERE external_seventy_percent_marks.exam_time_id = '.$e_id.' AND ';
        $sql .= 'external_seventy_percent_marks.course_id = '.$c_id.' AND ';
        $sql .= 'external_seventy_percent_marks.semester_id = '.$s_id.' AND ';
        $sql .= 'external_seventy_percent_marks.teacher_id = '.Auth::user()->user_id.' ';


        $results =  DB::select($sql);

        return view('teacher.external.result.full.index')
                ->with('results', $results)
                ->with('exam_time_id', $e_id)
                ->with('course_id', $c_id)
                ->with('semester_id', $s_id)
                ->with('isSubmitted', $this->isSubmitted);
    }
}
