<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public function provinces(){
        return $this->hasMany(Province::class);
    }

    public function organizations(){
        return $this->morphMany('App\Models\Organization', 'geographic');
    }

    public function full_name(){
        return $this->name;
    }
}
