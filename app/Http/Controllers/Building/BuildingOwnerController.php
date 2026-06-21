<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use App\Models\BuildingOwner;
use App\Models\BuildingOwnerUnit;
use App\Models\Unit;
use App\Models\PreviousOwner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BuildingOwnerController extends Controller
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

    public function storeOwnerNew(Request $request)
    {
        $validated = $request->validate([
            'building_id' => ['required'],
            'first_name' => ['required', 'string'],
            'second_name' => ['required', 'string'],
            'sur_name' => ['required', 'string'],
            'id_card' => ['required', 'numeric'],
            'phone_number' => ['required']
        ]);

        $isSave = BuildingOwner::create($request->only(['building_id', 'first_name', 'second_name', 'third_name', 'sur_name', 'id_card', 'phone_number', 'notes','mokalaf']));
        return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

    }

    public function store(Request $request)
    {
        if ($request->current_owner) {

            if ($request->current_owner == 'new') {
                $validated = $request->validate([
                    'building_id' => ['required'],
                    'first_name' => ['required', 'string'],
                    'second_name' => ['required', 'string'],
                    'sur_name' => ['required', 'string'],
                    'id_card' => ['required', 'numeric'],
                    'phone_number' => ['required']
                ]);
                $dataOwnerNew = $request->only(['building_id', 'first_name', 'second_name', 'third_name', 'sur_name', 'id_card', 'phone_number', 'notes']);
                $saveOwnerNew = BuildingOwner::create($dataOwnerNew);
                $owner_new = BuildingOwner::whereId($saveOwnerNew->id)->first();
            } else {
                $owner_new = BuildingOwner::whereId($request->current_owner)->first();
            }

//            return \response()->json($request->units_transfer);

            //transfer units
            $units_transfer = $request->input('units_transfer');
            $units = Unit::whereIn('id', $units_transfer)->get();
//            return \response()->json($units);

            foreach ($units as $unit) {
                BuildingOwnerUnit::whereUnit_id($unit->id)->delete();
            }

            foreach ($units as $unit) {
//                $unit->building_owner_id = $owner_new->id;
//                $isSave = $unit->save();
                $isNew = new BuildingOwnerUnit();
                $isNew->building_owner_id = $owner_new->id;
                $isNew->unit_id = $unit->id;
                $isNew->save();
            }

            $user_current = BuildingOwner::whereId($request->user_current)->withCount('units')->first();
            // return response()->json($user_current);
            if ($user_current->units_count == '0') {
                $previousOwner = new PreviousOwner();
                $previousOwner->building_id = $user_current->building_id;
                $previousOwner->id_card = $user_current->id_card;
                $previousOwner->mokalaf = $user_current->mokalaf;
                $previousOwner->phone_number = $user_current->phone_number;
                $previousOwner->first_name = $user_current->first_name;
                $previousOwner->second_name = $user_current->second_name;
                $previousOwner->third_name = $user_current->third_name;
                $previousOwner->sur_name = $user_current->sur_name;
                $previousOwner->notes = $user_current->notes;
                $previousOwner->save();

                $user_current->delete();
            }
        }

    }


    public function show(BuildingOwner $buildingOwner)
    {
        //
    }

    public function edit($id)
    {
        return BuildingOwner::with('units')->findOrFail($id);
    }

    public function update(Request $request)
    {
        $buildingOwner = BuildingOwner::findOrFail($request->id);
        $isUpdate = $buildingOwner->update($request->only(['first_name', 'second_name', 'third_name', 'sur_name', 'id_card', 'phone_number', 'mokalaf', 'notes']));
        if ($isUpdate)
            return response()->json(['message' => $isUpdate ? __('Saved successfully') : 'هناك خطأ ما'], $isUpdate ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function destroy(BuildingOwner $buildingOwner)
    {
        $isDelete = $buildingOwner->delete();
        return response()->json([
            'icon' => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
