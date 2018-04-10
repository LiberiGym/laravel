<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Tejuino\Adminbase\Files;

class UserCard extends Model
{

    use SoftDeletes;

    protected $table = 'users_cards';

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
}
