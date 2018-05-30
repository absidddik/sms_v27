<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    const COURSE_TYPES = [1=>'THEORY', 2=>'LAB',3=>'VIVA', 4=>'PROJECT WORK'];
    const COURSE_CREDITS = [1=>'1', 2=>'2',3=>'3', 4=>'4'];
    const COURSE_MARKS = [25=>'25', 50=>'50',100=>'100'];

    protected $fillable = ['user_id','type','name','code','credit','mark','content'];

    //...............get course type
    public function getType()
    {
        if (in_array($this->type, array_keys(self::COURSE_TYPES))) {
            return self::COURSE_TYPES[$this->type];
        }else {
            return 'Not Found!';
        }
    }
}
