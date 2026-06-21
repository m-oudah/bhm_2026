<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TreatmentNameAttachment extends Model
{
    use HasFactory;
    protected $table = "treatment_name_attachments";

    public $guarded = [];
}
