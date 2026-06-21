<?php

namespace App\DataTables;

use App\Models\LicenseForm;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class LicenseFormDataTable extends DataTable
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

        ->addColumn('fullname', function ($row) {
            return $row->owner ? '<a href="' . route('license_forms.show', $row->id ?: 0) . '">' . $row->owner->FullName . '</a>' : '';
        })
        
            ->addColumn('id_card', function ($row) {
                return $row->owner ? $row->owner->id_card : '';
            })
            ->addColumn('phone_number', function ($row) {
                return $row->owner ? $row->owner->phone_number : '';
            })

            ->addColumn('action', function ($row) {
                return '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">
            <a class="dropdown-item" id="editRow"  data-id="' . $row->building_number . '" href="javascript:;"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>
            <a id="deleteRow" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a></div></div>';
            })->rawColumns(['fullname', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\LicenseForm $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(LicenseForm $model): QueryBuilder
    {
        return $model->newQuery()->whereStatus('0')->orderByDesc('id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('licenseform-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle();
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
            ['title' => __('Full Name'), 'data' => 'fullname', 'orderable' => false],
            ['title' => "رقم الهوية", 'data' => 'id_card', 'orderable' => false],
            ['title' => "رقم الاتصال", 'data' => 'phone_number', 'orderable' => false],
            ['title' => "رقم القطعة", 'data' => 'block_number', 'orderable' => false],
            ['title' => "رقم القسيمة", 'data' => 'parcel_number', 'orderable' => false],
            ['title' => "رقم البمنى", 'data' => 'building_number', 'orderable' => false],
            ['title' => "تاريخ الطلب", 'name' => 'created_at', 'data' => 'created_at', 'orderable' => false],
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
        return 'LicenseForm_' . date('YmdHis');
    }
}
