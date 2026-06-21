<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPen extends Model
{
    use HasFactory;

    protected $table = "customer_pens";

    public $guarded = [];

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->second_name) . ' ' . ucfirst($this->third_name) . ' ' . ucfirst($this->sur_name);
    }
}
