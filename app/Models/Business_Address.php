<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business_Address extends Model
{
    protected $fillable = [
        'no',
        'street',
        'municipality_city_id',
    ];
    protected $table = 'business_address';
}
