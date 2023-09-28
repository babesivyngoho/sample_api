<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player_Product extends Model
{
    //
    protected $fillable = [
        //'business_name', 
        //'sector', 
        //'location', 
        //'vc_player_type',
        'player_id',
        'product_id',
        'product_quantity',
        'product_metric',
        'product_date',
        'step_by_step_des',
        'major_tech_des',
        'service_provider_des',
        'raw_materials_des',
    ];

    protected $table = 'player_products';
}
