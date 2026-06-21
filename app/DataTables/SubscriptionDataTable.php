<?php

namespace App\DataTables;

use App\Models\Subscription;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SubscriptionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()->eloquent($query)->addIndexColumn();
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Subscription $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Subscription $model): QueryBuilder
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
            ->setTableId('subscription-table')
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
            ['title' => '#', 'name' => 'DT_RowIndex', 'data' =>   'DT_RowIndex', 'orderable' => false, 'searchable' => false],
            ['title' => __('Name'), 'name' => 'name', 'data' => 'name', 'orderable' => false],
            ['title' => __('Id Number'), 'name' => 'id_number', 'data' => 'id_number', 'orderable' => false],
            ['title' => __('Customer Number'), 'name' => 'customer_number', 'data' => 'customer_number', 'orderable' => false],
            ['title' => __('Address'), 'name' => 'address', 'data' => 'address', 'orderable' => false],
            ['title' => __('Mobile'), 'name' => 'mobile', 'data' => 'mobile', 'orderable' => false],
            ['title' => __('Notes'), 'name' => 'notes', 'data' => 'notes', 'orderable' => false],
            ['title' => __('Create At'), 'name' => 'created_at', 'data' => 'created_at', 'orderable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Subscription_' . date('YmdHis');
    }
}
