<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use SoftDeletes;

    protected $table = 'role';
    protected $fillable = ['title'];
    protected $hidden = [
        'created_at', 'updated_at', 'deleted_at'
    ];

}
