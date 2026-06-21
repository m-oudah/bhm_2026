<?php

namespace App\DataTables;

use App\Models\Building;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class BuildingDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()->eloquent($query)->addIndexColumn()
            ->editColumn('file_number', function ($row) {
                return $row->file_number ? '<a href="' . route('buildings.show', $row->id) . '">' . $row->file_number . '</a>' : '<a href="' . route('buildings.show', $row->id) . '">غير محدث</a>';
            })
            ->editColumn('street_id', function ($row) {
                return $row->street_id ? $row->street->street_number : null;
            })

//            ->editColumn('zone_id', function ($row) {
//                return $row->zone_id ? $row->zone->zone_number : null;
//            })
//            ->editColumn('subzone_id', function ($row) {
//                return $row->subzone_id ? $row->subzone->zone_number : null;
//            })
            ->editColumn('building_type', function ($row) {
                return $row->building_type ? $row->type->name : null;
            })
            ->addColumn('ownerMain', function ($row) {
                foreach ($row->owners as $owner) {
                    $data =  $owner->wherebuilding_id($row->id)->first();
                    return $data->FullName;
                }
            })

            ->addColumn('action', function ($row) {
                $data = '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">';
                if (Auth::User()->can("Show-Building")) {
                    $data .= '<a class="dropdown-item" id="editRow"  data-id="' . $row->id . '" href="' . route('buildings.show', $row->id) . '"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>';
                }
                if (Auth::User()->can("Read-Owners")) {
                    $data .= '<a class="dropdown-item" id="showRow"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_owner_model" ><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Show Owners') . '</span></a>';
                }

                if (Auth::User()->can("Read-Units")) {
                    $data .= '<a class="dropdown-item" id="show_unit"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_unit_model" ><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Show Units') . '</span></a>';
                }
                if (Auth::User()->can("Read-Floors")) {
                    $data .= '<a class="dropdown-item" id="show_floor"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_floor_model" ><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Show Floors') . '</span></a>';
                }
                if (Auth::User()->can("Read-Crafts")) {
                    $data .= '<a class="dropdown-item" id="show_craft"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_craft_model" ><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Show Crafts') . '</span></a>';
                }
                if (Auth::User()->can("Read-Subscriptions")) {
                    $data .= '<a class="dropdown-item" id="show_subscription"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_subscription_model" ><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Show Subscriptions') . '</span></a>';
                }
                if (Auth::User()->can("Delete-Building")) {
                    $data .= '<a id="deleteBuilding" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a>
                    ';
                }

                $data .= '</div></div>';
                return $data;
            })->rawColumns(['file_number', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Building $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Request $request): QueryBuilder
    {
        return Building::Filter($request->query())->orderByDesc('id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('building-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'language' => [
                    'url' => "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                ],
            ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            ['title' => '#', 'name' => 'DT_RowIndex', 'data' =>   'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => __('File Number'), 'name' => 'file_number', 'data' => 'file_number', 'orderable' => false],
            ['title' => 'المالك الرئيسي', 'data' => 'ownerMain', 'orderable' => false],
            ['title' => __('Building Number'), 'name' => 'building_number', 'data' => 'building_number', 'orderable' => false],
            ['title' => __('Block Number'), 'name' => 'block_number', 'data' => 'block_number', 'orderable' => false],
            ['title' => __('Street Number'), 'name' => 'street_id', 'data' => 'street_id', 'orderable' => false],
//            ['title' => __('Zone'), 'name' => 'zone_id', 'data' => 'zone_id', 'orderable' => false],
//            ['title' => __('Sub Zone'), 'name' => 'subzone_id', 'data' => 'subzone_id', 'orderable' => false],
            ['title' => __('building name'), 'name' => 'building_name', 'data' => 'building_name', 'orderable' => false],
            ['title' => __('Type'), 'name' => 'building_type', 'data' => 'building_type', 'orderable' => false],
            ['title' => __('Control'), 'name' => 'action', 'data' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Building_' . date('YmdHis');
    }
}
