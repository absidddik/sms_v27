<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ExamTime extends Model
{
    public function getExamTimeAttribute($value = '')
    {
    	return ucwords($value);
    }
}
