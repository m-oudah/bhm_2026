<?php

namespace App\Http\Controllers\Department;

use App\DataTables\DepartmentDataTable;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(DepartmentDataTable $datatable)
    {
        return $datatable->render('pens.departments.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Department::create($request->all());
    }

    public function show(Department $department)
    {
        //
    }

    public function edit($id)
    {
        return Department::findOrFail($id);
    }

    public function update(Request $request)
    {
        $department =  Department::findOrFail($request->id);
        $department->update($request->all());
    }

    public function destroy(Department $department)
    {
        $isDelete = $department->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
