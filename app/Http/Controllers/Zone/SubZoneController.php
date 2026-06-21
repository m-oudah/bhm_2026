<?php

namespace App\Http\Controllers\Zone;

use App\DataTables\SubZoneDataTable;
use App\Http\Controllers\Controller;
use App\Models\SubZone;
use App\Models\Zone;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(SubZoneDataTable $dataTable)
    {
        $zone = Zone::select('id', 'zone_number', 'zone_name')->get();
        return $dataTable->render('sub_zones.index', ['zones' => $zone]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $isCreate = SubZone::create($request->only(['zone_number', 'zone_id']));
        if ($isCreate)
            return response()->json(['message' => $isCreate ? __('Saved successfully') : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function show(SubZone $subZone)
    {
        //
    }

    public function edit($id)
    {
        return SubZone::findOrFail($id);
    }

    public function update(Request $request)
    {
        $zone = SubZone::findOrFail($request->id);

        $isCreate = $zone->update($request->only(['zone_number', 'zone_id']));
        if ($isCreate)
            return response()->json(['message' => $isCreate ? __('Saved successfully') : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }


    public function destroy(SubZone $subZone)
    {
        $isDelete = $subZone->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
