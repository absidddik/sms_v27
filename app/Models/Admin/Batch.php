<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $fillable = ['batch_number', 'session'];
}
