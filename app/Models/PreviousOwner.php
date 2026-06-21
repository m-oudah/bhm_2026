<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousOwner extends Model
{
    use HasFactory;
    
    protected $table = 'previous_owners';

    protected $guarded = [];

    
    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->second_name) . ' ' . ucfirst($this->third_name) . ' ' . ucfirst($this->sur_name);
    }
}
