<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    public $guarded = [];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function customerPens()
    {
        return $this->belongsToMany(CustomerPen::class, 'customer_pen_treatment', 'treatment_id', 'customer_id', 'id', 'id');
    }

    public function main_attachment()
    {
        return $this->belongsToMany(TreatmentNameAttachment::class, 'attachment_name_treatment');
    }
}
