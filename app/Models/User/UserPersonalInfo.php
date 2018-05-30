<?php

namespace App\Models\User;
use Image;
use Illuminate\Database\Eloquent\Model;

class UserPersonalInfo extends Model
{
     protected $fillable = ['user_id','supervisor_id','gender','blood_group','image','designation','mobile','joining_date','about'];

     public static function generateImageName($image)
     {
         return str_random(20) . time() . '.' .$image->getClientOriginalExtension();
     }
     public static function resizeImage($image)
     {
         //........resizing imgage
         $img = Image::make($image->getRealPath());
         $img->resize(240, 320, function ($constraint) {});
         $img->stream();
         return $img;
     }

}
