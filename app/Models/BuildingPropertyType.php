<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingPropertyType extends Model
{
    use HasFactory;
    
    protected $table = 'building_property_types';

    protected $guarded = [];
}
