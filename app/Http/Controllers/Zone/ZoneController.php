<?php

namespace App\Http\Controllers\Zone;

use App\DataTables\ZoneDataTable;
use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(ZoneDataTable $dataTable)
    {
        return $dataTable->render('zones.index');
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $isCreate = Zone::create($request->only(['zone_number', 'zone_id']));
        if ($isCreate)
            return response()->json(['message' => $isCreate ? __('Saved successfully') : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }


    public function show(Zone $zone)
    {
        //
    }

    public function edit($id)
    {
        return Zone::findOrFail($id);
    }

    public function update(Request $request)
    {
        $zone = Zone::findOrFail($request->id);

        $isCreate = $zone->update($request->only(['zone_number', 'zone_name']));
        if ($isCreate)
            return response()->json(['message' => $isCreate ? __('Saved successfully') : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }


    public function destroy(Zone $zone)
    {
        $isDelete = $zone->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
