<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $fillable = ['name'];

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function users()
    {
        return $this->hasMany('App\User','role_id');
    }
}
