<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class BatchEnroll extends Model
{
    public function semester()
    {
    	return $this->belongsTo('App\Models\Admin\Semester');
    }

    public function batch()
    {
    	return $this->belongsTo('App\Models\Admin\Batch');
    }

    public function exam_time()
    {
        return $this->belongsTo('App\Models\Admin\ExamTime');
    }
}
