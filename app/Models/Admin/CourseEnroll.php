<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CourseEnroll extends Model
{
    protected $fillable = ['supervisor_id','semester_id','subject_id','teacher_id'];

    public function course()
    {
        return $this->belongsTo('App\Models\Admin\Course');
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
}
