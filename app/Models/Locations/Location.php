<?php

namespace App\Models\Locations;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Tejuino\Adminbase\Files;

class Location extends Model
{

    use SoftDeletes;

    protected $table = 'location';

    public function states(){
        return $this->hasOne('App\Models\States\State', 'id', 'state_id');
    }
    /************************* Methods  ************************/

    public static function getAll()
    {
        $locations = static::where('publish_status', 'Publicado')->where('status', 'active')->
            orderBy('publish_date', 'desc')->paginate(4);

        return $locations;

    }

    public static function getById($id)
    {
        return static::where('id', $id)->where('publish_status', 'Publicado')->where('status', 'active')->first();
    }



}
