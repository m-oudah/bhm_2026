@extends('layouts.master')
@section('title', 'جميع الوحدات')
@section('stylesheet')

@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0"><span class="text-muted fw-light">جميع الوحدات</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#add">
                                    {{ __('Add New') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        {!! $dataTable->table([
                            'class' => 'datatables-basic table dataTable no-footer dtr-column',
                            'id' => 'DataTables_Table_0',
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>

    </script>
@endpush
