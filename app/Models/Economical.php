<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Economical extends Model
{
    use HasFactory;

    protected $table = 'economical';

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d'
    ];

    public function sector()
    {
        return $this->belongsTo(EconomicalSector::class, 'job_sector_id', 'id');
    }
    public function owners()
    {
        return $this->hasOne(EconomicalOwner::class, 'economical_id', 'id');
    }
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }


}
