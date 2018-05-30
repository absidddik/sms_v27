<?php

namespace App\Models\Teacher;

use Illuminate\Database\Eloquent\Model;

class ExternalSeventyPercentMark extends Model
{
    function student()
   {
       return $this->belongsTo('App\Models\Admin\Student','student_id','id');
   }
}
