<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enabler extends Model
{
    //
    protected $fillable = [
        'name',
        'type_of_organization',
        'address',
    ];

    protected $table = 'enablers';
}
