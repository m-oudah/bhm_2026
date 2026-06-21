<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use App\Models\FloorDescription;
use App\Models\DevelopmentData;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FloorDescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
//         return response()->json($request->all());

        $request->merge([
            'lic_fees' => $request->input('licensed_area') * $request->input('lic_per_meter'),
        ]);
        $request->merge([
            'lic_fees_disc_val' => $request->lic_fees * $request->lic_fees_discount / 100
        ]);

        $request->merge([
            'required_pay' => $request->lic_fees - $request->lic_fees_disc_val
        ]);

        $request->merge([
            'notes' => $request->floors_notes
        ]);

        $data = $request->only(['building_id', 'floor_number', 'area', 'licensed_area', 'lic_fees', 'lic_fees_discount', 'lic_per_meter', 'lic_number', 'is_licensed', 'notes', 'lic_fees_disc_val', 'license_fees', 'required_pay', 'license_form_id', 'area_before']);
        $isCreate = FloorDescription::create($data);


        if ($request->floor_number == '0') {
            //totle_fees devlopments
            $request->merge([
                'totle_fees' => $request->input('dev_buliding_area') * $request->input('dev_price_per_meter')
            ]);
            $request->merge([
                'discount_val' => $request->totle_fees * $request->input('discount') / 100
            ]);
            $request->merge([
                'required_pay' => $request->input('totle_fees') - $request->input('discount_val')
            ]);

            $isCreate->devlopments()->create($request->only(['dev_price_per_meter', 'discount', 'pay_fees', 'totle_fees', 'discount_val', 'required_pay', 'dev_notes']));
        }
        if ($request->floor_number == '100') {
            //totle_fees devlopments
            $request->merge([
                'totle_fees' => $request->input('dev_buliding_area') * $request->input('dev_price_per_meter')
            ]);
            $request->merge([
                'discount_val' => $request->totle_fees * $request->input('discount') / 100
            ]);
            $request->merge([
                'required_pay' => $request->input('totle_fees') - $request->input('discount_val')
            ]);

            $isCreate->devlopments()->create($request->only(['dev_price_per_meter', 'discount', 'pay_fees', 'totle_fees', 'discount_val', 'required_pay', 'dev_notes']));
        }

        if ($isCreate)
            return response()->json(['message' => $isCreate ? 'تم الحفظ' : 'هناك خطأ ما'], $isCreate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function show(FloorDescription $floorDescription)
    {
        //
    }

    public function edit($id)
    {
        return FloorDescription::with('devlopments')->findOrFail($id);
    }

    public function update(Request $request)
    {
//        return response()->json($request->all());
        $floorDescription = FloorDescription::findOrFail($request->id);
//         return response()->json($floorDescription);

        $request->merge([
            'lic_fees' => $request->input('licensed_area') * $request->input('lic_per_meter'),
        ]);
        $request->merge([
            'lic_fees_disc_val' => $request->lic_fees * $request->lic_fees_discount / 100
        ]);
        $request->merge([
            'notes' => $request->floors_notes
        ]);
        $request->merge([
            'required_pay' => $request->lic_fees - $request->lic_fees_disc_val
        ]);

        $data = $request->only(['floor_number', 'area', 'licensed_area', 'lic_fees', 'lic_fees_discount', 'lic_per_meter', 'lic_number', 'is_licensed','notes', 'lic_fees_disc_val', 'license_fees', 'license_form_id', 'area_before', 'required_pay']);
        $isUpdate = $floorDescription->update($data);

        if ($request->floor_number == '0' || $request->floor_number == '100') {
            // $request->merge([
            //     'totle_fees' => $request->input('dev_buliding_area') * $request->input('dev_price_per_meter')
            // ]);
            // $request->merge([
            //     'discount_val' => $request->totle_fees * $request->input('discount') / 100
            // ]);
            // $request->merge([
            //     'required_pay' => $request->input('totle_fees') - $request->input('discount_val')
            // ]);

            $dev = DevelopmentData::where('floor_description_id',$floorDescription->id)->first();
            if($dev)
            {
                $dev -> dev_price_per_meter = $request -> dev_price_per_meter;
                $dev -> discount = $request -> discount;
                $dev -> pay_fees = $request -> pay_fees;
                $dev -> totle_fees = $request->input('e_dev_totle_fees');
                $dev -> discount_val = $request->e_dev_discount_val;
                $dev -> required_pay =$request->input('e_dev_required_pay') ;
                $dev -> dev_notes = $request -> e_dev_notes;
                $dev -> save();
    
            }
            else
            {
                $dev = new DevelopmentData();
                $dev -> dev_price_per_meter = $request -> dev_price_per_meter;
                $dev -> discount = $request -> discount;
                $dev -> pay_fees = $request -> pay_fees;
                $dev -> totle_fees = $request->input('e_dev_totle_fees');
                $dev -> discount_val = $request->e_dev_discount_val;
                $dev -> required_pay =$request->input('e_dev_required_pay') ;
                $dev -> dev_notes = $request -> e_dev_notes;
                $dev -> floor_description_id = $floorDescription->id;

                $dev -> save();

            }
            
            // $floorDescription->devlopments()->update($request->only(['dev_price_per_meter', 'discount', 'pay_fees', 'totle_fees', 'discount_val', 'required_pay', 'dev_notes']));
            
        }

        if ($isUpdate)
            return response()->json(['message' => $isUpdate ? 'تم الحفظ' : 'هناك خطأ ما'], $isUpdate ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    public function destroy(FloorDescription $floorDescription)
    {
        $isDelete = $floorDescription->delete();
        DevelopmentData::where('floor_description_id',$isDelete->id)->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
