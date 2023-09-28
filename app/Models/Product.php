<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description',
    ];

    protected $table = 'products';

    public static function all_products(){
        $products = DB::table('products')->selectRaw('name, count(*) as hits')->groupBy('name')->orderBy('name')->limit(10)->get();
        return $products;
    }
}
