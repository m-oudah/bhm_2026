<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingUse extends Model
{
    use HasFactory;

    protected $table = 'building_uses';

    protected $guarded = [];


    public function buildings()
    {
        return $this->belongsToMany(Building::class, 'building_building_use', 'building_use_id', 'building_id', 'id', 'id');
    }
}
