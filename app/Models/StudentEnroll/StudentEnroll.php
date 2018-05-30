<?php

namespace App\Models\StudentEnroll;

use Illuminate\Database\Eloquent\Model;

class StudentEnroll extends Model
{
    protected $fillable = ['supervisor_id','batch_id','semester_id','student_id'];

    function student()
    {
    	return $this->belongsTo('App\Models\Admin\Student','student_id','id');
    }
    // public function thirtyMark()
    // {
    //     return $this->belongsTo('App\Models\Teacher\InternalThirtyPercentMark','student_id','student_id');
    // }
    // public function seventyMark()
    // {
    //     return $this->belongsTo('App\Models\Teacher\InternalSeventyPercentMark','student_id','student_id');
    // }
    // public function externalSeventyMark()
    // {
    //     return $this->belongsTo('App\Models\Teacher\ExternalSeventyPercentMark','student_id','student_id');
    // }
}
