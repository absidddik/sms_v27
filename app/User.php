<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Session;

class User extends Authenticatable
{
    use Notifiable;
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    //.......const value for default field
    const VERIFIED_USER = true;
    const UNVERIFIED_USER = false;
    const ACTIVE_USER = true;
    const INACTIVE_USER = false;
    const ADMIN_USER = true;
    const REGULAR_USER = false;

    const EXTERNAL = 'external';
    const TEACHER = 'teacher';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','name', 'email', 'password','verified','verification_token','role_id','is_active','is_admin','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function generateUserId()
    {
        return (string)rand(1111, 9999) . time();
    }

    public static function generateVerificationToken()
    {
        return str_random(60);
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Admin\UserRole', 'role_id');
    }

    public function isVerified()
    {
        return $this->verified == self::VERIFIED_USER;
    }

    public function isActive()
    {
        return $this->is_active == self::ACTIVE_USER;
    }

    public function isAdmin()
    {
        return $this->is_admin == self::ADMIN_USER;
    }

    public function personalInfo()
    {
        return $this->hasOne('App\Models\User\UserPersonalInfo', 'user_id');
    }

    public function isExternal(){
        return strtolower($this->role->name) == self::EXTERNAL;
    }

    //.........if logged in user both admin and normal user choose layout by trackin his login attribute.[login form admin area or normal]

    public function isAdminLoggedIn()
    {
        if (Session::has('admin_logged_in')) {
            if (Session::get('admin_logged_in') == 1) {
                return true;
            }
        }

        return false;
    }
}
