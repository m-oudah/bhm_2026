<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Craft extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'customer_id', 'customer_number');   
    }
}
