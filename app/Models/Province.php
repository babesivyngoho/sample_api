<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public function region(){
        return $this->belongsTo(Region::class);
    }

    public function municipalities(){
        return $this->hasMany(Municipality::class);
    }
    
    public function organizations(){
        return $this->morphMany('App\Models\Organization', 'geographic');
    }

    public function full_name(){
        return $this->name.", ".$this->region->name;
    }
}
