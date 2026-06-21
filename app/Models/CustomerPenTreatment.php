<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerPenTreatment extends Model
{
    use HasFactory;

    protected $table = "customer_pen_treatment";

    public $guarded = [];

    public function customer()
    {
        return $this->belongsTo(CustomerPen::class, 'customer_id', 'id');
    }

     public function treatment()
     {
         return $this->belongsTo(Treatment::class, 'treatment_id', 'id');
     }

     public function user()
     {
         return $this->belongsTo(User::class, 'user_id', 'id');
     }



}
