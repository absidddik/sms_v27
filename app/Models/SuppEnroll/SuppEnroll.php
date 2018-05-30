<?php

namespace App\Models\SuppEnroll;

use Illuminate\Database\Eloquent\Model;

class SuppEnroll extends Model
{
	const EXAM_TYPES = [1=>'Improvement', 2=>'Supplementary'];

    public function student()
    {
    	return $this->belongsTo('App\Models\Admin\Student','student_id','id');
    }

    public function course_enroll()
    {
        return $this->belongsTo('App\Models\Admin\CourseEnroll');
    }
    public function teacher()
    {
        return $this->belongsTo('App\User','teacher_id','user_id');
    }

    public function semester()
    {
    	return $this->belongsTo('App\Models\Admin\Semester');
    }

    public function exam_time()
    {
        return $this->belongsTo('App\Models\Admin\ExamTime');
    }

    public function suppMark()
    {
        return $this->belongsTo('App\Models\Teacher\SuppMark','student_id','student_id');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Admin\Course');
    }
}
