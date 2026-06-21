<?php

namespace App\Http\Controllers\Role;

use App\DataTables\RoleDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
        // $this->authorizeResource(Role::class, 'role');
    }

    public function index(RoleDataTable $datatable)
    {
        return $datatable->render('role.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->merge([
            'guard_name' =>  'web'
        ]);

        $data = $request->only(['name', 'guard_name']);

        $isSave = Role::create($data);
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function show(Role $role)
    {
        $permissions = Permission::whereGuard_name('web')->whereNull('parent_id')->get();
        $role = $role::whereId($role->id)->with('permissions')->first();

        return response()->view('role.role-permissions', ['role' => $role, 'permissions' => $permissions]);
    }

    public function edit($id)
    {
        return Role::findOrFail($id);
    }

    public function update(Request $request)
    {
        $role = Role::findOrFail($request->id);
        $isSave = $role->update($request->only(['name']));
        if ($isSave)
            return response()->json(['message' => $isSave ? 'تم الحفظ' : 'هناك خطأ ما'], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function destroy(Role $role)
    {
        $isDelete = $role->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
