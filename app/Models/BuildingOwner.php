<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingOwner extends Model
{
    use HasFactory;

    protected $table = 'building_owners';

    protected $guarded = [];

    public $timestamps = false;

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->second_name) . ' ' . ucfirst($this->third_name) . ' ' . ucfirst($this->sur_name);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'id_number', 'id_card');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'building_owner_unit', 'building_owner_id', 'unit_id', 'id', 'id');
    }

    public function building()
    {
        return $this->belongsTo(Building::class,'building_id','id');
    }

//    public function units()
//    {
//        return $this->hasMany(Unit::class, 'building_owner_id', 'id');
//    }

}
