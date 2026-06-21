<?php

namespace App\Http\Controllers\ProofOfCase;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\ProofOfCase;
use App\Models\TmpFile;
use App\Trait\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mpdf\Tag\P;
use Symfony\Component\HttpFoundation\Response;

class ProofOfCaseController extends Controller
{
    use ImageTrait;
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
    public function UploadAttachment(Request $request)
    {
        if ($request->hasFile('proof_photo')) {
            $items = $request->file('proof_photo');
            foreach ($items as $item) {
                $filename = date('YmdHi') . time() . rand(1, 50) . '.' . $item->getClientOriginalExtension();
                $item->move(public_path('buildings/proof_photo/'), $filename);
                TmpFile::create([
                    'file' => $filename,
                    'extension' => $item->getClientOriginalExtension(),
                ]);
                return $filename;
            }
        }
    }
    public function store(Request $request)
    {
//        return response()->json($request->all());
        $request->merge([
            'user_id' => Auth::id()
        ]);

        $proof = ProofOfCase::create($request->except(['proof_photo']));

        if ($request->proof_photo){
            $items = $request->input('proof_photo');
            $file = TmpFile::whereIn('file',  $items)->get();
            if($file){
                foreach ($file as $value){
                    $deedPhoto = $proof->attachments()->create([
                        'url'     => 'buildings/proof_photo/' . $value->file,
                        'category' => 'إثبات حالة',
                        'extension' => $value->extension,
                        'proof_of_case_id'=>$proof->id
                    ]);
                }
            }
        }
    }

    public function show(ProofOfCase $proofOfCase)
    {
        //
    }

    public function edit($id)
    {
        return ProofOfCase::with(['attachments'])->findOrFail($id);
    }

    public function update(Request $request)
    {
        $proof = ProofOfCase::findOrFail($request->id);
        $proof->update($request->all());
    }

    public function confirm(Request $request)
    {
        $proof = ProofOfCase::findOrFail($request->id);
        if ($proof)
            $proof->update([except(['proof_photo'])]);
    }

    public function destroy(ProofOfCase $proofOfCase)
    {
        $isDelete = $proofOfCase->delete();
        return response()->json([
            'icon'  =>  $isDelete ? 'success' : 'error',
            'title' =>  $isDelete ? 'تم الحذف بنجاح' : 'فشل الحذف',
        ], $isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
