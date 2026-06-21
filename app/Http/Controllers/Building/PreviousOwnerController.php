<?php

namespace App\Http\Controllers\Building;

use App\Http\Controllers\Controller;
use App\Models\PreviousOwner;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PreviousOwnerController extends Controller
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
        //
    }

    public function show(PreviousOwner $previousOwner)
    {
        //
    }

    public function edit(PreviousOwner $previousOwner)
    {
        //
    }

    public function update(Request $request, PreviousOwner $previousOwner)
    {
        //
    }

    public function destroy(PreviousOwner $previousOwner)
    {
        //
    }

    public function getPreviousOwnerForBuilding($id)
    {
        $data = PreviousOwner::query()->whereBuilding_id($id);
        return DataTables::eloquent($data)->addIndexColumn()
            ->addColumn('fullName', function ($row) {
                return $row->FullName;
            })->make('true');
    }
}
