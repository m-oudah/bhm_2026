<?php

namespace App\Http\Controllers\Building;

use App\DataTables\BuildingDataTable;
use App\Exports\BuildingExport;
use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Building;
use App\Models\BuildingFinish;
use App\Models\BuildingMaterial;
use App\Models\BuildingOwner;
use App\Models\BuildingPropertyType;
use App\Models\BuildingStatus;
use App\Models\BuildingType;
use App\Models\BuildingUse;
use App\Models\CategoryArchiveAttachment;
use App\Models\Economical;
use App\Models\FloorDescription;
use App\Models\ProofOfCase;
use App\Models\Street;
use App\Models\Subscription;
use App\Models\SubZone;
use App\Models\Unit;
use App\Models\User;
use App\Models\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;


class BuildingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(Request $request, BuildingDataTable $dataTable)
    {
        $this->authorize('Read-Buildings');
        $street = Street::all();
        $zone = Zone::all();
        $buildingType = BuildingType::get();

//        return response()->json($request->all());
//        if($request->submit == 'export_excel'){
//            return response()->json($request->all());
//        }


        // return response()->json();
        return $dataTable->render('buildings.index', ['streets' => $street, 'zones' => $zone, 'buildingTypes' => $buildingType]);
    }

    public function create()
    {
        $street = Street::get();
        $zone = Zone::get();
        $subzone = SubZone::get();
        $propertyType = BuildingPropertyType::get();
        $buildingType = BuildingType::get();
        $buildingStatus = BuildingStatus::get();
        $buildingUse = BuildingUse::get();
        $buildingMaterial = BuildingMaterial::get();
        $buildingFinish = BuildingFinish::get();
        return response()->view('buildings.create', [
            'streets' => $street,
            'zones' => $zone, 'subzones' => $subzone, 'propertyTypes' => $propertyType, 'buildingTypes' => $buildingType,
            'buildingStatus' => $buildingStatus, 'buildingUse' => $buildingUse, 'buildingMaterial' => $buildingMaterial,
            'buildingFinish' => $buildingFinish
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('Create-Building');

        $isExist = Building::where('street_id',$request -> street_id)->where('building_number',$request -> building_number)->first();
        if($isExist)
        {
            return response()->json(['message' => 'هذا المبنى مضاف مسبقا'], Response::HTTP_BAD_REQUEST);
 
        }
        // return response()->json($request->all());
        $isCreate = Building::create($request->only([
            'file_number', 'street_id', 'zone_id', 'subzone_id', 'building_number', 'block_number', 'parcel_number', 'building_name', 'building_property_type_id',
            'building_type', 'building_status_id', 'building_finish_id', 'general_condition', 'external_condition', 'sewage', 'escape_staircase', 'waterNetwork', 'sewageNetwork', 'area'
        ]));

        $isCreate->owners()->create($request->only(['first_name', 'second_name', 'third_name', 'sur_name', 'id_card', 'phone_number', 'mokalaf', 'notes']));

        $building_use = $request->input('uses');
        $isCreate->uses()->sync($building_use);

        $building_material = $request->input('material');
        $isCreate->materials()->sync($building_material);


        if ($isCreate)
            return response()->json(['message' => $isCreate ? 'تم الحفظ' : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function show(Building $building)
    {
        $this->authorize('Show-Building');

        $street = Street::get();
        $zone = Zone::get();
        $subzone = SubZone::get();
        $propertyType = BuildingPropertyType::get();
        $buildingType = BuildingType::get();
        $buildingStatus = BuildingStatus::get();
        $buildingUse = BuildingUse::get();
        $buildingMaterial = BuildingMaterial::get();
        $buildingFinish = BuildingFinish::get();

        $category_archive_attachment = CategoryArchiveAttachment::get();

        $license_img = Attachment::whereBuilding_id($building->id)->where('extension', '!=', 'pdf')->get();
        $license_pdf = Attachment::whereBuilding_id($building->id)->whereExtension('pdf')->get();

        
        $building = Building::with(['owners', 'requests', 'units'])
            ->withSum('floors', 'area')
            ->withSum('floors', 'licensed_area')
            ->withSum('floors', 'license_fees')
            ->with(['floors'=>function($q){
                $q->with(['devlopments']);
            }])
            ->withCount(['zeroFloor', 'OneFloor', 'TwoFloor', 'ThreeFloor', 'FourFloor', 'FiveFloor', 'SexFloor', 'SevenFloor'])
            ->whereId($building->id)
            ->first();

        $remaining_amount = 0;
        foreach ($building->floors as $item) {
            $remaining_amount += $item->required_pay - $item->license_fees;
        }
        $building->remaining_amount = $remaining_amount;

        $dev_required_pay = 0;
        foreach ($building->floors as $item) {
            foreach ($item->devlopments as $item2){
                $dev_required_pay += $item2->totle_fees;
            }
        }
        $building->dev_required_pay = $dev_required_pay;

        $dev_remaining_amount = 0;
        foreach ($building->floors as $item) {
            foreach ($item->devlopments as $item2){
                $dev_remaining_amount += $item2->required_pay - $item2->pay_fees;
            }
        }
        $building->remaining_amount = $remaining_amount;


//        return response()->json($building);
        return response()->view('buildings.show', [
            'building' => $building, 'streets' => $street, 'zones' => $zone, 'subzones' => $subzone,
            'propertyTypes' => $propertyType, 'buildingTypes' => $buildingType, 'buildingStatus' => $buildingStatus,
            'buildingUse' => $buildingUse, 'buildingMaterial' => $buildingMaterial, 'buildingFinish' => $buildingFinish,
            'category_archive_attachments' => $category_archive_attachment, 'license_img' => $license_img, 'license_pdf' => $license_pdf
        ]);
    }

    public function edit(Building $building)
    {
        return response()->view('buildings.edit', ['building' => $building]);
    }

    public function update(Request $request, Building $building)
    {
        $this->authorize('Update-Building');

        $isUpdate = $building->update($request->only([
            'file_number', 'street_id', 'zone_id', 'subzone_id', 'building_number', 'block_number', 'parcel_number', 'building_name', 'building_property_type_id',
            'building_type', 'building_status_id', 'building_finish_id', 'general_condition', 'external_condition', 'sewage', 'escape_staircase', 'waterNetwork', 'sewageNetwork', 'area'
        ]));

        //update License request
        $building->requests()->update($request->only(['legal_opinion', 'area_opinion', 'plan_opinion', 'water_opinion', 'sewer_opinion', 'collection_opinion']));

        $building_use = $request->input('uses');
        $building->uses()->sync($building_use);

        $building_material = $request->input('material');
        $building->materials()->sync($building_material);

        if ($isUpdate)
            return response()->json(['message' => $isUpdate ? 'تم الحفظ' : 'هناك خطأ ما'], $isUpdate ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Building $building)
    {
        $this->authorize('Delete-Building');
        $isDelete = $building->delete();
        return response()->json([
            'icon' => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function uploadAttchment(Request $request)
    {
        $building_id = $request->input('building_id');

        if ($request->hasFile('title_deedPhoto')) {

            $file = $request->file('title_deedPhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/title_deed/'), $filename);

            Attachment::create([
                'url' => '/license-form/title_deed/' . $filename,
                'extension' => $file->getClientOriginalExtension(),
                'building_id' => $building_id,
                'category' => 'title_deed'
            ]);
        }
        if ($request->hasFile('general_site_planPhoto')) {

            $file = $request->file('general_site_planPhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/general_site_plan/'), $filename);

            Attachment::create([
                'url' => '/license-form/general_site_plan/' . $filename,
                'extension' => $file->getClientOriginalExtension(),
                'building_id' => $building_id,
                'category' => 'general_site_plan'
            ]);
        }
        if ($request->hasFile('construction_mapPhoto')) {

            $file = $request->file('construction_mapPhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/construction_map/'), $filename);

            Attachment::create([
                'url' => '/license-form/construction_map/' . $filename,
                'extension' => $file->getClientOriginalExtension(),
                'building_id' => $building_id,
                'category' => 'construction_map'
            ]);
        }
        if ($request->hasFile('undertaking_supervisePhoto')) {

            $file = $request->file('undertaking_supervisePhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/undertaking_supervise/'), $filename);

            Attachment::create([
                'url' => '/license-form/undertaking_supervise/' . $filename,
                'extension' => $file->getClientOriginalExtension(),
                'building_id' => $building_id,
                'category' => 'undertaking_supervise'
            ]);
        }
        if ($request->hasFile('aprobaciones_tercerosPhoto')) {

            $file = $request->file('aprobaciones_tercerosPhoto');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('license-form/aprobaciones_terceros/'), $filename);

            Attachment::create([
                'url' => '/license-form/aprobaciones_terceros/' . $filename,
                'extension' => $file->getClientOriginalExtension(),
                'building_id' => $building_id,
                'category' => 'aprobaciones_terceros'
            ]);
        }
    }

    public function getOwnerForBuilding($id)
    {
        // if (Auth::user()->can('Read-Floors'))

        $data = BuildingOwner::query()->with('subscriptions')->whereBuilding_id($id);

        return DataTables::eloquent($data)->addIndexColumn()
            ->addColumn('fullName', function ($row) {
                return $row->FullName;
            })
            ->addColumn('action', function ($row) {

                $data = '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">';

                if (Auth::User()->can("Update-Owner")) {
                    $data .= '<a class="dropdown-item" id="show_owner"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_owner_model">
                    <i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>';
                }
                if (Auth::User()->can("TransferProperty")) {
                    $data .= '<a class="dropdown-item" id="show_owner"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_transfer_model" >
                        <i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Transfer') . '</span>
                    </a>';
                }
                if (Auth::User()->can("Delete-Owner")) {
                    $data .= '<a id="deleteRow" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a></div></div>';
                }
                return $data;
            })
            ->rawColumns(['mokalaf', 'action'])->make('true');
    }

    public function getUnitForBuilding($id)
    {
        $data = Unit::query()->whereBuilding_id($id);
        return DataTables::eloquent($data)->addIndexColumn()
            ->editColumn('floor_number', function ($row) {
                return $row->FloorNum;
            })
            ->addColumn('unit_owners', function ($row) {
                $data = [];
                foreach ($row->owners as $item) {
                    $data[] = $item->FullName;
                }
                return $data;
//                return $row->owner ? $row->owner->FullName : '';
            })
            ->addColumn('unit_uses', function ($row) {
                return $row->uses ? $row->uses->FullName : 'نفسه';
            })
            ->editColumn('unit_type', function ($row) {
                return $row->TypeUnits;
            })
            ->addColumn('action', function ($row) {
                $data = '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">';
                if (Auth::User()->can("Update-Unit")) {
                    $data .= '<a class="dropdown-item" id="editRowUnit"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_edit_unit_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>';
                }
                if (Auth::User()->can("Delete-Unit")) {
                    $data .= '<a id="deleteRowUnit" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a></div></div>';
                }
                return $data;
            })
            ->make('true');
    }

    public function getFloorForBuilding($id)
    {
        $data = FloorDescription::query()->with(['units'])->withCount(['units', 'stores', 'departments'])->whereBuilding_id($id);
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
                $data = '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">';
                if (Auth::User()->can("Update-Floor")) {
                    $data .= '<a class="dropdown-item" id="editRowFloor"  data-id="' . $row->id . '" href="javascript:;"  data-bs-toggle="modal" data-bs-target="#show_floor_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>';
                }
                if (Auth::User()->can("Delete-Floor")) {
                    $data .= '<a id="deleteRowFloor" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a>';
                }
                $data .= '</div></div>';

                return $data;
            })
            ->rawColumns(['is_licensed', 'action'])->make('true');
    }

    public function getCraftForBuilding($id)
    {
        // $bulding = Building::where('id', $id)->first();
        // $data = Economical::query()->whereStreet_id($bulding->street_id)->whereBuilding_number($bulding->building_number);
        $data = Economical::query()->whereBulding_id($id);

        return DataTables::eloquent($data)->addIndexColumn()
            ->addColumn('sector', function ($row) {
                return $row->sector ? $row->sector->description : '';
            })
            ->addColumn('owner', function ($row) {
                return $row->owners ? $row->owners->Full_Name : '';
            })
            ->editColumn('job_formal_name', function ($row) {
                return $row->job_formal_name ;
            })
            ->editColumn('craft_number', function ($row) {
                return '<div class="badge badge-glow badge-success"> رقم الملف: '. $row->craft_number.'</div>';
            })

            ->addColumn('id_card', function ($row) {
                return $row->owners ? $row->owners->id_card : '';
            })
            ->addColumn('phone_number', function ($row) {
                return $row->owners ? $row->owners->phone_number : '';
            })
            ->editColumn('mokalaf', function ($row) {
                return $row->owners ? $row->owners->mokalaf : '';
            })
            ->addColumn('action', function ($row) {
                $data = '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">';
                if (Auth::User()->can("Update-Craft")) {
                    $data .= '<a class="dropdown-item" id="editRowCraft"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal"data-bs-target="#show_edit_craft_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>';
                }
                if (Auth::user()->can('Delete-Craft')) {
                    $data .= '<a id="deleteRowEconomical" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a>';
                }
                

                $data .= '</div></div>';
                return $data;
            })
            ->rawColumns(['job_formal_name','action','craft_number'])
            ->make('true');
    }

    public function getSubscriptionForBuilding($id)
    {
        $data = Subscription::query()->with(['owner'])->whereBuilding_id($id);

        return DataTables::eloquent($data)->addIndexColumn()
            ->addColumn('owner_id_number', function ($row) {
                return $row->owner ? $row->owner->id_card : '';
            })
            ->addColumn('owner_name', function ($row) {
                return $row->owner ? $row->owner->FullName : '';
            })
            ->addColumn('owner_mokalaf', function ($row) {
                return $row->owner ? $row->owner->mokalaf : '';
            })
            ->addColumn('owner_phone_number', function ($row) {
                return $row->owner ? $row->owner->phone_number : '';
            })
            ->addColumn('units', function ($row) {
                $unit = [];
                foreach ($row->units as $item) {
                    $unit[] = $item->unit_number;
                }
                return $unit;
            })
            ->addColumn('action', function ($row) {
                $data = '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">';
                if (Auth::User()->can("Update-Craft")) {
                    $data .= '<a class="dropdown-item" id="editSubscription"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal"data-bs-target="#show_edit_subscription_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>';
                }
                if (Auth::user()->can('Delete-Craft')) {
                    $data .= '<a id="deleteSubscription" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a>';
                }
                $data .= '</div></div>';
                return $data;
            })
            ->make('true');
    }

    public function getproofForBuilding($id)
    {
        $data = ProofOfCase::query()->whereBuilding_id($id);
        return DataTables::eloquent($data)->addIndexColumn()
            ->editColumn('user_id', function ($row) {
                return $row->user->name;
            })
            ->editColumn('day', function ($row) {
                return $row->Days;
            })
            ->addColumn('action', function ($row) {
                $data = '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">';
                if (Auth::user()->can('Update-ProofOfCase')) {
                    $data .= '<a class="dropdown-item" id="editRowProof"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_edit_ProofOfCase_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>';
                }
                if (Auth::user()->can('Delete-ProofOfCase')) {
                    $data .= '<a id="deleteRowProof" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a>';
                }
                $data .= '</div></div>';
                return $data;
            })
            ->make('true');
    }

    public function exportExcel(Request $request)
    {
        $buildings = Building::Filter($request->query())->orderByDesc('id')->get();
//        return \response()->json($data);

        $spreadsheet = new Spreadsheet();

        // Add header row
        $spreadsheet->getActiveSheet()->fromArray(['رقم الملف', 'رقم المبنى', 'رقم الشارع', 'رقم القطعة', 'رقم القسيمة', 'المالك الرئيسي', 'رقم المكلف', 'رقم الهوية', 'رقم الجوال'], null, 'A1');

        // Add data rows
        $dataRows = [];
        foreach ($buildings as $key => $building) {
            $owner = $building->owners->pluck('FullName')->implode(', ');
            $mokalaf = $building->owners->pluck('mokalaf')->implode(', ');
            $id_card = $building->owners->pluck('id_card')->implode(', ');
            $phone_number = $building->owners->pluck('phone_number')->implode(', ');

            $street = $building->street->street_number;

            $dataRows[] = [$building->file_number, $building->building_number, $street, $building->block_number, $building->parcel_number, $owner, $mokalaf, $id_card, $phone_number];
        }

        $spreadsheet->getActiveSheet()->fromArray($dataRows, null, 'A2');

        $writer = new Xlsx($spreadsheet);

        $file_excel = time() . rand(1, 500) . '.xlsx';
        $writer->save($file_excel);

        return response()->json(['url' => $file_excel], Response::HTTP_OK);

        exit();
    }

    //return subzone for zone to selected.
    public function fetchSubZone(Request $request)
    {
        $data['subzones'] = SubZone::where("zone_id", $request->zone_id)->get();
        return response()->json($data);
    }

    public function changeImage(Request $request)
    {
        $building_id = $request->input('building_id');

        if ($request->hasFile('buildingImage')) {

            $file = $request->file('buildingImage');
            $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('building/images/'), $filename);

            $building = Building::where('id',$building_id)->first();
            $building -> image = url('/building/images') . '/' . $filename;
            $building->save();

        }
        return response()->json(['url' => $building -> image], Response::HTTP_OK);

    }


}
