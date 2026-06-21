<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegulatoryDisclosureReport extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function licensForm()
    {
        return $this -> belongsTo(LicenseForm::class,'id','license_form_id');
    }
    public function getPropertyAttribute()
    {
        return $this->isproperty ? 'يملك' : 'مستأجر';
    }
    public function getSortedAttribute()
    {
        return $this->isorted ? 'مفروزة' : 'غير مفروزة';
    }
    public function getRegionReportAttribute()
    {
        if ($this->region == '1') {
            return 'سكنية';
        } elseif ($this->region == '2') {
            return 'تجارية';
        } elseif ($this->region == '3') {
            return 'زراعية';
        } elseif ($this->region == '4') {
            return 'زراعية مساعدة';
        } elseif ($this->region == '5') {
            return 'صناعية';
        } elseif ($this->region == '6') {
            return 'سياحية';
        } else {
            return 'لا معلومات';
        }
    }
    
    public function getLocationAttribute()
    {
        if ($this->location_status == '1') {
            return 'فراغ';
        } elseif ($this->location_status == '2') {
            return 'تحت الإنشاء';
        } elseif ($this->location_status == '3') {
            return 'تام الإنشاء';
        } else {
            return 'لا معلومات';
        }
    }

}
