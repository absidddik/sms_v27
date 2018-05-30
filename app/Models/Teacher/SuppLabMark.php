<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Model;

class SuppLabMark extends Model
{
    public function student()
    {
    	return $this->belongsTo('App\Models\Admin\Student','student_id','id');
    }
}
