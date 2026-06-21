<?php

namespace App\Http\Controllers\CustomerPenTreatment;

use App\DataTables\CustomerPenTreatmentDataTable;
use App\Http\Controllers\Controller;
use App\Models\CustomerPen;
use App\Models\CustomerPenTreatment;
use App\Models\Treatment;
use App\Models\TreatmentNameAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerPenTreatmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(CustomerPenTreatmentDataTable $datatable)
    {
        $customer = CustomerPen::orderByDesc('id')->get();
        $treatment = Treatment::orderByDesc('id')->get();
        return $datatable->render('pens.customer_pen_treatment.index', ['customers' => $customer, 'treatments' => $treatment]);
    }

    public function create()
    {
//        $customer_pen = CustomerPen::select('id', 'name')->orderByDesc('id')->get();
        $treatment = Treatment::orderByDesc('id')->whereHas('users', function ($quary) {
            $quary->where('user_id', Auth::id());
        })->get(['id', 'name']);
//
//        return response()->json($treatment);
        return response()->view('pens.customer_pen_treatment.create', ['treatments' => $treatment]);
    }

    public function store(Request $request)
    {
        $customer = CustomerPen::where('id_no', $request->id_no)->first();
//        return response()->json($customer);
//        if (!$customer) {
//            $new_customer = CustomerPen::create($request->only(['first_name', 'second_name', 'third_name', 'sur_name', 'mobile', 'id_no']));
//            $request->merge(['customer_id' => $new_customer->id]);
//        } else {
//            $customer->update($request->only(['first_name', 'second_name', 'third_name', 'sur_name', 'mobile']);
//            $request->merge(['customer_id' => $customer->id]);
//        }
//        $isCreate = CustomerPenTreatment::create($request->only(['treatment_id', 'customer_id', 'title', 'description']));
    }

    public function searchIdNum(Request $request)
    {
        $id_no = CustomerPen::where('id_no', $request->id_num)->first();
        return response()->json($id_no);
    }
}
