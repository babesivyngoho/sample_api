<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business_Enabler_Product extends Model
{
    //
    protected $fillable = [
        'player_id',
        'enabler_id',
        'kind_of_support',
        'product',
    ];

    protected $table = 'business_enabler_products';
}
