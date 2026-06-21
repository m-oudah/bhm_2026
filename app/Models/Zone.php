<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d'
    ];

    public function subzones()
    {
        return $this->hasMany(SubZone::class, 'zone_id' ,'id');
    }
}
