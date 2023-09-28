<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'common_name',
        'remarks',
        'provider',
        'quantity',
        'status',
        'year_acquired',
    ];
}

