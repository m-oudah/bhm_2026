<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProofOfCase extends Model
{
    use HasFactory;

    public $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'proof_of_case_id', 'id');
    }


    public function getDaysAttribute()
    {
        if($this->day == '1'){
            return 'الأحد';
        }elseif($this->day == '2'){
            return 'الاثنين';
        }elseif($this->day == '3'){
            return 'الثلاثاء';
        }elseif($this->day == '4'){
            return 'الاربعاء';
        }elseif($this->day == '5'){
            return 'الخميس';
        }
    }
}
