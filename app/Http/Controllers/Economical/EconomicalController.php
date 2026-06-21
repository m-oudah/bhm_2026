<?php

namespace App\Http\Controllers\Economical;

use App\DataTables\EconomicalDataTable;
use App\Http\Controllers\Controller;
use App\Models\Economical;
use App\Models\BuildingOwner;
use App\Models\Building;
use App\Models\Street;
use App\Models\Unit;
use App\Models\CraftType;
use App\Models\CraftAttachment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function Termwind\render;

class EconomicalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    public function index(EconomicalDataTable $datatable)
    {
        // $owners = BuildingOwner::with('building')->with('building.units')->orderBy('first_name','ASC')->get();
        $data = [];
        $data['all'] = Economical::where('municipality_id',NULL)->count();
        $data['licenced'] = Economical::where('municipality_id',NULL)->where('craft_number','<>','0')->where('craft_number','<>','NULL')->count();
        // $data['licenced'] += Economical::where('municipality_id',NULL)where('craft_number','<>',0)->count();
        $data['not_licenced'] = Economical::where('municipality_id',NULL)->where('craft_number',0)->count();
        $data['not_licenced'] += Economical::where('municipality_id',NULL)->where('craft_number',NULL)->count();

        $data['not_approved'] = Economical::where('municipality_id',NULL)->where('approved',NULL)->count();
        $data['closed'] = Economical::where('municipality_id',NULL)->where('isActive',1)->count();
        return $datatable->render('economical.index',compact('data'));
    }

    public function printFrom(Request $request)
    {
        return view('economical.print_form',compact('request'));
    }
    public function fetchBuilding($street,$building)
    {
        $street = Street::where('street_number',$street)->first()->id;
        $building = Building::where('street_id',$street)->where('building_number',$building)->first();
        $owner = BuildingOwner::where('building_id',$building->id)->first();
        $units = Unit::where('building_id',$building->id)->get();
        $building['owner'] = $owner;
        $building['units'] = $units;
        return response()->json([
            'body'  =>  $building ,
        ], $building ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $unitExist = Economical::where('unit_id',$request->unit_id)->first();
        if(!$unitExist)
        {
        $isCreate = Economical::create($request
        ->only(['creation_date',
        'created_by',
        'bulding_id',
        'type_property',
        'job_formal_name', 
        'notes', 
        'building_owner_id', 
        'unit_id','isDanger',
        'craft_category_id',
        'isActive',
        'craft_number'
        ]));
        $isCreate->owners()->create([
            'first_name'    => $request->input('first_name'),
            'second_name'   => $request->input('second_name'),
            'third_name'    => $request->input('third_name'),
            'sur_name'      => $request->input('sur_name'),
            'id_card'       => $request->input('id_card'),
            'phone_number'  => $request->input('phone_number'),
            'mokalaf'  => $request->input('mokalaf'),


        ]);
        return response()->json([
            'status'=>true,
            'message' => 'تم الحفظ',
        
        ],200);
    }
    else
    {
        return response()->json([
            'status'=>false,
            'message' => ' الوحدة مشعولة بحرفة قديمة باسم: ' . $unitExist->job_formal_name ,
        
        ],500);

    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Economical  $economical
     * @return \Illuminate\Http\Response
     */
    public function show(Economical $economical)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Economical  $economical
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Economical::with('owners')->findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Economical  $economical
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $economical = Economical::findOrFail($request->id);
        $isCreate = $economical->update($request->only(['bulding_id', 'type_property', 'job_formal_name', 'notes', 'building_owner_id', 'unit_id','craft_number']));
        $economical->owners()->update([
            'first_name'    => $request->input('first_name'),
            'second_name'   => $request->input('second_name'),
            'third_name'    => $request->input('third_name'),
            'sur_name'      => $request->input('sur_name'),
            'id_card'       => $request->input('id_card'),
            'phone_number'  => $request->input('phone_number'),
            'mokalaf'  => $request->input('mokalaf')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Economical  $economical
     * @return \Illuminate\Http\Response
     */
    public function destroy(Economical $economical)
    {
        $isDelete = $economical->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
    public function getTypes($id)
    {
        $types = CraftType::where('category_id',$id)->get();
        $attchments = CraftAttachment::where('category_id',$id)->get();

        return response()->json([
            'data' =>  $types,
            'attachments' =>  $attchments,

        ], 200);
        
    }
}
