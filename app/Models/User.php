<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tejuino\Adminbase\Files;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'last_name', 'registration_mode',
        'registration_status', 'terminos_condiciones'
    ];

    protected $hidden = [
        'password', 'remember_token', 'role_id', 'reg_mode', 'status',
        'reg_status', 'reg_code', 'recover_code', 'recover_before',
        'created_at', 'updated_at'
    ];

    /************************ ATTRIBUTES ************************/

    public function getImageAttribute($value)
    {
        return Files::getUrl($value, 'users/');
    }

    // Relationships

    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }

    public static function getByEmail($email)
    {
        return static::where('email', $email)->where('registration_mode', 'gym')->first();
    }


}
