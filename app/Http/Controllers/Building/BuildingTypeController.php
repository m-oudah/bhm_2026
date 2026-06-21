<?php

namespace App\Http\Controllers\Building;

use App\DataTables\BuildingTypeDataTable;
use App\Http\Controllers\Controller;
use App\Models\BuildingType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BuildingTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(BuildingTypeDataTable $dataTable)
    {
        return $dataTable->render('building_types.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $isCreate = BuildingType::create($request->only(['name']));
        if ($isCreate)
            return response()->json(['message' => $isCreate ? __('Saved successfully') : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BuildingType  $buildingType
     * @return \Illuminate\Http\Response
     */
    public function show(BuildingType $buildingType)
    {
        //
    }

    public function edit($id)
    {
        return BuildingType::findOrFail($id);
    }

    public function update(Request $request)
    {
        $street = buildingType::findOrFail($request->id);
        $isUpdate = $street->update($request->only(['name']));
        if ($isUpdate)
            return response()->json(['message' => $isUpdate ? __('Saved successfully') : 'هناك خطأ ما'], $isUpdate ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BuildingType  $buildingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BuildingType $buildingType)
    {
        $isDelete = $buildingType->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
