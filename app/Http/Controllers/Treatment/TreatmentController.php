<?php

namespace App\Http\Controllers\Treatment;

use App\DataTables\TreatmentDataTable;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Treatment;
use App\Models\TreatmentNameAttachment;
use App\Models\TreatmentUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TreatmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(TreatmentDataTable $datatable)
    {
        $department = Department::get(['id', 'name']);
        $user = User::get(['id', 'name']);
        $treatmentNameAttchment = TreatmentNameAttachment::get(['id', 'name']);
        return $datatable->render('pens.treatments.index', ['departments' => $department, 'users' => $user, 'treatmentNameAttchment' => $treatmentNameAttchment]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
//         return response()->json($request->all());
        $treatment = Treatment::create($request->except(['treatment_name_attachment']));
        if($request->treatment_name_attachment){
            $main_attachment = $request->input('treatment_name_attachment');
            foreach ($main_attachment as $item){
                $treatment->main_attachment()->attach($item);
            }
        }
//        if ($request->input('users')) {
//            $user = $request->input('users');
//            foreach ($user as $item) {
//                $treatment->users()->attach($item);
//            }
//        }
    }


    public function show(Treatment $treatment)
    {
        //
    }

    public function edit($id)
    {
        return Treatment::find($id);
        $treatment = Treatment::with('users')->whereId($treatment->id)->first();
        $department = Department::get(['id', 'name']);
        $user = User::get(['id', 'name']);

        // return response()->json($treatment);

        return response()->view('pens.treatments.edit', ['treatment' => $treatment, 'users' => $user, 'departments' => $department]);


        // $treatment = Treatment::with('users')->findOrFail($id);
        // $data = [];
        // $data['all_users'] =  User::all();
        // $data['treatment'] = $treatment;
        // $data['existing_users'] = Treatment::with(['users:id, name'])->get();
        // return $data;
        // ====
        // return Treatment::with('users')->findOrFail($id);
    }

    public function update(Request $request, Treatment $treatment)
    {
        // return response()->json($request->all());
        $isUpdate = $treatment->update($request->all());

//        if ($request->input('users')) {
//            $user = $request->input('users');
//            foreach ($user as $item) {
//                $treatment->users()->attach($item);
//            }
//        }
    }

    public function destroy(Treatment $treatment)
    {
        $isDelete = $treatment->delete();
        return response()->json([
            'icon' => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }


    public function getOpenTreatmentForClient()
    {
        $treatments = Treatment::query()->with(['users', 'customerPens'])->orderByDesc('id')->paginate('5');
        return response()->json($treatments);
        // ====================
        $userList = [];
        $customerPensList = [];
        foreach ($treatments as $treatment) {
            foreach ($treatment->users as $user) {
                $userList[] = $user->id;
            }
            foreach ($treatment->customerPens as $customer) {
                $customerPensList[] = $customer->id;
            }
        }
        // return $userList;
        // return $customerPensList;
        // ====================

        $data = $treatments->whereIn('id', $customerPensList)->get();

        return response()->json($data);

        // ====================
        return DataTables::eloquent($data)->addIndexColumn()
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })

            // ->editColumn('customer_id', function ($row) {
            //     return $row->customer->name;
            // })
            ->addColumn('action', function ($row) {
                return '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">

            <a class="dropdown-item" id="editRow"  data-id="' . $row->id . '" href="javascript:;"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>

            <a id="deleteRowEconomical" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a></div></div>';
            })
            ->make('true');
    }
}
