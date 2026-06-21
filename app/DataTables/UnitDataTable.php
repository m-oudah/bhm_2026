<?php

namespace App\DataTables;

use App\Models\Unit;
use App\Models\User;
use App\Models\Building;
use App\Models\Street;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UnitDataTable extends DataTable
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
            ->editColumn('created_at', function ($row) {
                return $row->created_at;
            })
            ->addColumn('building',function($row){
                $building = Building::where('id',$row->building_id)->with('street')->first();
                if($building)
                    return $building->building_number . '/' . $building->street->street_number;
                else
                    return 'Not Exist';
            })
            ->addColumn('owner',function($row){
                if($row->owner)
                    return $row->owner->first_name??'' . $row->owner->second_name??'' . $row->owner->third_name??'' . $row->owner->sur_name??'';
                else
                    return 'غير معرف';
            })
            ->addColumn('action', function ($row) {
                // return 123;
               return '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">
                   <a class="dropdown-item" id="edit"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#role_edit" >
                       <i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span>
                   </a>
                   <a id="deleteRow" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash me-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg><span>حذف</span></a></div></div>';
            })
            ->rawColumns(['action', 'photo','created_at','building','owner']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Unit $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Unit $model): QueryBuilder
    {
        return Unit::query();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('unit-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                ;
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            ['title' => '#',  'data' =>   'DT_RowIndex', 'orderable' => false, 'searchable' => false],
//            ['title' => __('Name'), 'data' =>   'name', 'orderable' => false],
           ['title' => __('owner'), 'data' =>   'owner', 'orderable' => false],
           ['title' => __('unit number'), 'data' =>   'unit_number', 'orderable' => false],
           ['title' => __('building'), 'data' =>   'building', 'orderable' => false],
           ['title' => __('Created At'), 'data' =>   'created_at', 'orderable' => false],
            ['title' => __('Control'), 'data' => 'action', 'orderable' => false, 'searchable' => false]
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Unit_' . date('YmdHis');
    }
}
