<?php

namespace App\Http\Controllers\Teacher;

use Auth;
use App\Models\Admin\Course;
use Illuminate\Http\Request;
use App\Models\Admin\Semester;
use App\Models\Admin\CourseEnroll;
use App\Http\Controllers\Controller;
use App\Models\StudentEnroll\StudentEnroll;

class SemesterCoursesController extends Controller
{
    public function index()
    {

        $semesters = CourseEnroll::where('teacher_id',Auth::user()->user_id)->distinct()->get(['semester_id']);

        $output = '';
        $output .= '<ul class="list-group">';
        foreach ($semesters as $semester) {
            $output .= '<li class="list-group-item active">'.'Semester '.$semester->semester->semester.'
            <ol class="list-group">';
            $courses = CourseEnroll::where('teacher_id',Auth::user()->user_id)->where('semester_id',$semester->semester_id)->get();
            foreach ($courses as $course) {

                if($course->course->type===4){
                    $output .='<li class="list-group-item"><a href="'.
                    route('internal.result.project-work.show',['course_id'=>$course->id,'semester_id'=>$semester->semester_id]).'">'.$course->course->name
                    .'</a></li>';
                }else if($course->course->type===3){
                    $output .='<li class="list-group-item"><a href="'.
                    route('internal.result.viva-voce.show',['course_id'=>$course->id,'semester_id'=>$semester->semester_id]).'">'.$course->course->name
                    .'</a></li>';
                }else if($course->course->type===2){
                    $output .='<li class="list-group-item"><a href="'.
                    route('internal.result.lab-mark.show',['course_id'=>$course->id,'semester_id'=>$semester->semester_id]).'">'.$course->course->name
                    .'</a></li>';
                }else if($course->course->type===1){
                    $output .='<li class="list-group-item"><a href="'.
                    route('internal.result.thirty.show',['course_id'=>$course->id,'semester_id'=>$semester->semester_id]).'">'.$course->course->name
                    .'</a></li>';
                }
            }
            $output .='</ol>
            </li>';
        }
        $output .='<br></ul>';

        return view('teacher.semester_course.index')->with('semester_course',$output);
    }

    public function show($course_e_id,$semester_id)
    {
        $student_enrolls = StudentEnroll::where('semester_id',$semester_id)->get();

        return view('teacher.semester_course.view')
        ->with('course_e',CourseEnroll::find($course_e_id))
        ->with('student_enrolls',$student_enrolls);
    }
}
