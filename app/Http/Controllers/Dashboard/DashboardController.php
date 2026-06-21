<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\LicenseForm;
use App\Models\Attachment;
use App\Models\CraftCategory;
use App\Models\CraftType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    public function list()
    {
        $list = Attachment::select(DB::raw('count(*) as count, category,building_id'))
        ->groupBy(['category','building_id'])
        // ->groupBy('building_id')
        // ->where('count','>',1)
        ->get();
      return $list;
    }
    public function index()
    {
        $building_count1 = Building::count();

        // مباني غير مرخصة
        $building_count2 = Building::whereNull('file_number')->count();

        //        مباني مرخصة وغير مستوفية الرسوم
        $building_count3 = Building::whereNotNull('file_number')->whereHas('floors', function ($q) {
            $q->whereRaw('required_pay - license_fees > 0');
        })->count();

        // مباني مرخصة ومتبقي طوابق غير مرخصة
        $building_count4 = Building::whereNotNull('file_number')->whereHas('floors', function ($q) {
            $q->where('is_licensed', '3');
        })->count();

//  مباني مرخصة  مستوفية الرسوم
        $building_count5 = Building::whereNotNull('file_number')->whereHas('floors', function ($q) {
            $q->whereRaw('required_pay - license_fees = 0');
        })->count();

        $licenseForm = LicenseForm::with(['owner'])->orderByDesc('id')->where('status',0)->paginate(10);

        if(Auth::id() == 14)
        {
            $licenseForm = LicenseForm::where('area_opinion',NULL)->with(['owner'])->orderByDesc('id')->paginate(10);
        }
        if(Auth::id() == 9)
        {
            $licenseForm = LicenseForm::where('legal_opinion',NULL)->with(['owner'])->orderByDesc('id')->paginate(10);
        }
        if(Auth::id() == 16)
        {
            $licenseForm = LicenseForm::where('plan_opinion',NULL)->with(['owner'])->orderByDesc('id')->paginate(10);
        }
        if(Auth::id() == 15)
        {
            $licenseForm = LicenseForm::where('water_opinion',NULL)->orWhere('sewer_opinion',NULL)->with(['owner'])->orderByDesc('id')->paginate(10);
        }
        if(Auth::id() == 17)
        {
            $licenseForm = LicenseForm::where('gis_opinion',NULL)->with(['owner'])->orderByDesc('id')->paginate(10);
        }
        if(Auth::id() == 18)
        {
            $licenseForm = LicenseForm::where('collection_opinion',NULL)->with(['owner'])->orderByDesc('id')->paginate(10);
        }



        // foreach($licenseForm as $form)
        // {
        //     $item = LicenseFormReply::where('')
        // }

//         return response()->json($licenseForm);
        return response()->view('dashboard.index', [
            'building_count1' => $building_count1,
            'building_count2' => $building_count2, 'building_count3' => $building_count3,
            'building_count4' => $building_count4, 'building_count5' => $building_count5,
            'licenseForm'=>$licenseForm
        ]);
    }

    public function crafts()
    {
        $categories = CraftCategory::all();
        return view('crafts',compact('categories'));
    }

    public function craftsStore(Request $request)
    {
        $item = new CraftType();
        $item -> name = $request -> name;
        $item -> category_id = $request -> category_id;
        $item -> save();
        return redirect()->back()->with('success', 'تم اضافة الحرفة بنجاح');   
    }
}
