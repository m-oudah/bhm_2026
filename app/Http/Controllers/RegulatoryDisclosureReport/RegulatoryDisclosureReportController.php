<?php

namespace App\Http\Controllers\RegulatoryDisclosureReport;

use App\Http\Controllers\Controller;
use App\Models\RegulatoryDisclosureReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class RegulatoryDisclosureReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
    }

    public function show(RegulatoryDisclosureReport $regulatoryDisclosureReport)
    {
        //
    }

    public function edit(RegulatoryDisclosureReport $regulatoryDisclosureReport)
    {
        //
    }

    public function update(Request $request)
    {
        $regulatoryDisclosureReport = RegulatoryDisclosureReport::where('license_form_id', $request->license_form_id);
        if ($regulatoryDisclosureReport) {
            // return response()->json($request->all());
            $data = $request->only([
                'building_id', 'isproperty', 'isorted', 'region','development_area', 'location_status', 'total_coupon_space', 'building_area', 'rebounds_front', 'rebounds_back', 'rebounds_right',
                'rebounds_left', 'construction_ratio', 'number_floor', 'purpose_building_use', 'site_on_structural', 'passes_through_site', 'territory_regulatory_requirement', 'department_notes'
            ]);
            $isUpdate = $regulatoryDisclosureReport->update($data);

            if ($isUpdate)
                return response()->json(['message' => 'تم الحفظ'], Response::HTTP_OK);
        }
    }
    public function confirm_data(Request $request)
    {
        $regulatoryDisclosureReport = RegulatoryDisclosureReport::where('license_form_id', $request->license_form_id);
        if ($regulatoryDisclosureReport) {
            // return response()->json($request->all());
            $request->merge([
                'trust' => '1'
            ]);
            $data = $request->only([
                'building_id', 'isproperty', 'isorted', 'region','development_area', 'location_status', 'total_coupon_space', 'building_area', 'rebounds_front', 'rebounds_back', 'rebounds_right',
                'rebounds_left', 'construction_ratio', 'number_floor', 'purpose_building_use', 'site_on_structural', 'trust', 'passes_through_site', 'territory_regulatory_requirement', 'department_notes'
            ]);
            $isUpdate = $regulatoryDisclosureReport->update($data);

            if ($isUpdate)
                return response()->json(['message' => 'تم الاعتماد'], Response::HTTP_OK);
        }
    }

    public function destroy(RegulatoryDisclosureReport $regulatoryDisclosureReport)
    {
        //
    }
}
