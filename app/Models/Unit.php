<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'units';
    public $guarded = [];

    // public function owners()
    // {
    //     return $this->hasOne(UnitOwner::class, 'unit_id', 'id');
    // }
    public function owner()
    {
        return $this->belongsTo(BuildingOwner::class, 'building_owner_id', 'id');
    }

    public function uses()
    {
        return $this->hasOne(UnitUser::class, 'unit_id', 'id');
    }

    public function street()
    {
        return $this->belongsTo(Street::class, 'street_number', 'id');
    }

    public function owners()
    {
        return $this->belongsToMany(BuildingOwner::class, 'building_owner_unit', 'unit_id', 'building_owner_id', 'id', 'id');
    }

    public function getFloorNumAttribute()
    {
        if ($this->floor_number == '0') {
            return __('my land');
        } elseif ($this->floor_number == '1') {
            return __('first');
        } elseif ($this->floor_number == '2') {
            return __('second');
        } elseif ($this->floor_number == '3') {
            return __('third');
        } elseif ($this->floor_number == '4') {
            return __('fourth');
        } elseif ($this->floor_number == '5') {
            return __('fifth');
        } elseif ($this->floor_number == '6') {
            return __('sixth');
        } elseif ($this->floor_number == '7') {
            return __('seventh');
        } elseif ($this->floor_number == '8') {
            return __('eighth');
        } else {
            return __('غير ذلك');
        }
    }

    public function getTypeUnitsAttribute()
    {
        if ($this->unit_type == '1') {
            return "سكن";
        } elseif ($this->unit_type == '2') {
            return "تجاري";
        } else {
            return __('غير ذلك');
        }
    }
}
