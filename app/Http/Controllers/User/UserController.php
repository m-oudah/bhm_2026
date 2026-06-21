<?php

namespace App\Http\Controllers\User;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Trait\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use ImageTrait;
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(UserDataTable $datatable)
    {
        $roles = Role::whereGuard_name('web')->get();
        return $datatable->render('user.index', ['roles' => $roles]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $role = Role::findById($request->input('role_id'), 'web');

        $isCreate = User::create($request->only(['name', 'email', 'password', 'username']));

        if ($isCreate)
            $isCreate->assignRole($role);
    }

    public function show(User $user)
    {
        //
    }

    public function edit($id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function update(Request $request, User $user)
    {
        $user = User::findOrFail($request->id);
        $role = Role::findById($request->input('role_id'), 'web');

        if ($request->update) {
            $isUpdate = $user->update($request->only(['password']));
        }

        $isUpdate = $user->update($request->only(['name', 'email', 'username']));

        if ($isUpdate)
            $user->syncRoles($role);
    }

    public function destroy(User $user)
    {
        $isDelete = $user->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function getProfile()
    {
        return response()->view('user.profile');
    }
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        if ($request->password) {
            $isUpdate = $user->update($request->only(['password']));
        }
        if ($request->hasFile('user_Photo') && request('user_Photo') != null) {
            $isUpdate = $user->update([
                'photo' => url('/images/uploads/user_Photo/') . '/' . $this->SaveImage($request->file('user_Photo'), 'images/uploads/user_Photo/'),
            ]);
        }

        $isUpdate = $user->update($request->only(['name', 'email', 'username']));
    }
}
