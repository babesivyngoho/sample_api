<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'actor_id',
        //'representative_id',
        //'business_name',
        'business_type_id',
        'business_address_id',
        //'business_address_no',
        //'business_address_street',
        //'business_address_city_municipality',
        //'business_address_province',
        //'business_address_region',
        'business_contact_no',
        'business_email_add',
        'owner_name',
        'owner_sex_at_birth',
        'sector',
        'role_id',
        'is_active',
    ];

    protected $table = 'players';

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function equipments(){
        return $this->hasMany(Equipment::class);
    }

    public function barangay(){
        return $this->belongsTo(Barangay::class);
    }

    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }

    public function address(){
        if($this->barangay_id){
            return $this->barangay->name.", ".$this->barangay->municipality->name.", ".$this->barangay->municipality->province->name;
        }elseif($this->municipality){
            return $this->municipality->name.", ".$this->municipality->province->name;
        }
    }
}
