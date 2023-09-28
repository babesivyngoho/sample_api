<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_Type extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    protected $table = 'user_type';
}
