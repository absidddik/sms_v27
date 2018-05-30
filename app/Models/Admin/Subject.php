<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    const SUBJECT_TYPES = [1=>'THEORY', 2=>'LAB',3=>'VIVA', 4=>'PROJECT WORK'];
    const SUBJECT_CREDITS = [1=>'1', 2=>'2',3=>'3', 4=>'4'];
    const SUBJECT_MARKS = [25=>'25', 50=>'50',100=>'100'];

    protected $fillable = ['user_id','type','name','code','credit','mark'];

    //...............get subject type
    public function getType()
    {
        if (in_array($this->type, array_keys(self::SUBJECT_TYPES))) {
            return self::SUBJECT_TYPES[$this->type];
        }else {
            return 'Not Found!';
        }
    }
}
