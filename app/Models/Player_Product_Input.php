<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player_Product_Input extends Model
{
    //
    protected $fillable = [
        //'business_name', 
        //'sector', 
        //'location', 
        //'vc_player_type',
        'player_product_id',
        'input_id',
        'quantity',
        'metric',
        'transaction_type',
    ];

    protected $table = 'player_product_inputs';
}
