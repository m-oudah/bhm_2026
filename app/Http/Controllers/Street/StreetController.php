<?php

namespace App\Http\Controllers\Street;

use App\DataTables\StreetDataTable;
use App\Http\Controllers\Controller;
use App\Models\Street;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StreetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(StreetDataTable $dataTable)
    {
        return $dataTable->render('streets.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $isCreate = Street::create($request->only(['street_number', 'street_name']));
        if ($isCreate)
            return response()->json(['message' => $isCreate ? __('Saved successfully') : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function show(Street $street)
    {
        //
    }

    public function edit($id)
    {
        return Street::findOrFail($id);
    }

    public function update(Request $request)
    {
        $street = Street::findOrFail($request->id);
        $isUpdate = $street->update($request->only(['street_number', 'street_name']));
        if ($isUpdate)
            return response()->json(['message' => $isUpdate ? __('Saved successfully') : 'هناك خطأ ما'], $isUpdate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Request $request,Street $street)
    {
        $isDelete = $street->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
