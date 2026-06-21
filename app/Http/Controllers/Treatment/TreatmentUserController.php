<?php

namespace App\Http\Controllers\Treatment;

use App\Http\Controllers\Controller;
use App\Models\TreatmentUser;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TreatmentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        TreatmentUser::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TreatmentUser  $treatmentUser
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = TreatmentUser::with(['user'])->where('treatment_id', $id)->orderByDesc('id')->get();
        $user = User::get(['id', 'name']);
//          return response()->json($data);
        return \response()->view('pens.treatments.editPath', ['treatment' => $data, 'users' => $user, 'treatment_id'=>$id]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TreatmentUser  $treatmentUser
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return TreatmentUser::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TreatmentUser  $treatmentUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $treatmentUser = TreatmentUser::find($request->id);
        $treatmentUser->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TreatmentUser  $treatmentUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(TreatmentUser $treatmentUser)
    {
        $isDelete = $treatmentUser->delete();
        return response()->json([
            'icon' => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
