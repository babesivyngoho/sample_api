<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Input extends Model
{
    //
    
    protected $fillable = [
        'name',
        'input_type',
    ];

    protected $table = 'inputs';
}
