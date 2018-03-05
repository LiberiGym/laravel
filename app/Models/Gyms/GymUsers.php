<?php

namespace App\Models\Gyms;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Tejuino\Adminbase\Files;

class GymUsers extends Model
{

    use SoftDeletes;

    protected $table = 'gym_users';

    /************************ ATTRIBUTES ************************/

    public function getImageAttribute($value)
    {
        return $value; //Files::getUrl($value, 'gyms/');
    }

    /************************* Methods  ************************/

    public static function getAll()
    {
        $gyms = static::where('publish_status', 'Publicado')->where('status', 'active')->
            orderBy('publish_date', 'desc')->paginate(4);

        return $gyms;

    }

    public static function getById($id)
    {
        return static::where('id', $id)->where('publish_status', 'Publicado')->where('status', 'active')->first();
    }

    public function usuario(){
        $this->hasOne('\App\Models\User', 'id', 'user_id');
    }
}
