<?php

namespace App\Http\Controllers\CustomerPen;

use App\DataTables\CustomerPenDataTable;
use App\Http\Controllers\Controller;
use App\Models\CustomerPen;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerPenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(CustomerPenDataTable $datatable)
    {
//        foreach (CustomerPen::all() as $item) {
//            $interests = explode(' ', $item->name);
////            return $interests[0];
//
//                $item->first_name = $interests[0];
//                $item->second_name = $interests[1];
//                $item->third_name = $interests[2];
//                $item->sur_name = $interests[3];
//                $item -> save();
////            return $item;
//        }
//        return 'done';

        return $datatable->render('pens.customer_pen.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        CustomerPen::create($request->only(['first_name', 'second_name', 'third_name', 'sur_name', 'id_no', 'telephone', 'address']));
    }

    public function show(CustomerPen $customerPen)
    {
        //
    }

    public function edit($id)
    {
        return CustomerPen::findOrFail($id);
    }

    public function update(Request $request)
    {
        $customerPen = CustomerPen::findOrFail($request->id);
        $customerPen->update($request->only(['first_name', 'second_name', 'third_name', 'sur_name', 'id_no', 'telephone', 'address']));
    }

    public function destroy(CustomerPen $customerPen)
    {
        $isDelete = $customerPen->delete();
        return response()->json([
            'icon' => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
