<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d'
    ];

    public function crafts()
    {
        return $this->hasMany(Craft::class, 'customer_id', 'customer_number');
    }

    public function units()
    {
        return $this->belongsToMany(Unit::class, 'subscription_unit');
    }

    public function owner()
    {
        return $this->belongsTo(BuildingOwner::class, 'owner_id', 'id');
    }
}
