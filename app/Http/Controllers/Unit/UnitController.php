<?php

namespace App\Http\Controllers\Unit;

use App\DataTables\UnitDataTable;
use App\Http\Controllers\Controller;
use App\Models\BuildingOwner;
use App\Models\Unit;
use App\Models\UnitOwner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(UnitDataTable $dataTable)
    {
        return $dataTable->render('unit.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $isCreate = Unit::create($request->only(['building_id', 'building_owner_id', 'floor_number', 'unit_type', 'unit_number', 'unit_notes']));
        //add data with realation many to many
        $isCreate->owners()->attach($request->input('owners'));

        if ($request->unit_use == '2') {
            $isCreate->uses()->create($request->only(['first_name', 'second_name', 'third_name', 'sur_name', 'id_card', 'phone_number', 'notes']));
        }

        if ($isCreate)
            return response()->json(['message' => $isCreate ? 'تم الحفظ' : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function show(Unit $unit)
    {
        //
    }

    public function edit($id)
    {
        return Unit::with(['uses', 'owners'])->findOrFail($id);
    }

    public function update(Request $request)
    {
        $unit = Unit::findOrFail($request->id);
        $isCreate = $unit->update($request->only(['building_id', 'building_owner_id', 'floor_number', 'unit_type', 'unit_number', 'unit_notes']));
        $unit->owners()->sync($request->input('owners'));

        if ($request->unit_use == '2') {
            $isCreate->uses()->update($request->only(['first_name', 'second_name', 'third_name', 'sur_name', 'id_card', 'phone_number', 'notes']));
        }

        if ($isCreate)
            return response()->json(['message' => $isCreate ? 'تم الحفظ' : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Unit $unit)
    {
        $isDelete = $unit->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
