<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingOwnerUnit extends Model
{
    use HasFactory;

    protected $table = "building_owner_unit";

    public $timestamps = false;

    public $guarded = [];
}
