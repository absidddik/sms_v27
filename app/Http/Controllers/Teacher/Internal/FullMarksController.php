<?php

namespace App\Http\Controllers\Teacher\Internal;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;
use App\Models\Admin\CourseEnroll;
use App\Models\Teacher\InternalThirtyPercentMark as ITPM;
use App\Models\Teacher\InternalSeventyPercentMark as ISPM;

class FullMarksController extends Controller
{
    public $isSubmitted = false;

    public function index($e_id, $c_id, $s_id)
    {
        $all_results = [];

        $sr = SubmittedResult::where('exam_time_id',$e_id)
        ->where('course_id',$c_id)
        ->where('semester_id',$s_id)
        ->where('teacher_id', Auth::user()->user_id)
        ->first();

        if ($sr) {
            $this->isSubmitted = true;
        }

        $c_e_detail = CourseEnroll::where('exam_time_id',$e_id)
        ->where('course_id',$c_id)->where('semester_id',$s_id)
        ->where('teacher_id',Auth::user()->user_id)->first();

        $course_cedit = $c_e_detail->course->credit;


        //.........only for lab exam
        if ($course_cedit == 1) {
            $sql = 'SELECT internal_seventy_percent_marks.total as seventy_total, internal_seventy_percent_marks.is_absent , students.exam_roll ';
            $sql .= 'FROM internal_seventy_percent_marks ';
            $sql .= 'INNER JOIN students ';
            $sql .= 'ON internal_seventy_percent_marks.student_id = students.id ';
            $sql .= 'WHERE internal_seventy_percent_marks.exam_time_id = '.$e_id.' AND ';
            $sql .= 'internal_seventy_percent_marks.course_id = '.$c_id.' AND ';
            $sql .= 'internal_seventy_percent_marks.semester_id = '.$s_id.' AND ';
            $sql .= 'internal_seventy_percent_marks.teacher_id = '.Auth::user()->user_id.' ';
            $sql .= 'ORDER BY students.exam_roll';

        } else {
            $sql = 'SELECT internal_seventy_percent_marks.total as seventy_total, internal_seventy_percent_marks.is_absent, internal_thirty_percent_marks.*, students.exam_roll ';
            $sql .= 'FROM internal_seventy_percent_marks ';
            $sql .= 'INNER JOIN students ';
            $sql .= 'ON internal_seventy_percent_marks.student_id = students.id ';
            $sql .= 'LEFT JOIN internal_thirty_percent_marks ';
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
            $sql .= 'ORDER BY students.exam_roll';
        }


        $results =  DB::select($sql);


        //.........only for lab exam
        if ($course_cedit == 1) {
            //.......crate new student object
            foreach ($results as $r) {
                $student = new \stdClass();
                $student->exam_roll = $r->exam_roll;
                $student->attendance = '';
                $student->class_test = '';
                $student->mid_term = '';
                $student->thirty_total = 0;
                $student->seventy_total = $r->seventy_total;
                $student->total = $this->total($student->seventy_total, $student->thirty_total);
                $student->grade = $this->creditGrade($student->total, $c_e_detail->course->credit);
                $student->is_absent = $r->is_absent;

                $all_results[] = $student;
            }
        }else {
            //.......crate new student object
            foreach ($results as $r) {
                $student = new \stdClass();
                $student->exam_roll = $r->exam_roll;
                $student->attendance = $r->attendance;
                $student->class_test = $r->prefer_tutorial;
                $student->mid_term = $r->mid_term;
                $student->thirty_total = $r->total;
                $student->seventy_total = $r->seventy_total;
                $student->total = $this->total($student->seventy_total, $student->thirty_total);
                $student->grade = $this->creditGrade($student->total, $c_e_detail->course->credit);
                $student->is_absent = $r->is_absent;

                $all_results[] = $student;

            }
        }



        //return $all_results;


        $c_e_detail = CourseEnroll::where('exam_time_id',$e_id)
        ->where('course_id',$c_id)->where('semester_id',$s_id)
        ->where('teacher_id',Auth::user()->user_id)->first();

        return view('teacher.result.full.index')
        ->with('results', $all_results)
        ->with('exam_time_id', $e_id)
        ->with('course_id', $c_id)
        ->with('semester_id', $s_id)
        ->with('ce_detail', $c_e_detail)
        ->with('isSubmitted', $this->isSubmitted);
    }

    protected function total($s=0,$t=0)
    {
        return $s+$t;
    }

    protected function creditGrade($m,$credit)
    {
        $mark = 0;
        if ($credit == 3) {
            $mark = $m;
        }elseif ($credit == 2) {
            $mark = $m*2;
        }elseif ($credit == 1) {
            $mark = $m*4;
        }else{
            $mark = $m;
        }

        if ($mark >= 80) {
            return 'A+';
        }elseif ($mark >= 75 && $m < 80) {
            return 'A';
        }elseif ($mark >= 70 && $m < 75) {
            return 'A-';
        }elseif ($mark >= 65 && $m < 70) {
            return 'B+';
        }elseif ($mark >= 60 && $m < 65) {
            return 'B';
        }elseif ($mark >= 55 && $m < 60) {
            return 'B-';
        }elseif ($mark >= 50 && $m < 55) {
            return 'C+';
        }elseif ($mark >= 45 && $m < 50) {
            return 'C';
        }elseif ($mark >= 40 && $m < 45) {
            return 'D';
        }else{
            return 'F';
        }
    }
}
