<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CharmanEnroll extends Model
{
    public function charman()
    {
        return $this->belongsTo('App\User','charman_id','user_id');
    }

    public function exam()
    {
        return $this->belongsTo('App\Models\Admin\ExamTime','exam_time_id','id');
    }

    public function semester()
    {
        return $this->belongsTo('App\Models\Admin\Semester','semester_id','id');
    }

    public function exam_time()
    {
        return $this->belongsTo('App\Models\Admin\ExamTime');
    }
}
