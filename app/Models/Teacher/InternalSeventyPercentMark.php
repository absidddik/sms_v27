<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Model;

class InternalSeventyPercentMark extends Model
{
    function student()
    {
    	return $this->belongsTo('App\Models\Admin\Student','student_id','id');
    }

    public function course()
    {
        return $this->belongsTo('App\Models\Admin\Course');
    }
}
