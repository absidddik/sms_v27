<?php

namespace App\Http\Controllers\Charman;

use Auth;
use Illuminate\Http\Request;
use App\Models\Admin\Course;
use App\Models\Admin\Semester;
use App\Models\Admin\ExamTime;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\CourseEnroll;
use App\Models\Admin\CharmanEnroll;
use App\Http\Controllers\Controller;

class ThirdExaminersController extends Controller
{
    public function index()
    {
    	$chairman = CharmanEnroll::where('charman_id',Auth::user()->user_id)->first();

	    $sql  =	'SELECT DISTINCT courses.name,inter.course_id,inter.semester_id,inter.exam_time_id ';
		$sql .=	'FROM internal_seventy_percent_marks as inter ';
		$sql .=	'INNER JOIN students ON inter.student_id = students.id ';
		$sql .=	'INNER JOIN courses ON inter.course_id = courses.id ';
		$sql .=	'INNER JOIN external_seventy_percent_marks as exter ';
		$sql .=	'ON inter.student_id = exter.student_id ';
		$sql .=	'WHERE inter.course_id = exter.course_id ';
		$sql .=	'AND inter.semester_id = exter.semester_id ';
		$sql .=	'AND inter.exam_time_id = exter.exam_time_id ';
		$sql .=	'AND ABS(inter.total - exter.total) > 14 ';
		$sql .=	'AND inter.semester_id = '.$chairman->semester_id.' ';
		$sql .=	'AND inter.exam_time_id = '.$chairman->exam_time_id.' ';
		$courses = DB::select($sql);
    
        return view('third_examiner.semester_course.index')
        		->with('chairman',$chairman)
        		->with('courses',$courses);
    }

    public function course_details($c_id,$s_id,$et_id)
    {
        $sql  = 'SELECT tesm.total as third_total,students.exam_roll as stu_exam_roll, inter.student_id, inter.total as inter_total, exter.total as ex_total, ABS(inter.total - exter.total) as difference, course_enrolls.id as course_e_id '; 
        $sql .= 'FROM internal_seventy_percent_marks as inter ';
        $sql .= 'INNER JOIN students ';
        $sql .= 'ON inter.student_id = students.id ';
        $sql .= 'LEFT JOIN third_examiner_seventy_marks as tesm ';
        $sql .= 'ON tesm.student_id = inter.student_id '; 
        $sql .= 'INNER JOIN external_seventy_percent_marks as exter '; 
        $sql .= 'ON inter.student_id = exter.student_id ';
        $sql .= 'INNER JOIN course_enrolls '; 
        $sql .= 'ON course_enrolls.course_id = inter.course_id '; 
        $sql .= 'WHERE inter.course_id = exter.course_id ';
        $sql .= 'AND inter.semester_id = exter.semester_id '; 
        $sql .= 'AND inter.exam_time_id = exter.exam_time_id ';
        $sql .= 'AND ABS(inter.total - exter.total) > 14 ';
        $sql .= 'AND inter.course_id = '.$c_id.' ';
        $sql .= 'AND inter.semester_id = '.$s_id.' ';
        $sql .= 'AND inter.exam_time_id = '.$et_id.' ';

        $results = DB::select($sql);

        return view('third_examiner.semester_course.details')
        		->with('results',$results)
                ->with('course',Course::find($c_id))
                ->with('semester',Semester::find($s_id))
        		->with('exam_time',ExamTime::find($et_id));
    }
}
