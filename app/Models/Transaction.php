<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'actor_id',
        'supplier_actor_id',
        'input_product_id',
        'output_product_id',
        //'date',
        'quantity',
        'metric',
        'price',
        'term_duration',
        //'mode_of_acquisition',
        //'status',
    ];

    protected $table = 'transactions';
}
