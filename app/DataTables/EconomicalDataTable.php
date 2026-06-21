<?php

namespace App\DataTables;

use App\Models\Economical;
use App\Models\Street;
use App\Models\Building;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EconomicalDataTable extends DataTable
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
            ->addColumn('sector', function ($row) {
                $building = Building::where('id',$row->bulding_id)->with('street')->first();
                if($building)
                    return  $building->street->street_number . '/' . $building->building_number . '/' . $row->unit->unit_number ;
                else
                    return $row->job_formal_name;
            })
            ->addColumn('owner_name', function ($row) {
                return $row->owners ? $row->owners->Full_Name : '';
            })
            ->addColumn('id_card', function ($row) {
                return $row->owners ? $row->owners->id_card : '';
            })
            ->addColumn('phone_number', function ($row) {
                return $row->owners ? $row->owners->phone_number : '';
            })
            ->editColumn('mokalaf', function ($row) {
                return $row->owners ? $row->owners->mokalaf : '';
            })
            // ->editColumn('mokalaf', function ($row) {
            //     return $row->owners ? $row->owners->mokalaf : '';
            // })
            ->addColumn('action', function ($row) {
                $data = '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">';
                if (Auth::User()->can("Update-Craft")) {
                    $data .= '<a class="dropdown-item" id="editRowCraft"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_edit_craft_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>';
                }
                if (Auth::user()->can('Delete-Craft')) {
                    $data .= '<a id="deleteRowEconomical" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a>';
                }
                $data .= '<a id="#" class="dropdown-item" href="' . route('buildings.show', $row->bulding_id) . '"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>عرض المبنى</span></a>';
                $data .= '<a id="#" class="dropdown-item" href="#" onclick="printLicence()"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>طباعة الرخصة</span></a>';
                $data .= '</div></div>';

                return $data;
            })

            ->rawColumns(['photo_id', 'is_active', 'action','sector','job_formal_name','owner_name','id_card','mokalaf']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Economical $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Economical $model): QueryBuilder
    {
         return $model->newQuery()->where('municipality_id',NULL)->orderByDesc('id');
        // return $model->newQuery()->orderByDesc('id');

    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('economical-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->parameters([
                'language' => [
                    'url' => "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                ],
            ]);;
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            ['title' => '#', 'data' =>   'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => 'رقم الملف', 'data' => 'craft_number', 'orderable' => false,'searchable' => false],
            ['title' => 'رقم المكلف', 'data' => 'mokalaf', 'orderable' => false,'searchable' => false],
            ['title' => 'الاسم التجاري الرسمي للحرفة', 'data' => 'job_formal_name', 'orderable' => false,'searchable' => true],
            ['title' => 'الموقع', 'data' => 'sector', 'orderable' => false,'searchable' => false],
            ['title' => 'المالك', 'data' => 'owner_name', 'orderable' => false,'searchable' => true],
            ['title' => 'رقم الهوية', 'data' => 'id_card', 'orderable' => false,'searchable' => true],
            ['title' => 'رقم الاتصال', 'data' => 'phone_number', 'orderable' => false],
            ['title' => 'حالة الحرفة', 'data' => 'type_property', 'orderable' => false],
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
        return 'Economical_' . date('YmdHis');
    }
}
