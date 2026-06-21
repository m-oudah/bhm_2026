<?php

namespace App\Http\Controllers\Customer;

use App\DataTables\SubscriptionDataTable;
use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index(SubscriptionDataTable $dataTable)
    {
        return $dataTable->render('subscriptions.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $isCreate = Subscription::create($request->only(['building_id', 'owner_id', 'type', 'subscription_number']));
        $isCreate->units()->attach($request->input('units'));
    }

    public function show(Subscription $subscription)
    {
        //
    }

    public function edit($id)
    {
        return Subscription::with(['owner'])->find($id);
    }

    public function update(Request $request)
    {
        $subscription = Subscription::find($request->id);
        $subscription->update($request->only(['owner_id', 'type', 'subscription_number']));
        $subscription->units()->sync($request->input('units'));
    }

    public function destroy(Subscription $subscription)
    {
        $isDelete = $subscription->delete();
        return response()->json([
            'icon' => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
