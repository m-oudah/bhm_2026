<?php

namespace App\DataTables;

use App\Models\CustomerPen;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomerPenDataTable extends DataTable
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
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('name', function ($row) {
                return $row->FullName;
            })
            ->addColumn('action', function ($row) {
                return '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">
                    <a class="dropdown-item" id="editRow"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_edit_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>
                    <a id="deleteRow" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a></div></div>';
            })->rawColumns(['photo_id', 'is_active', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CustomerPen $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CustomerPen $model): QueryBuilder
    {
        return $model->newQuery()->orderByDesc('id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('customerpen-table')
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
            ['title' => '#', 'data' =>   'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => __('Name'),  'data' => 'name', 'orderable' => false],
            ['title' => "رقم الهوية",  'data' => 'id_no', 'orderable' => false],
            ['title' => "رقم الاتصال",  'data' => 'telephone', 'orderable' => false],
            ['title' => "العنوان",  'data' => 'address', 'orderable' => false],
            ['title' => __('Create At'), 'data' => 'created_at', 'orderable' => false],
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
        return 'CustomerPen_' . date('YmdHis');
    }
}
