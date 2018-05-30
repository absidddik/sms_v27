<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class DueStudentEnroll extends Model
{
	protected $fillable = ['supervisor_id','exam_time_id','semester_id','student_id'];
    function student()
    {
    	return $this->belongsTo('App\Models\Admin\Student','student_id','id');
    }
}
