<?php

namespace App\Http\Controllers\Charman\PDF;

use PDF;
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

    public function showFullMark($exam_id=0,$semester_id=0)
    {
        $result = $this->getResult($exam_id,$semester_id);
        $exam_time = ExamTime::find($exam_id);
        $semester = Semester::find($semester_id);

        ini_set('memory_limit', '-1');

        $pdf = PDF::loadView('charman.pdf.show_full_mark',['full_results'=> $result['full_results'],'courses'=>$result['courses'],'exam_time'=>$exam_time,'semester'=>$semester]);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($exam_id.' '.$semester_id.' '.time().'.pdf');

        // return view('charman.pdf.show_with_mark')
        // ->with('full_results', $result['full_results'])
        // ->with('exam_time', $exam_time)
        // ->with('semester', $semester)
        // ->with('courses', $result['courses']);
    }

    public function showWithMark($exam_id,$semester_id)
    {
        $result = $this->getResult($exam_id,$semester_id);
        $exam_time = ExamTime::find($exam_id);
        $semester = Semester::find($semester_id);

        ini_set('memory_limit', '-1');

        $pdf = PDF::loadView('charman.pdf.show_with_mark',['full_results'=> $result['full_results'],'courses'=>$result['courses'],'exam_time'=>$exam_time,'semester'=>$semester]);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($exam_id.' '.$semester_id.' '.time().'.pdf');

        // return view('charman.pdf.show_with_mark')
        // ->with('full_results', $result['full_results'])
        // ->with('exam_time', $exam_time)
        // ->with('semester', $semester)
        // ->with('courses', $result['courses']);
    }

    public function showWithoutMark($exam_id,$semester_id)
    {
        $result = $this->getResult($exam_id,$semester_id);
        $batch_enroll = BatchEnroll::where('semester_id',$semester_id)
                                    ->where('exam_time_id',$exam_id)
                                    ->first();
        
        //return $result;


        $pdf = PDF::loadView('charman.pdf.show_without_mark',['full_results'=> $result['full_results'],'courses'=>$result['courses'],'batch_e'=>$batch_enroll]);
        $pdf->setPaper('legal', 'landscape');
        return $pdf->download($exam_id.' '.$semester_id.' '.time().'.pdf');


        // return view('charman.pdf.show_without_mark')
        // ->with('full_results', $result['full_results'])
        // ->with('courses', $result['courses'])
        // ->with('batch_e', $batch_enroll);
    }

    // public function showWithMark($exam_id,$semester_id)
    // {
    //     $result = $this->getResult($exam_id,$semester_id);

    //     return view('charman.exam.show_with_mark')
    //     ->with('full_results', $result['full_results'])
    //     ->with('courses', $result['courses']);
    // }

    // public function showWithoutMark($exam_id,$semester_id)
    // {
    //     $result = $this->getResult($exam_id,$semester_id);
    //     //return $result;
    //     return view('charman.exam.show_without_mark')
    //     ->with('full_results', $result['full_results'])
    //     ->with('courses', $result['courses']);
    // }
}