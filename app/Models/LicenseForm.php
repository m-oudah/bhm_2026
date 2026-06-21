<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LicenseForm extends Model
{
    use HasFactory;

    protected $table = 'license_forms';

    protected $guarded = [];

    public function owner()
    {
        return $this->hasOne(BuildingOwner::class, 'license_form_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'license_form_id', 'id');
    }

    public function report()
    {
        return $this->hasOne(RegulatoryDisclosureReport::class, 'license_form_id', 'id');
    }

    public function floors()
    {
        return $this->hasMany(FloorDescription::class, 'license_form_id', 'id');
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
    // opinion
    public function legal_opin()
    {
        return $this->belongsTo(LicenseFormReply::class, 'legal_opinion', 'id');
    }
    public function area_opin()
    {
        return $this->belongsTo(LicenseFormReply::class, 'area_opinion', 'id');
    }
    public function plan_opin()
    {
        return $this->belongsTo(LicenseFormReply::class, 'plan_opinion', 'id');
    }
    public function water_opin()
    {
        return $this->belongsTo(LicenseFormReply::class, 'water_opinion', 'id');
    }
    public function sewer_opin()
    {
        return $this->belongsTo(LicenseFormReply::class, 'sewer_opinion', 'id');
    }
    public function collection_opin()
    {
        return $this->belongsTo(LicenseFormReply::class, 'collection_opinion', 'id');
    }
    public function gis_opin()
    {
        return $this->belongsTo(LicenseFormReply::class, 'gis_opinion', 'id');
    }
    // ======================================
    public function deedPhoto()
    {
        return $this->belongsTo(Attachment::class, 'title_deed_id', 'id');
    }
    public function generalSitePhoto()
    {
        return $this->belongsTo(Attachment::class, 'general_site_plan_id', 'id');
    }
    public function constructionMaphoto()
    {
        return $this->belongsTo(Attachment::class, 'construction_map_id', 'id');
    }
    public function undertakingSupervisePhoto()
    {
        return $this->belongsTo(Attachment::class, 'undertaking_supervise_id', 'id');
    }
    public function aprobacionesTercerosPhoto()
    {
        return $this->belongsTo(Attachment::class, 'aprobaciones_terceros_id', 'id');
    }
    public function attachmentOne()
    {
        return $this->belongsTo(Attachment::class, 'attachment_one_id', 'id');
    }
    public function attchmentTow()
    {
        return $this->belongsTo(Attachment::class, 'attachment_tow_id', 'id');
    }
    public function attchmentThree()
    {
        return $this->belongsTo(Attachment::class, 'attachment_three_id', 'id');
    }

    // ======================================
    public function getNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->second_name) . ' ' . ucfirst($this->third_name) . ' ' . ucfirst($this->sur_name);
    }
}
