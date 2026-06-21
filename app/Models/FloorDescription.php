<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorDescription extends Model
{
    use HasFactory;

    protected $table = 'floors_descriptions';

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y-m-d'
    ];

    public function getStatusLicensedAttribute()
    {
        if ($this->is_licensed == '1') {
            return '<span class="badge bg-label-warning">غير مرخص</span>';
        }elseif ($this->is_licensed == '2'){
            return '<span class="badge bg-label-success">مرخص وغير مستوفي الرسوم</span>';
        }elseif ($this->is_licensed == '3'){
            return '<span class="badge bg-label-success">مرخص ومتبقي طوابق غير مرخصة</span>';
        }elseif ($this->is_licensed == '4'){
            return '<span class="badge bg-label-success">مرخص ومستوفي الرسوم</span>';
        }else{
            return '<span class="badge bg-label-danger">غير ذلك</span>';
        }
    }
    public function getFloorNumAttribute()
    {
        if ($this->floor_number == '0') {
            return 'أرضي سكني';
        }
        if ($this->floor_number == '100') {
                return 'أرضي تجاري';    
        } elseif ($this->floor_number == '1') {
            return __('first');
        } elseif ($this->floor_number == '2') {
            return __('second');
        } elseif ($this->floor_number == '3') {
            return __('third');
        } elseif ($this->floor_number == '4') {
            return __('fourth');
        } elseif ($this->floor_number == '5') {
            return __('fifth');
        } elseif ($this->floor_number == '6') {
            return __('sixth');
        } elseif ($this->floor_number == '7') {
            return __('seventh');
        } elseif ($this->floor_number == '8') {
            return __('eighth');
        } elseif ($this->floor_number == '9') {
            return __('eighth');
        } elseif ($this->floor_number == '10') {
            return 'بدروم';
        } elseif ($this->floor_number == '11') {
            return 'بركس تجاري';
        } elseif ($this->floor_number == '12') {
            return 'بركس مزارع دواجن';
        } elseif ($this->floor_number == '13') {
            return 'بركس مزارع ابقار';
        } elseif ($this->floor_number == '14') {
            return 'بركس ';
        } else {
            return __('غير ذلك');
        }
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'floor_id', 'id');
    }
    public function devlopments()
    {
        return $this->hasMany(DevelopmentData::class, 'floor_description_id', 'id');
    }

    public function stores()
    {
        return $this->hasMany(Unit::class, 'floor_number', 'id')->where('unit_type', 2);
    }
    public function departments()
    {
        return $this->hasMany(Unit::class, 'floor_number', 'id')->where('unit_type', 1);
    }
}
