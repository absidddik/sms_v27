<?php
namespace App\Traits;

use Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\CourseEnroll;
use App\Models\Admin\CharmanEnroll;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;
use App\Models\Admin\DueStudentEnroll;
use App\Models\Teacher\ExternalSeventyPercentMark as ESPM;
use App\Models\Teacher\ThirdExaminerSeventyMark as TESPM;

trait ResultOutput{
    //.........default variable
    protected $absent = "AB";

    protected function getResult($exam_id=0,$semester_id=0)
    {

        $full_results = [];
        $courses = [];
        $results = [];

        $charman_e = CharmanEnroll::where('charman_id',Auth::user()->user_id)
        ->where('exam_time_id',$exam_id)
        ->where('semester_id',$semester_id)
        ->first();

        $course_e = CourseEnroll::where('semester_id', $charman_e->semester_id)
        ->where('exam_time_id',$exam_id)->get();

        $course_count = count($course_e);

        foreach ($course_e as $c) {


            $due = false;
            $absent_count = 0;
            $failed_count = 0;
            $course_cedit = $c->course->credit;

            //...........only for lab exam which have no 30 marks
            if ($course_cedit == 1 ) {
                $sql = 'SELECT internal_seventy_percent_marks.total as seventy, internal_seventy_percent_marks.is_absent, ';
                $sql .= 'students.exam_roll,students.name, students.id as student_id ';
                $sql .= 'FROM internal_seventy_percent_marks ';
                $sql .= 'INNER JOIN students ';
                $sql .= 'ON internal_seventy_percent_marks.student_id = students.id ';
                $sql .= 'AND internal_seventy_percent_marks.student_id = students.id ';
                $sql .= 'AND internal_seventy_percent_marks.exam_time_id = '.$exam_id.' ';
                $sql .= 'AND internal_seventy_percent_marks.semester_id = '.$charman_e->semester_id.' ';
                $sql .= 'AND internal_seventy_percent_marks.course_id = '.$c->course->id.' ';
                $sql .= 'ORDER BY students.exam_roll';

            }else{

                $sql = 'SELECT internal_seventy_percent_marks.total as seventy, internal_seventy_percent_marks.is_absent, ';
                $sql .= 'internal_thirty_percent_marks.total as thirty,students.exam_roll,students.name, students.id as student_id ';
                $sql .= 'FROM internal_seventy_percent_marks ';
                $sql .= 'LEFT JOIN internal_thirty_percent_marks ';
                $sql .= 'ON internal_seventy_percent_marks.course_id = internal_thirty_percent_marks.course_id ';
                $sql .= 'INNER JOIN students ';
                $sql .= 'ON internal_seventy_percent_marks.student_id = students.id ';
                $sql .= 'WHERE internal_seventy_percent_marks.semester_id = internal_thirty_percent_marks.semester_id ';
                $sql .= 'AND internal_seventy_percent_marks.student_id = students.id ';
                $sql .= 'AND internal_thirty_percent_marks.student_id = students.id ';
                $sql .= 'AND internal_seventy_percent_marks.exam_time_id = '.$exam_id.' ';
                $sql .= 'AND internal_thirty_percent_marks.exam_time_id = '.$exam_id.' ';
                $sql .= 'AND internal_seventy_percent_marks.semester_id = '.$charman_e->semester_id.' ';
                $sql .= 'AND internal_seventy_percent_marks.course_id = '.$c->course->id.' ';
                $sql .= 'AND internal_thirty_percent_marks.course_id = '.$c->course->id.' ';
                $sql .= 'ORDER BY students.exam_roll';

            }

            $single_result = DB::select($sql);


            //.............if course has a external
            $is_external = ESPM::where('exam_time_id', $exam_id)
            ->where('semester_id', $charman_e->semester_id)
            ->where('course_id',$c->course->id)
            ->first();

            if ($is_external) {
                $c->course->has_external = 1;
            }else{
                $c->course->has_external = 0;
            }
            //..........store all course at one array for output
            $courses[] = $c->course;

            //..........combine internal and external 70 persent marks
            $single_result_with_external = [];
            //.........if corse has a external add the 70 of external
            foreach ($single_result as $r) {
                $r->course_id = $c->course->id;
                $r->course = $c->course->name;
                $r->course_type = $c->course->getType();
                $r->course_code = $c->course->code;
                $r->course_credit = $c->course->credit;
                $r->external_seventy = '';
                $r->third_ex_seventy = '';
                $r->due = false;
                $single_result_with_external[] = $r;
            }


            $results[] = $single_result_with_external;
            $full_results[] = $results;

        }

        $student_exam_roll = [];
        //....take first array to extract student roll
        foreach ($results[0] as $roll) {
            $student_exam_roll[] = $roll->exam_roll;
        }

        //..........combine student and all subject roll at one place
        $convert_result = [];

        foreach ($student_exam_roll as $roll) {
            $student_status = [
                'failed' =>[],
                'absent' => [],
            ];

            foreach ($results as $courses_result) {
                foreach ($courses_result as $single_student) {
                    if ($single_student->exam_roll == $roll) {

                        //.........if student is due
                        $due = DueStudentEnroll::where('exam_time_id', $exam_id)
                        ->where('semester_id', $charman_e->semester_id)
                        ->where('student_id',$single_student->student_id)
                        ->first();

                        if ($due) {
                            $single_student->due = true;
                            $due = true;
                        }

                        //.........find externl 70 marks
                        $external_mark = ESPM::where('exam_time_id', $exam_id)
                        ->where('semester_id', $charman_e->semester_id)
                        ->where('course_id',$single_student->course_id)
                        ->where('student_id',$single_student->student_id)
                        ->first();

                        //..........find 3rd examinner 70 mark
                        $third_ex_mark = TESPM::where('exam_time_id', $exam_id)
                        ->where('semester_id', $charman_e->semester_id)
                        ->where('course_id',$single_student->course_id)
                        ->where('student_id',$single_student->student_id)
                        ->first();

                        //..........if has a external mark and 3rd examinner assign value for output
                        if ($external_mark) {
                            $single_student->external_seventy = $external_mark->total;
                        }
                        if ($third_ex_mark) {
                            $single_student->third_ex_seventy = $third_ex_mark->total;
                        }

                        //..........if student have 3rd examinner
                        if ($external_mark && $third_ex_mark) {
                            $seventy_total = $this->seventyTotalWithThird($single_student->seventy, $external_mark->total, $third_ex_mark->total);
                        }
                        ///..........if only has a external
                        else if ($external_mark) {
                            //..........calculate internal and external 70 marks
                            $seventy_total = $this->seventyTotal($single_student->seventy, $external_mark->total);
                        }else{
                            $seventy_total = $single_student->seventy;
                        }
                        //.........caltulate total 70+30
                        //..........only for lab exam
                        if ($single_student->course_credit == 1) {
                            $single_student->thirty = 0;
                        }else{
                            $total = $this->total($seventy_total,$single_student->thirty);
                        }

                        //.........CALCULATE GRADE
                        //........if student absent
                        if ($single_student->is_absent) {
                            $single_student->grade = $this->absent;
                        }else{
                            //..........calculate grade
                            $single_student->grade = $this->creditGrade($total, $single_student->course_credit);
                        }

                        //..........STATUS FOR STUDENT
                        //...........student absent
                        if ($single_student->is_absent) {
                            $absent_count += 1;
                            $student_status['absent'][] = $single_student->course_code;
                        }
                        //........status of student fail or pass
                        else if (!$this->studentStatus($total,$single_student->course_credit)) {
                            $failed_count += 1;
                            $student_status['failed'][] = $single_student->course_code;
                        }

                        $single_student->seventy_total = $seventy_total;
                        $single_student->total = $total;

                        $convert_result[$single_student->exam_roll]['result'][] = $single_student;
                        break;
                    }
                }


            }


            //.........if absent in all subjent
            if ($absent_count == $course_count) {
                $student_status['all_absent'] = "Absent in All Course Detained";
            }else{
                $student_status['all_absent'] = '';
            }
            //........if fail in all subjent
            if ($failed_count == $course_count) {
                $student_status['all_failed'] = "Failed in All Course Detained";
            }else{
                $student_status['all_failed'] = '';
            }



            //........if student due
            if ($due) {
                $convert_result[$roll]['due'] = 'Withheld for Dues';
            }else {
                $convert_result[$roll]['due'] = '';
            }


            //........add student pass or fail status
            $convert_result[$roll]['status'] = $student_status;

        }

        //........return for output
        return [
            'courses' => $courses,
            'full_results' => $convert_result,
        ];


    }

    protected function seventyTotal($i=0,$e=0)
    {
        $sum = ($i+$e)/2;
        return ceil($sum);
    }

    protected function seventyTotalWithThird($i_70,$e_70,$t_70){
        $arr = [$i_70,$e_70,$t_70];
        rsort($arr);
        $max_1 = $arr[0];
        $max_2 = $arr[1];
        return $this->seventyTotal($max_1,$max_2);
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


    protected function studentStatus($m=0, $credit)
    {
        $status = '';
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

        if ($mark < 40) {
            return false;
        }else{
            return true;
        }

        return $status;
    }
}


 ?>
