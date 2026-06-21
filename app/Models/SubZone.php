<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubZone extends Model
{
    use HasFactory;
    
    protected $table = 'subzones';

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d'
    ];

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id' ,'id');
    }
}
