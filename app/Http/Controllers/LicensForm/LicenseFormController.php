<?php

namespace App\Http\Controllers\LicensForm;

use App\DataTables\LicenseFormDataTable;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Building;
use App\Models\FloorDescription;
use App\Models\LicenseForm;
use App\Models\RegulatoryDisclosureReport;
use App\Models\TmpFile;
use App\Trait\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class LicenseFormController extends Controller
{
    use ImageTrait;

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(LicenseFormDataTable $datatable)
    {
        $this->authorize('Read-LicenseForms');
        return $datatable->render('license_forms.index');
    }

    public function create()
    {
        return response()->view('license_forms.create');
    }

    public function store(Request $request)
    {
        $this->authorize('Create-LicenseForm');

        $isCreate = LicenseForm::create($request->only(['building_number', 'subject', 'block_number', 'parcel_number', 'region']));
        // ==========================
        $isCreate->owner()->create($request->only(['building_number', 'first_name', 'second_name', 'third_name', 'sur_name', 'id_card', 'mokalaf', 'phone_number', 'notes', 'license_form_id']));
        // ==========================
        $request->merge([
            'license_form_id' => $isCreate->id
        ]);
        RegulatoryDisclosureReport::create($request->only(['license_form_id']));
        return $isCreate->id;
        // return to_route('license_forms.show', $isCreate->id);
    }

    public function title_deedUpload(Request $request)
    {
        if ($request->hasFile('title_deedPhoto')) {

            $file = $request->file('title_deedPhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/title_deed/'), $filename);

            TmpFile::create([
                'file' => $filename,
                'extension' => $file->getClientOriginalExtension(),
            ]);
            return $filename;
        }
    }

    public function generalSitePlanUpload(Request $request)
    {
        if ($request->hasFile('general_site_planPhoto')) {

            $file = $request->file('general_site_planPhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/general_site/'), $filename);

            TmpFile::create([
                'file' => $filename,
                'extension' => $file->getClientOriginalExtension(),
            ]);
            return $filename;
        }
    }

    public function constructionMapUpload(Request $request)
    {
        if ($request->hasFile('construction_mapPhoto')) {

            $file = $request->file('construction_mapPhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/construction_map/'), $filename);

            TmpFile::create([
                'file' => $filename,
                'extension' => $file->getClientOriginalExtension(),
            ]);
            return $filename;
        }
    }

    public function undertakingSuperviseUpload(Request $request)
    {
        if ($request->hasFile('undertaking_supervisePhoto')) {

            $file = $request->file('undertaking_supervisePhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/undertaking_supervise/'), $filename);

            TmpFile::create([
                'file' => $filename,
                'extension' => $file->getClientOriginalExtension(),
            ]);
            return $filename;
        }
    }

    public function aprobacionesTercerosUpload(Request $request)
    {
        if ($request->hasFile('aprobaciones_tercerosPhoto')) {

            $file = $request->file('aprobaciones_tercerosPhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/aprobaciones_terceros/'), $filename);

            TmpFile::create([
                'file' => $filename,
                'extension' => $file->getClientOriginalExtension(),
            ]);
            return $filename;
        }
    }
    public function attachmentOneUpload(Request $request)
    {
        if ($request->hasFile('attachmentOne')) {

            $file = $request->file('attachmentOne');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/attachments/'), $filename);

            TmpFile::create([
                'file' => $filename,
                'extension' => $file->getClientOriginalExtension(),
            ]);
            return $filename;
        }

    }
    public function show($building_number)
    {
        $this->authorize('Show-LicenseForm');

        $licenseForm = LicenseForm::where('id', $building_number)
            ->with('DeedPhoto:id,url,license_form_id')
            ->withCount(['zeroFloor', 'OneFloor', 'TwoFloor', 'ThreeFloor', 'FourFloor', 'FiveFloor', 'SexFloor', 'SevenFloor'])
            ->first();
        // return response()->json($licenseForm);
        return response()->view('license_forms.show', ['licenseForm' => $licenseForm]);
    }

    public function update(Request $request, $building_number)
    {
//         return response()->json($request->all());
//        $this->authorize('Update-LicenseForm', 'Legal-Opinions', 'SurveyDepartment-Opinion', 'UrbanPlanning-Opinion', 'WaterDepartment-Opinion', 'SewerDepartment-Opinion', 'CollectionDepartment-Opinion', 'Gis-Opinion');
        $licenseForm = LicenseForm::where('id', $building_number)->first();
        // return $building_number;
        // ==========================
        $tmp_file = TmpFile::whereFile($request->title_deedPhoto)->first();
        // return response()->json($tmp_file);
        if ($tmp_file) {
            $deedPhoto = $licenseForm->deedPhoto()->updateOrCreate([
                // 'url'     => url('license-form/title_deed/') . '/' . $tmp_file->file,
                'url' => 'license-form/title_deed/' . $tmp_file->file,
                'license_form_id' => $licenseForm->id,
                'category' => 'title_deed',
                'extension' => $tmp_file->extension,
            ]);
            $request->merge([
                'title_deed_id' => $deedPhoto->id
            ]);
        }
        // ==========================
        $tmp_file2 = TmpFile::whereFile($request->general_site_planPhoto)->first();
        if ($tmp_file2) {
            $general_site = $licenseForm->generalSitePhoto()->updateOrCreate([
                'url' => 'license-form/general_site/' . $tmp_file2->file,
                'license_form_id' => $licenseForm->id,
                'category' => 'general_site',
                'extension' => $tmp_file2->extension,

            ]);
            $request->merge([
                'general_site_plan_id' => $general_site->id
            ]);
        }
        // ==========================
        $tmp_file3 = TmpFile::whereFile($request->construction_mapPhoto)->first();
        // return response()->json($tmp_file3);
        if ($tmp_file3) {
            $construction_map = $licenseForm->generalSitePhoto()->updateOrCreate([
                'url' => 'license-form/construction_map/' . $tmp_file3->file,
                'license_form_id' => $licenseForm->id,
                'category' => 'construction_map',
                'extension' => $tmp_file3->extension,
            ]);
            $request->merge([
                'construction_map_id' => $construction_map->id
            ]);
        }
        // ==========================
        $tmp_file4 = TmpFile::whereFile($request->undertaking_supervisePhoto)->first();
        // return response()->json($tmp_file3);
        if ($tmp_file4) {
            $undertaking_supervise = $licenseForm->undertakingSupervisePhoto()->updateOrCreate([
                'url' => 'license-form/undertaking_supervise/' . $tmp_file4->file,
                'license_form_id' => $licenseForm->id,
                'category' => 'undertaking_supervise',
                'extension' => $tmp_file4->extension,
            ]);
            $request->merge([
                'undertaking_supervise_id' => $undertaking_supervise->id
            ]);
        }
        // ==========================
        $tmp_file5 = TmpFile::whereFile($request->aprobaciones_tercerosPhoto)->first();
        // return response()->json($tmp_file3);
        if ($tmp_file5) {
            $aprobaciones_terceros = $licenseForm->aprobacionesTercerosPhoto()->updateOrCreate([
                'url' => 'license-form/aprobaciones_terceros/' . $tmp_file5->file,
                'license_form_id' => $licenseForm->id,
                'category' => 'aprobaciones_terceros',
                'extension' => $tmp_file5->extension,
            ]);
            $request->merge([
                'aprobaciones_terceros_id' => $aprobaciones_terceros->id
            ]);
        }
        // ==========================
        $tmp_file6 = TmpFile::whereFile($request->attachmentOne)->first();
        // return response()->json($tmp_file3);
        if ($tmp_file6) {
            $attachment_one = $licenseForm->attachmentOne()->updateOrCreate([
                'url' => 'license-form/aprobaciones_terceros/' . $tmp_file6->file,
                'license_form_id' => $licenseForm->id,
                'category' => 'attachment_ones',
                'extension' => $tmp_file6->extension,
            ]);
            $request->merge([
                'terattachment_one_id' => $attachment_one->id
            ]);
        }
        // ==========================
        // ==========================
        if (Auth::user()->can('Legal-Opinions')) {
            if ($request->input('legal_opinion')) {
                $legal_opinion = $licenseForm->legal_opin()->updateOrCreate([
                    'user_id' => Auth::id(),
                    'reply' => $request->input('legal_opinion'),
                    'status' => $request->status ? $request->input('status') : '0',
                ]);
                $licenseForm->legal_opinion = $legal_opinion->id;
            }
        }
        if (Auth::user()->can('SurveyDepartment-Opinion')) {
            if ($request->input('area_opinion')) {
                $area_opinion = $licenseForm->area_opin()->updateOrCreate([
                    'user_id' => Auth::id(),
                    'reply' => $request->input('area_opinion'),
                    'status' => $request->status ? $request->input('status') : '0',
                ]);
                $licenseForm->area_opinion = $area_opinion->id;
            }
        }
        if (Auth::user()->can('UrbanPlanning-Opinion')) {
            if ($request->input('plan_opinion')) {
                $plan_opinion = $licenseForm->plan_opin()->updateOrCreate([
                    'user_id' => Auth::id(),
                    'reply' => $request->input('plan_opinion'),
                    'status' => $request->status ? $request->input('status') : '0',
                ]);
                $licenseForm->plan_opinion = $plan_opinion->id;
            }
        }
        if (Auth::user()->can('WaterDepartment-Opinion')) {
            if ($request->input('water_opinion')) {
                $water_opinion = $licenseForm->water_opin()->updateOrCreate([
                    'user_id' => Auth::id(),
                    'reply' => $request->input('water_opinion'),
                    'status' => $request->status ? $request->input('status') : '0',
                ]);
                $licenseForm->water_opinion = $water_opinion->id;
            }
        }
        if (Auth::user()->can('SewerDepartment-Opinion')) {
            if ($request->input('sewer_opinion')) {
                $sewer_opinion = $licenseForm->sewer_opin()->updateOrCreate([
                    'user_id' => Auth::id(),
                    'reply' => $request->input('sewer_opinion'),
                    'status' => $request->status ? $request->input('status') : '0',
                ]);
                $licenseForm->sewer_opinion = $sewer_opinion->id;
            }
        }
        if (Auth::user()->can('CollectionDepartment-Opinion')) {
            if ($request->input('collection_opinion')) {
                $collection_opinion = $licenseForm->collection_opin()->updateOrCreate([
                    'user_id' => Auth::id(),
                    'reply' => $request->input('collection_opinion'),
                    'status' => $request->status ? $request->input('status') : '0',
                ]);
                $licenseForm->collection_opinion = $collection_opinion->id;
            }
        }
        if (Auth::user()->can('Gis-Opinion')) {
            if ($request->input('gis_opinion')) {
                $gis = $licenseForm->gis_opin()->updateOrCreate([
                    'user_id' => Auth::id(),
                    'reply' => $request->input('gis_opinion'),
                    'status' => $request->status ? $request->input('status') : '0',
                ]);
                $licenseForm->gis_opinion = $gis->id;
            }
        }
        // ==========================
        // ==========================
        $isUpdate = $licenseForm->update($request->only(['title_deed_id', 'general_site_plan_id', 'construction_map_id', 'undertaking_supervise_id', 'aprobaciones_terceros_id','attachment_one', 'building_number', 'subject', 'block_number', 'parcel_number', 'region']));
        // ==========================
        if ($request->input('building_number') || $request->input('first_name') || $request->input('second_name') || $request->input('third_name') || $request->input('sur_name') || $request->input('id_card') || $request->input('mokalaf') || $request->input('phone_number') || $request->input('notes')) {
            $licenseForm->owner()->update($request->only(['building_number', 'first_name', 'second_name', 'third_name', 'sur_name', 'id_card', 'mokalaf', 'phone_number', 'notes']));
        }
    }

    public function destroy(LicenseForm $licenseForm)
    {
        $this->authorize('Delete-LicenseForm');
        $isDelete = $licenseForm->delete();
        return response()->json([
            'icon' => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function getFloorForlicense($id)
    {
        $data = FloorDescription::query()->where('license_form_id', $id);
        // return response()->json($data);
        return DataTables::eloquent($data)->addIndexColumn()
            ->editColumn('floor_number', function ($row) {
                return $row->FloorNum;
            })
            ->editColumn('is_licensed', function ($row) {
                return $row->StatusLicensed;
            })
            ->addColumn('remaining_amount', function ($row) {
                return $row->required_pay - $row->license_fees;
            })
            ->addColumn('action', function ($row) {
                return '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">

                <a class="dropdown-item" id="editRowFloor"  data-id="' . $row->id . '" href="javascript:;"  data-bs-toggle="modal" data-bs-target="#show_floor_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>

                <a id="deleteRowFloor" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a></div></div>';
            })
            ->rawColumns(['is_licensed', 'action'])->make('true');
    }

    public function print(Request $request, $id)
    {
        $data = LicenseForm::with(['owner', 'floors'])->findOrFail($id);
        $users = LicenseForm::whereYear('created_at',$data->created_at -> year)->select('id')->get();
        // return array_values($users);
        $count = 1;
        foreach($users as $form)
        {
            if($form -> id == $data->id)
            {
                $data['index'] = $count;
            }
            $count ++;
        }
        return response()->view('license_forms.print', ['license' => $data]);

//        $templateProcessor  = new TemplateProcessor('word-template/1.docx');
//
//        $templateProcessor->setValue('FULL_NAME', 'John Doe');
//        $templateProcessor->setValue('EMAIL', 'john.doe@example.com');
//
//        $templateProcessor->saveAs('filled_document.docx');
//        return response()->download('filled_document.docx');

    }

    public function printRegulatory(Request $request, $id)
    {
        $data = LicenseForm::with('owner')->findOrFail($id);
        $users = LicenseForm::whereYear('created_at',$data->created_at -> year)->select('id')->get();
        // return array_values($users);
        $count = 1;
        foreach($users as $form)
        {
            if($form -> id == $data->id)
            {
                $data['index'] = $count;
            }
            $count ++;
        }

        return response()->view('license_forms.regulatory_report_print', ['regulatory_report' => $data]);
    }
    public function printFania(Request $request, $id)
    {
        $data = LicenseForm::with('owner')->findOrFail($id);
        $users = LicenseForm::whereYear('created_at',$data->created_at -> year)->select('id')->get();
        // return array_values($users);
        $count = 1;
        foreach($users as $form)
        {
            if($form -> id == $data->id)
            {
                $data['index'] = $count;
            }
            $count ++;
        }


        return response()->view('license_forms.fania_report_print', ['regulatory_report' => $data]);

    }

    public function printOpin(Request $request, $id)
    {
        $data = LicenseForm::findOrFail($id);
        $users = LicenseForm::whereYear('created_at',$data->created_at -> year)->select('id')->get();
        // return array_values($users);
        $count = 1;
        foreach($users as $form)
        {
            if($form -> id == $data->id)
            {
                $data['index'] = $count;
            }
            $count ++;
        }


        return response()->view('license_forms.opin_print', ['license' => $data]);
    }
    public function printFloor(Request $request, $id)
    {
        $data = LicenseForm::with('floors')->with('floors.devlopments')->findOrFail($id);
        $users = LicenseForm::whereYear('created_at',$data->created_at -> year)->select('id')->get();
        // return array_values($users);
        $count = 1;
        foreach($users as $form)
        {
            if($form -> id == $data->id)
            {
                $data['index'] = $count;
            }
            $count ++;
        }

//        return \response()->json($data);
        return response()->view('license_forms.floor', ['license' => $data]);
    }
    public function certified(Request $request, $id)
    {
        $licenseForm = LicenseForm::with(['owner', 'deedPhoto', 'generalSitePhoto', 'constructionMaphoto', 'undertakingSupervisePhoto', 'aprobacionesTercerosPhoto', 'report', 'floors'])->withCount('floors')->findOrFail($id);
        // return response()->json($licenseForm);

        if ($licenseForm) {
            if ($licenseForm->report->trust != '1') {
                return response()->json(['message' => 'يرجى اعتماد معلومات تقرير الكشف التنظيمي'], Response::HTTP_OK);
            }
            if ($licenseForm->floors_count == 0) {
                return response()->json(['message' => 'يرجى إكمال بيانات الطوابق'], Response::HTTP_OK);
            }
            if ($licenseForm->legal_opin == null || $licenseForm->area_opin == null || $licenseForm->plan_opin == null || $licenseForm->water_opin == null || $licenseForm->sewer_opin == null || $licenseForm->collection_opin == null || $licenseForm->gis_opin == null) {
                return response()->json(['message' => 'اّراء الأقسام غير مكتملة'], Response::HTTP_OK);
            }
            if ($licenseForm->legal_opin->status != '1' || $licenseForm->area_opin->status != '1' || $licenseForm->plan_opin->status != '1' || $licenseForm->water_opin->status != '1' || $licenseForm->sewer_opin->status != '1' || $licenseForm->collection_opin->status != '1' || $licenseForm->gis_opin->status != '1') {
                return response()->json(['message' => 'هناك منع من أحد الاّراء'], Response::HTTP_OK);
            }
            // if ($licenseForm->deedPhoto == null || $licenseForm->generalSitePhoto == null || $licenseForm->constructionMaphoto == null || $licenseForm->undertakingSupervisePhoto == null || $licenseForm->aprobacionesTercerosPhoto == null) {
            //     return response()->json(['message' => 'هناك نقص بالمرفقات'], Response::HTTP_OK);
            // }
            $isCreate = Building::create([
                'building_number' => $licenseForm->building_number,
                'block_number' => $licenseForm->block_number,
                'parcel_number' => $licenseForm->parcel_number,
                'area' => $licenseForm->report->total_coupon_space
            ]);
            $licenseForm->floors()->update([
                'building_id' => $isCreate->id
            ]);
            $licenseForm->owner()->update([
                'building_id' => $isCreate->id
            ]);
            $licenseForm->report()->update([
                'building_id' => $isCreate->id
            ]);
            $licenseForm->attachments()->update([
                'building_id' => $isCreate->id
            ]);

            $licenseForm->update(['status' => '1']);

            return response()->json(['message' => 'تم الحفظ'], Response::HTTP_OK);
        }
    }
}
