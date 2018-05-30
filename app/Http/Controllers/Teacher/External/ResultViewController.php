<?php

namespace App\Http\Controllers\Teacher\External;

use Auth;
use App\Models\Admin\Course;
use Illuminate\Http\Request;
use App\Models\Admin\Semester;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\ExternalEnroll;
use App\Models\StudentEnroll\StudentEnroll;
use App\Models\Teacher\ExternalSeventyPercentMark as ESPM;

class ResultViewController extends Controller
{
    public function seventyShow($course_e_id,$semester_id)
    {
        $sql = 'SELECT students.exam_roll,students.id FROM students ';
        $sql .= 'INNER JOIN student_enrolls ';
        $sql .= 'ON student_enrolls.student_id = students.id ';
        $sql .= 'WHERE student_enrolls.semester_id = ' . $semester_id;

        $students = DB::select($sql);

        $sql = 'SELECT * FROM external_enrolls ';
        $sql .= 'LEFT JOIN external_seventy_percent_marks ';
        $sql .= 'ON external_enrolls.semester_id = external_seventy_percent_marks.semester_id ';
        $sql .= 'WHERE external_enrolls.teacher_id = external_seventy_percent_marks.teacher_id ';
        $sql .= 'AND external_enrolls.course_id = external_seventy_percent_marks.course_id ';
        $sql .= 'AND external_enrolls.id = ' . $course_e_id;

        $seventy_results = DB::select($sql);

        //........temp array for combine student and 70 result
        $results = [];

        foreach ($students as $s) {
            $r = [
                'student'=>$s,
                'result'=> new ESPM(),
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

        return view('teacher.external.result.show.seventy')
        ->with('course_e',ExternalEnroll::find($course_e_id))
        ->with('results', $results);
    }
}
