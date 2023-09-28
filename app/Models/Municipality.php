<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Municipality extends Model
{
    use HasFactory;

    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function barangays(){
        return $this->hasMany(Barangay::class);
    }

    public function players(){
        return $this->hasMany(Player::class);
    }
    public function organizations(){
        return $this->morphMany(Organization::class, 'geographic');
    }

    public static function with_players($player_ids){
        return DB::table('players')
            ->leftJoin('municipalities', 'players.municipality_id','=', 'municipalities.id')
            ->leftJoin('provinces', 'provinces.id','=','municipalities.province_id')
            ->whereIn('players.id', $player_ids)
            ->select(DB::raw("concat(municipalities.name,', ',provinces.name) as location, count(*) as hits"))
            ->groupByRaw('municipalities.name, provinces.name')
            ->limit(10)
            ->get();
    }

    public function full_name(){
       return $this->name.", ".$this->province->full_name();
    }
}
