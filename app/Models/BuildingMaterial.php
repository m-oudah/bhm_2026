<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingMaterial extends Model
{
    use HasFactory;

    // protected $table = 'building_property_types';

    protected $guarded = [];

    public function buildings()
    {
        return $this->belongsToMany(Building::class, 'building_building_material', 'building_material_id', 'building_id', 'id', 'id');
    }
}
