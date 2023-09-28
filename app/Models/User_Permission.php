<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Permission extends Model
{
    //
    protected $fillable = [
        'user_type_id',
        'permission_id'
    ];

    protected $table = 'user_permission';
}
