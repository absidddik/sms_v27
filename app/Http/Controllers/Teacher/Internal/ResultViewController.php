<?php

namespace App\Http\Controllers\Teacher\Internal;

use Auth;
use App\Models\Admin\Course;
use Illuminate\Http\Request;
use App\Models\Admin\Semester;
use App\Models\Teacher\LabMark;
use App\Models\Teacher\VivaVoce;
use App\Models\Teacher\SuppMark;
use App\Models\Admin\CourseEnroll;
use Illuminate\Support\Facades\DB;
use App\Models\Teacher\SuppLabMark;
use App\Models\Teacher\SuppVivaVoce;
use App\Http\Controllers\Controller;
use App\Models\SuppEnroll\SuppEnroll;
use App\Models\StudentEnroll\StudentEnroll;
use App\Models\Teacher\InternalThirtyPercentMark as ITPM;
use App\Models\Teacher\InternalSeventyPercentMark as ISPM;

class ResultViewController extends Controller
{
    public function thirtyShow($course_e_id,$semester_id)
    {
        $sql = 'SELECT students.exam_roll,students.id FROM students ';
        $sql .= 'INNER JOIN student_enrolls ';
        $sql .= 'ON student_enrolls.student_id = students.id ';
        $sql .= 'WHERE student_enrolls.semester_id = ' . $semester_id;

        $students = DB::select($sql);

        $sql = 'SELECT * FROM course_enrolls ';
        $sql .= 'LEFT JOIN internal_thirty_percent_marks ';
        $sql .= 'ON course_enrolls.semester_id = internal_thirty_percent_marks.semester_id ';
        $sql .= 'WHERE course_enrolls.teacher_id = internal_thirty_percent_marks.teacher_id ';
        $sql .= 'AND course_enrolls.course_id = internal_thirty_percent_marks.course_id ';
        $sql .= 'AND course_enrolls.id = ' . $course_e_id;

        $thirty_results = DB::select($sql);

        //........temp array for combine student and 30 result
        $results = [];

        foreach ($students as $s) {
            $r = [
                'student'=>$s,
                'result'=> new ITPM(),
            ];

            //...........if student has 30 marks
            foreach ($thirty_results as $tr) {
                if ($s->id == $tr->student_id) {
                    $r['result'] = $tr;
                    break;
                }
            }

            $results[] = $r;
        }

        return view('teacher.result.show.thirty')
        ->with('course_e',CourseEnroll::find($course_e_id))
        ->with('results',$results);
    }

    public function seventyShow($course_e_id,$semester_id)
    {
        $sql = 'SELECT students.exam_roll,students.id FROM students ';
        $sql .= 'INNER JOIN student_enrolls ';
        $sql .= 'ON student_enrolls.student_id = students.id ';
        $sql .= 'WHERE student_enrolls.semester_id = ' . $semester_id;

        $students = DB::select($sql);

        $sql = 'SELECT * FROM course_enrolls ';
        $sql .= 'LEFT JOIN internal_seventy_percent_marks ';
        $sql .= 'ON course_enrolls.semester_id = internal_seventy_percent_marks.semester_id ';
        $sql .= 'WHERE course_enrolls.teacher_id = internal_seventy_percent_marks.teacher_id ';
        $sql .= 'AND course_enrolls.course_id = internal_seventy_percent_marks.course_id ';
        $sql .= 'AND course_enrolls.id = ' . $course_e_id;

        $seventy_results = DB::select($sql);

        //........temp array for combine student and 70 result
        $results = [];

        foreach ($students as $s) {
            $r = [
                'student'=>$s,
                'result'=> new ISPM(),
            ];

            //...........if student has 70 marks
            foreach ($seventy_results as $sr) {
                if ($s->id == $sr->student_id) {
                    $r['result'] = $sr;
                    break;
                }
            }

            $results[] = $r;
        }

        return view('teacher.result.show.seventy')
        ->with('course_e',CourseEnroll::find($course_e_id))
        ->with('results',$results);
    }

    public function suppSeventyShow($course_e_id,$semester_id)
    {
        $course_enroll = CourseEnroll::find($course_e_id);
        $supp_e = SuppEnroll::where('course_e_id',$course_e_id)->first();

        $students = SuppEnroll::where('semester_id',$course_enroll->semester_id)
                                ->where('course_id',$course_enroll->course_id)
                                ->where('teacher_id',$course_enroll->teacher_id)
                                ->where('course_e_id',$course_enroll->id)->get();

        $marks = SuppMark::where('semester_id',$course_enroll->semester_id)
                                ->where('exam_time_id',$supp_e->exam_time_id)
                                ->where('course_id',$course_enroll->course_id)
                                ->where('teacher_id',$course_enroll->teacher_id)->get();


        $results = [];

        foreach ($students as $s) {
            $r = [
                'student'=>$s,
                'result'=> new SuppMark(),
            ];

            //...........if student has 70 marks
            foreach ($marks as $sr) {
                if ($s->student_id == $sr->student_id) {
                    $r['result'] = $sr;
                    break;
                }
            }

            $results[] = $r;
        }

        return view('teacher.result.show.supp.supp')
        ->with('exam_time',$supp_e)
        ->with('course_e',CourseEnroll::find($course_e_id))
        ->with('results',$results);
    }

    public function suppVivaShow($course_e_id,$semester_id)
    {
        $course_enroll = CourseEnroll::find($course_e_id);
        $supp_e = SuppEnroll::where('course_e_id',$course_e_id)->first();

        $students = SuppEnroll::where('semester_id',$course_enroll->semester_id)
                                ->where('course_id',$course_enroll->course_id)
                                ->where('teacher_id',$course_enroll->teacher_id)
                                ->where('course_e_id',$course_enroll->id)->get();

        $marks = SuppVivaVoce::where('semester_id',$course_enroll->semester_id)
                                    ->where('exam_time_id',$supp_e->exam_time_id)
                                    ->where('course_id',$course_enroll->course_id)
                                    ->where('teacher_id',$course_enroll->teacher_id)->get();


        $results = [];

        foreach ($students as $s) {
            $r = [
                'student'=>$s,
                'result'=> new SuppVivaVoce(),
            ];

            //...........if student has 70 marks
            foreach ($marks as $sr) {
                if ($s->student_id == $sr->student_id) {
                    $r['result'] = $sr;
                    break;
                }
            }

            $results[] = $r;
        }

        return view('teacher.result.show.supp.viva_voce')
        ->with('exam_time',$supp_e)
        ->with('course_e',CourseEnroll::find($course_e_id))
        ->with('results',$results);
    }

    public function suppLabShow($course_e_id,$semester_id)
    {
        $course_enroll = CourseEnroll::find($course_e_id);
        $supp_e = SuppEnroll::where('course_e_id',$course_e_id)->first();

        $students = SuppEnroll::where('semester_id',$course_enroll->semester_id)
                                ->where('course_id',$course_enroll->course_id)
                                ->where('teacher_id',$course_enroll->teacher_id)
                                ->where('course_e_id',$course_enroll->id)->get();

        $marks = SuppLabMark::where('semester_id',$course_enroll->semester_id)
                                ->where('course_id',$course_enroll->course_id)
                                ->where('exam_time_id',$supp_e->exam_time_id)
                                ->where('teacher_id',$course_enroll->teacher_id)->get();


        $results = [];

        foreach ($students as $s) {
            $r = [
                'student'=>$s,
                'result'=> new SuppLabMark(),
            ];

            //...........if student has 70 marks
            foreach ($marks as $sr) {
                if ($s->student_id == $sr->student_id) {
                    $r['result'] = $sr;
                    break;
                }
            }

            $results[] = $r;
        }

        return view('teacher.result.show.supp.lab_mark')
        ->with('exam_time',$supp_e)
        ->with('course_e',CourseEnroll::find($course_e_id))
        ->with('results',$results);
    }


    public function vivaShow($course_e_id,$semester_id)
    {
        $sql = 'SELECT students.exam_roll,students.id FROM students ';
        $sql .= 'INNER JOIN student_enrolls ';
        $sql .= 'ON student_enrolls.student_id = students.id ';
        $sql .= 'WHERE student_enrolls.semester_id = ' . $semester_id;

        $students = DB::select($sql);

        $sql = 'SELECT * FROM course_enrolls ';
        $sql .= 'LEFT JOIN internal_seventy_percent_marks as inter ';
        $sql .= 'ON course_enrolls.semester_id = inter.semester_id ';
        $sql .= 'WHERE course_enrolls.teacher_id = inter.teacher_id ';
        $sql .= 'AND course_enrolls.course_id = inter.course_id ';
        $sql .= 'AND course_enrolls.id = ' . $course_e_id;

        $viva_voce_result = DB::select($sql);

        //........temp array for combine student and 30 result
        $results = [];

        foreach ($students as $s) {
            $r = [
                'student'=>$s,
                'result'=> new VivaVoce(),
            ];

            //...........if student has 30 marks
            foreach ($viva_voce_result as $vvr) {
                if ($s->id == $vvr->student_id) {
                    $r['result'] = $vvr;
                    break;
                }
            }

            $results[] = $r;
        }

        return view('teacher.result.show.viva_voce')
        ->with('course_e',CourseEnroll::find($course_e_id))
        ->with('results',$results);
    }

    public function labMarkShow($course_e_id,$semester_id)
    {
        $course_e = CourseEnroll::find($course_e_id);

        $sql  = 'SELECT student_enrolls.student_id, students.exam_roll, inter_thirty.tutorial_1,
                inter_thirty.mid_term ,inter_thirty.attendance,inter_thirty.total AS inter_thirty_total,inter_thirty.id AS inter_thirty_id,
                inter_seventy.total AS inter_seventy_total,inter_seventy.id AS inter_seventy_id,inter_seventy.is_absent ';

        $sql .= 'FROM `student_enrolls` '; 
        $sql .= 'LEFT JOIN students '; 
        $sql .= 'ON students.id = student_enrolls.student_id '; 

        $sql .= 'LEFT JOIN course_enrolls '; 
        $sql .= 'ON course_enrolls.semester_id = student_enrolls.semester_id '; 

        $sql .= 'LEFT JOIN internal_thirty_percent_marks AS inter_thirty '; 
        $sql .= 'ON course_enrolls.course_id = inter_thirty.course_id ';
        $sql .= 'AND student_enrolls.student_id = inter_thirty.student_id ';

        $sql .= 'LEFT JOIN internal_seventy_percent_marks AS inter_seventy '; 
        $sql .= 'ON course_enrolls.course_id = inter_seventy.course_id ';
        $sql .= 'AND student_enrolls.student_id = inter_seventy.student_id ';

        $sql .= 'WHERE student_enrolls.semester_id = '.$semester_id.' '; 
        $sql .= 'AND course_enrolls.course_id = '.$course_e->course_id.' '; 
        $sql .= 'AND course_enrolls.exam_time_id = '.$course_e->exam_time_id.' '; 
        $sql .= 'AND course_enrolls.teacher_id = '.$course_e->teacher_id.' ';

        $lab_result = DB::select($sql);

        return view('teacher.result.show.lab_mark')
        ->with('course_e',$course_e)
        ->with('results',$lab_result);
    }
}
