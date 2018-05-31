<?php

namespace App\Http\Controllers\Teacher\PDF;

use PDF;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;
use App\Models\Admin\CourseEnroll;
use App\Models\Teacher\InternalThirtyPercentMark as ITPM;
use App\Models\Teacher\InternalSeventyPercentMark as ISPM;

class PDFController extends Controller
{
    public $isSubmitted = false;

    public function thirty_percent_mark($e_id, $c_id, $s_id,$format)
    {

        $results =  $this->get_result($e_id, $c_id, $s_id);

        $c_e_detail = CourseEnroll::where('exam_time_id',$e_id)->where('course_id',$c_id)->where('semester_id',$s_id)
                                    ->where('teacher_id',Auth::user()->user_id)->first();
        if ($format=='full') {
            $test_array = ['s'=>1,'a'=>1,'ct'=>1,'m'=>1,'t'=>1,'g'=>1];
        } elseif ($format=='thirty') {
            // thirty
            $test_array = ['s'=>0,'a'=>1,'ct'=>1,'m'=>1,'t'=>0,'g'=>0];
        } elseif ($format=='WOTG') { 
            // without total and grade
            $test_array = ['s'=>1,'a'=>1,'ct'=>1,'m'=>1,'t'=>0,'g'=>0];
        } elseif ($format=='WOG') {
            // without grade
            $test_array = ['s'=>1,'a'=>1,'ct'=>1,'m'=>1,'t'=>1,'g'=>0];
        }

        $pdf = PDF::loadView('teacher.pdf.full_result',['results'=>$results,'exam_time_id'=>$e_id,'course_id'=>$c_id,
                                'semester_id'=>$s_id,'ce_detail'=>$c_e_detail,'c_show'=>$test_array]);
        $pdf->setPaper('A4', 'portal');
        return $pdf->download($c_e_detail->exam_time->exam_year.' '.time().'.pdf');
    }

    public function get_result($e_id, $c_id, $s_id)
    {
        $sql = 'SELECT internal_seventy_percent_marks.total as seventy_total, internal_thirty_percent_marks.*, students.exam_roll ';
        $sql .= 'FROM internal_seventy_percent_marks ';
        $sql .= 'INNER JOIN students ';
        $sql .= 'ON internal_seventy_percent_marks.student_id = students.id ';
        $sql .= 'INNER JOIN internal_thirty_percent_marks ';
        $sql .= 'ON internal_seventy_percent_marks.exam_time_id = internal_thirty_percent_marks.exam_time_id ';
        $sql .= 'WHERE internal_seventy_percent_marks.teacher_id = internal_thirty_percent_marks.teacher_id AND ';
        $sql .= 'internal_seventy_percent_marks.student_id = internal_thirty_percent_marks.student_id AND ';
        $sql .= 'internal_seventy_percent_marks.course_id = internal_thirty_percent_marks.course_id AND ';
        $sql .= 'internal_seventy_percent_marks.exam_time_id = internal_thirty_percent_marks.exam_time_id AND ';
        $sql .= 'internal_seventy_percent_marks.semester_id = internal_thirty_percent_marks.semester_id AND ';
        $sql .= 'internal_seventy_percent_marks.exam_time_id = '.$e_id.' AND ';
        $sql .= 'internal_seventy_percent_marks.course_id = '.$c_id.' AND ';
        $sql .= 'internal_seventy_percent_marks.semester_id = '.$s_id.' AND ';
        $sql .= 'internal_seventy_percent_marks.teacher_id = '.Auth::user()->user_id.' ';

        return DB::select($sql);
    }

    public function internal_seventy_percent_mark($course_e_id='')
    {
        $course_e = CourseEnroll::find($course_e_id);

        $marks = ISPM::where('teacher_id',Auth::user()->user_id)
                        ->where('course_id',$course_e->course_id)
                        ->where('semester_id',$course_e->semester_id)
                        ->where('exam_time_id',$course_e->exam_time_id)
                        ->get();

        $pdf = PDF::loadView('teacher.pdf.70_mark',['results'=>$marks,'ce_detail'=>$course_e]);
        $pdf->setPaper('A4', 'portal');
        return $pdf->download($course_e->exam_time->exam_year.' '.time().'.pdf');

        // return view('teacher.pdf.70_mark')
        //         ->with('results', $marks)
        //         ->with('ce_detail', $course_e);
    }
}
