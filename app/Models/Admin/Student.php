<?php

namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

    const ACTIVE_STUDENT = 1;
    const DEACTIVE_STUDENT = 0;
    const PRESENT_STUDENT = true;
    const EX_STUDENT = false;
    const DEFAULT_PASSWORD = 'gb123456';

    protected $guard = 'students';

    protected $fillable = ['supervisor_id','name', 'email', 'password', 'batch_id', 'class_roll', 'exam_roll', 'reg_no', 'gender', 'phone', 'blood_group', 'image', 'guardian', 'guardian_contact', 'is_active', 'is_present'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function batch()
    {
        return $this->belongsTo('App\Models\Admin\Batch');
    }

    

    public function isActive()
    {
        return $this->is_active == self::ACTIVE_STUDENT;
    }

}
