<?php

namespace App\DataTables;

use App\Models\Treatment;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

class TreatmentDataTable extends DataTable
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
            ->editColumn('department_id', function ($row) {
                return $row->department ? $row->department->name : '';
            })
            ->editColumn('name', function ($row) {
                return $row->name ? '<a href="' . route('treatments.edit', $row->id) . '">' . $row->name . '</a>' : '';
            })
            ->addColumn('action', function ($row) {
                return '<div class="dropdown"><button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0 waves-effect waves-float waves-light" data-bs-toggle="dropdown" aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></button><div class="dropdown-menu dropdown-menu-end" style="">
                        <a class="dropdown-item" id="edit"  data-id="' . $row->id . '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_edit_model"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>' . __('Edit') . '</span></a>
                        <a class="dropdown-item"  href="'.route("treatment-users.show", $row->id).'"><i class="fa-regular fa-pen-to-square" style=" margin: 0 0.5rem !important; "></i><span>تحديد مسار المعاملة</span></a>
                        <a id="deleteRow" data-id="' . $row->id . '" class="dropdown-item" data-toggle="modal" data-target="#deletemodal"><i class="fa-regular fa-trash-can" style=" margin: 0 0.5rem !important; "></i><span>' . __('Delete') . '</span></a></div></div>';
            })->rawColumns(['name', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Treatment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Treatment $model): QueryBuilder
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
            ->setTableId('treatment-table')
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
            ['title' => '#', 'data' => 'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => __('Name'), 'data' => 'name', 'orderable' => false],
            ['title' => 'القسم', 'data' => 'department_id', 'orderable' => false],

            ['title' => __('Created At'), 'data' => 'created_at', 'orderable' => false],
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
        return 'Treatment_' . date('YmdHis');
    }
}
