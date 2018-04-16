<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Mpociot\Firebase\SyncsWithFirebase;

class User extends Authenticatable
{
    use SyncsWithFirebase;
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'birth_date', 'location_id',
        'last_name', 'middle_name', 'registration_mode', 'phone',
        'registration_status', 'terminos_condiciones', 'state_id',
        'codigo_postal', 'genero', 'image', 'role_id'
    ];
    protected $hidden = [
        'password', 'remember_token', 'role_id', 'reg_mode', 'status',
        'reg_status', 'reg_code', 'recover_code', 'recover_before',
        'created_at', 'updated_at'
    ];

    /************************ ATTRIBUTES ************************/

    public function getImageAttribute($value)
    {
        //return Files::getUrl($value, 'users/');
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

    public static function getUserByEmail($email)
    {
        return static::where('email', $email)->where('registration_mode', 'client')->first();
    }


}
