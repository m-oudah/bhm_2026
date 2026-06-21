<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function street()
    {
        return $this->belongsTo(Street::class, 'street_id', 'id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    public function floors()
    {
        return $this->hasMany(FloorDescription::class, 'building_id', 'id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class, 'building_id', 'id');
    }

    public function requests()
    {
        return $this->hasOne(LicenseForm::class, 'building_id', 'id');
    }

    public function regulatory_disclosure_reports()
    {
        return $this->hasOne(RegulatoryDisclosureReport::class, 'building_id', 'id');
    }

    public function subzone()
    {
        return $this->belongsTo(SubZone::class, 'subzone_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(BuildingType::class, 'building_type', 'id');
    }

    public function uses()
    {
        return $this->belongsToMany(BuildingUse::class, 'building_building_use', 'building_id', 'building_use_id', 'id', 'id');
    }

    public function materials()
    {
        return $this->belongsToMany(BuildingMaterial::class, 'building_building_material', 'building_id', 'building_material_id', 'id', 'id');
    }

    public function owners()
    {
        return $this->hasMany(BuildingOwner::class, 'building_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'building_id', 'id');
    }

    public function proofs()
    {
        return $this->hasMany(ProofOfCase::class, 'building_id', 'id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'building_id', 'id');
    }

    public function economicals()
    {
        return $this->hasMany(Economical::class, 'bulding_id', 'id');
    }

    public function getGeneral_ConditionAttribute()
    {
        if ($this->general_condition == '1') {
            return 'ممتازة';
        } elseif ($this->general_condition == '2') {
            return 'جيدة';
        } elseif ($this->general_condition == '3') {
            return 'سيئة';
        } else {
            return 'لا يتوفر معلومات';
        }
    }

    public function getExternal_ConditionAttribute()
    {
        if ($this->external_condition == '1') {
            return 'مشطب كامل';
        } elseif ($this->external_condition == '2') {
            return 'مشطب جزئي';
        } elseif ($this->external_condition == '3') {
            return 'غير مشطب';
        } else {
            return 'لا يتوفر معلومات';
        }
    }

    public function getSewage_Attribute()
    {
        if ($this->sewage == '1') {
            return 'بلدية';
        } elseif ($this->sewage == '2') {
            return 'بئر خاص';
        } elseif ($this->sewage == '3') {
            return 'لا يوجد';
        } else {
            return 'لا يتوفر معلومات';
        }
    }

    public function scopeFilter(Builder $builder, $filters)
    {

        $builder->when($filters['file_number'] ?? null, function ($builder, $value) {
            $builder->where('file_number', $value);
        });
        $builder->when($filters['building_number'] ?? null, function ($builder, $value) {
            $builder->where('building_number', $value);
        });
        $builder->when($filters['block_number'] ?? null, function ($builder, $value) {
            $builder->where('block_number', $value);
        });
        $builder->when($filters['parcel_number'] ?? null, function ($builder, $value) {
            $builder->where('parcel_number', $value);
        });
        $builder->when($filters['building_name'] ?? null, function ($builder, $value) {
            $builder->where('building_name', 'like', "%{$value}%");
        });
        $builder->when($filters['street_id'] ?? null, function ($builder, $value) {
            $builder->where('street_id', $value);
        });

        $builder->when($filters['id_card'] ?? null, function ($builder, $value) {
            $builder->whereHas('owners', function ($q) use ($value) {
                $q->where('id_card', $value);
            });
        });
        $builder->when($filters['phone_number'] ?? null, function ($builder, $value) {
            $builder->whereHas('owners', function ($q) use ($value) {
                $q->where('phone_number', $value);
            });
        });
        $builder->when($filters['first_name'] ?? null, function ($builder, $value) {
            $builder->whereHas('owners', function ($q) use ($value) {
                $q->where('first_name', $value);
            });
        });
        $builder->when($filters['second_name'] ?? null, function ($builder, $value) {
            $builder->whereHas('owners', function ($q) use ($value) {
                $q->where('second_name', $value);
            });
        });
        $builder->when($filters['third_name'] ?? null, function ($builder, $value) {
            $builder->whereHas('owners', function ($q) use ($value) {
                $q->where('third_name', $value);
            });
        });
        $builder->when($filters['sur_name'] ?? null, function ($builder, $value) {
            $builder->whereHas('owners', function ($q) use ($value) {
                $q->where('sur_name', $value);
            });
        });
        $builder->when($filters['license'] ?? null, function ($builder, $value) {
            if ($value == '1') {
                $builder->whereNull('file_number');
            } elseif ($value == '2') {
                $builder->whereNotNull('file_number')->whereHas('floors', function ($q) {
                    $q->whereRaw('required_pay - license_fees > 0');
                });
            } elseif ($value == '3') {
                $builder->whereNotNull('file_number')->whereHas('floors', function ($q) {
                    $q->where('is_licensed', '3');
                });
            } elseif ($value == '4') {
                $builder->whereNotNull('file_number')->whereHas('floors', function ($q) {
                    $q->whereRaw('required_pay - license_fees = 0');
                });
            }
        });

        $builder->when($filters['building_type'] ?? null, function ($builder, $value) {
            $builder->whereHas('type', function ($q) use ($value) {
                $q->where('id', $value);
            });
        });
        $builder->when($filters['subscription'] ?? null, function ($builder, $value) {
            if ($value == '1') {
                $builder->whereDoesntHave('subscriptions');
            } elseif ($value == '2') {
                $builder->whereHas('subscriptions');
            } else {
                $builder->whereHas('subscriptions', function ($q) use ($value) {
                    $q->where('status', $value);
                });
            }
        });
        $builder->when($filters['craft'] ?? null, function ($builder, $value) {
            if ($value == '1') {
                $builder->whereDoesntHave('economicals');
            } elseif ($value == '2') {
                $builder->whereHas('economicals');
            } elseif ($value == '3') {
                $builder->whereHas('economicals', function ($q) use ($value) {
                    $q->where('isLicensed', '1');
                });
            } elseif ($value == '4') {
                $builder->whereHas('economicals', function ($q) use ($value) {
                    $q->where('isLicensed', '1')->where('isDanger', '1');
                });
            } elseif ($value == '5') {
                $builder->whereHas('economicals', function ($q) use ($value) {
                    $q->where('isLicensed', '2');
                });
            } elseif ($value == '6') {
                $builder->whereHas('economicals', function ($q) use ($value) {
                    $q->where('isLicensed', '2')->where('isDanger', '2');
                });
            }
        });

    }
    // ======================================
    // check count floors
    public function zeroFloor()
    {
        return $this->hasOne(FloorDescription::class, 'license_form_id', 'id')->where('floor_number', '0');
    }

    public function OneFloor()
    {
        return $this->hasOne(FloorDescription::class, 'license_form_id', 'id')->where('floor_number', '1');
    }

    public function TwoFloor()
    {
        return $this->hasOne(FloorDescription::class, 'license_form_id', 'id')->where('floor_number', '2');
    }

    public function ThreeFloor()
    {
        return $this->hasOne(FloorDescription::class, 'license_form_id', 'id')->where('floor_number', '3');
    }

    public function FourFloor()
    {
        return $this->hasOne(FloorDescription::class, 'license_form_id', 'id')->where('floor_number', '4');
    }

    public function FiveFloor()
    {
        return $this->hasOne(FloorDescription::class, 'license_form_id', 'id')->where('floor_number', '5');
    }

    public function SexFloor()
    {
        return $this->hasOne(FloorDescription::class, 'license_form_id', 'id')->where('floor_number', '6');
    }

    public function SevenFloor()
    {
        return $this->hasOne(FloorDescription::class, 'license_form_id', 'id')->where('floor_number', '7');
    }
    // ======================================
}
