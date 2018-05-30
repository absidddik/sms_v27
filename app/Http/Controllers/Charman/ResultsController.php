<?php

namespace App\Http\Controllers\Charman;

use Auth;
use App\Traits\ResultOutput;
use Illuminate\Http\Request;
use App\Models\Admin\ExamTime;
use App\Models\Admin\Semester;
use App\Models\Admin\BatchEnroll;
use App\Models\Admin\CourseEnroll;
use App\Models\Admin\CharmanEnroll;
use App\Http\Controllers\Controller;
use App\Models\Result\SubmittedResult;

class ResultsController extends Controller
{
    use ResultOutput;


    public function index()
    {
        $charman_e = CharmanEnroll::where('charman_id',Auth::user()->user_id)->get();

        return view('charman.exam.list')
        ->with('charman_e', $charman_e);
    }

    public function show($exam_id=0,$semester_id=0)
    {
        $unsubbmited_result = [];

        $charman_e = CharmanEnroll::where('charman_id',Auth::user()->user_id)
        ->where('exam_time_id',$exam_id)
        ->where('semester_id',$semester_id)
        ->first();

        $course_e = CourseEnroll::where('semester_id', $charman_e->semester_id)
        ->where('exam_time_id',$exam_id)->get();

        foreach ($course_e as $c) {
            $sr = SubmittedResult::where('exam_time_id',$exam_id)
            ->where('course_id',$c->course_id)
            ->where('semester_id',$semester_id)
            ->first();
            if ($sr) {
                continue;
            }else{
                $unsubbmited_result[] = $c->course;
            }
        }

        return view('charman.exam.show')
        ->with('unsubbmited_result', $unsubbmited_result)
        ->with('exam', $charman_e);

    }

    public function showFullMark($exam_id=0,$semester_id=0)
    {
        $result = $this->getResult($exam_id,$semester_id);
        $exam_time = ExamTime::find($exam_id);
        $semester = Semester::find($semester_id);

        return view('charman.exam.show_full_marks')
        ->with('full_results', $result['full_results'])
        ->with('exam_id', $exam_id)
        ->with('semester_id', $semester_id)
        ->with('exam_time', $exam_time)
        ->with('semester', $semester)
        ->with('courses', $result['courses']);
    }

    public function showWithMark($exam_id,$semester_id)
    {
        $result = $this->getResult($exam_id,$semester_id);
        $exam_time = ExamTime::find($exam_id);
        $semester = Semester::find($semester_id);

        return view('charman.exam.show_with_mark')
        ->with('full_results', $result['full_results'])
        ->with('exam_id', $exam_id)
        ->with('semester_id', $semester_id)
        ->with('exam_time', $exam_time)
        ->with('semester', $semester)
        ->with('courses', $result['courses']);
    }

    public function showWithoutMark($exam_id,$semester_id)
    {
        $result = $this->getResult($exam_id,$semester_id);
        $batch_enroll = BatchEnroll::where('semester_id',$semester_id)
                                    ->where('exam_time_id',$exam_id)
                                    ->first();
        //return $result;
        return view('charman.exam.show_without_marks')
        ->with('full_results', $result['full_results'])
        ->with('exam_id', $exam_id)
        ->with('semester_id', $semester_id)
        ->with('batch_e', $batch_enroll)
        ->with('courses', $result['courses']);
    }


}
