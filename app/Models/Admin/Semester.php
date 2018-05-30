<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $fillable = ['semester'];

    public function getSemesterAttribute($value)
    {
        return strtoupper($value);
    }
}
