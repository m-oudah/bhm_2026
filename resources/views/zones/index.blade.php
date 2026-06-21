@extends('layouts.master')
@section('title', __('zones'))
@section('stylesheet')
    <style>
        .createFormData,
        .editFormData {
            position: fixed;
            box-shadow: 1px 1px #efe8e8;
            display: none;
            background: #fff;
            height: 100vh;
            padding: 90px 10px 10px 10px;
            width: 330px;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ __('Home') }} /</span> {{ __('Zones') }}</h4>
        <div class="card">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">{{ __('Zones') }}</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <div class="btn-group">
                                    <button
                                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary me-2 waves-effect"
                                        tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                        aria-haspopup="dialog" aria-expanded="false"><span><i
                                                class="ti ti-file-export me-sm-1"></i> <span
                                                class="d-none d-sm-inline-block">Export</span></span><span
                                            class="dt-down-arrow"></span>
                                    </button>
                                </div>
                                <button class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                    id="add_new" tabindex="0" aria-controls="DataTables_Table_0" type="button"><span><i
                                            class="ti ti-plus me-sm-1">
                                        </i> <span class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
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
    <div class="createFormData" id="createFormData">
        <div class="offcanvas-header border-bottom mb-3">
            <h5 class="offcanvas-title" id="exampleModalLabel">{{ __('New Zones') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
                id="close"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form id="addDataForm" enctype="multipart/form-data">
                @csrf
                @method('post')
                <div class="col-sm-12">
                    <label class="form-label" for="zone_number">{{ __('Zone Number') }}</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="zone_number" class="form-control" name="zone_number" maxlength="2" size="2" required/>
                    </div>
                </div>
                <div class="col-sm-12 mt-2">
                    <label class="form-label" for="zone_name">{{ __('Zone Name') }}</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="zone_name" name="zone_name" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
    <div class="editFormData" id="editFormData">
        <div class="offcanvas-header border-bottom mb-3">
            <h5 class="offcanvas-title" id="exampleModalLabel">{{ __('Edit Zones') }}</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"
                id="editClose"></button>
        </div>
        <div class="offcanvas-body flex-grow-1">
            <form id="editData" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="id" id="e_id">
                <div class="col-sm-12">
                    <label class="form-label" for="street_number">{{ __('Zone Number') }}</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="e_zone_number" class="form-control" name="zone_number" maxlength="2" size="2" required />
                    </div>
                </div>
                <div class="col-sm-12 mt-2">
                    <label class="form-label" for="street_name">{{ __('Zone Name') }}</label>
                    <div class="input-group input-group-merge">
                        <input type="text" id="e_zone_name" name="zone_name" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12 mt-3">
                    <button type="submit" class="btn btn-primary data-submit me-sm-3 me-1">{{__('Save')}}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        $("#editClose").click(function() {
            $("#editFormData").fadeOut("fast");
        });
        // =====================================
        $("#addDataForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#addDataForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('zones.store') }}",
                    data: formData
                })
                .then(function(response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    $('#addDataForm').trigger("reset");
                })
                .catch(function(error) {
                    // console.log(error);
                    if (error.response.status == 422) {
                        var object = error.response.data.errors;
                        for (const key in object) {
                            var message = object[key][0]
                            break;
                        }
                        toastr.error(message);
                    } else {
                        toastr.error(error.response.data.message);
                    }
                });
        });
        // =====================================
        $('body').on('click', '#deleteRow', function(e) {
            e.preventDefault();
            let id = $(this).data('id')
            Swal.fire({
                title: 'هل أنت واثق؟',
                text: "لن تتمكن من التراجع عن هذا!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، احذفها!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete("{{ url('/') }}" + '/home/zones/' + id)
                        .then(function(response) {
                            // console.log(response);
                            showMessage(response.data);
                            $('#DataTables_Table_0').DataTable().ajax.reload();
                        }).catch(function(error) {
                            // console.log(error);
                            showMessage(error.response.data);
                        })
                }
            });

            function showMessage(data) {
                Swal.fire({
                    position: 'top-end',
                    icon: data.icon,
                    title: data.title,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        });
        // =====================================
        //edit
        $('body').on('click', '#editRow', function() {
            let id = $(this).data('id');
            let edit = "{{ url('/') }}" + '/home/zones/' + id + '/edit';
            axios.get(edit)
                .then(function(res) {
                    // console.log(res);
                    $('#e_id').val(res.data.id)
                    $('#e_zone_number').val(res.data.zone_number)
                    $('#e_zone_name').val(res.data.zone_name)
                })
            $("#editFormData").fadeIn("fast");
        })
        // =====================================
        $("#editData").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#editData')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('zones.update_data') }}",
                    data: formData
                })
                .then(function(response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                })
                .catch(function(error) {
                    // console.log(error);
                    if (error.response.status == 422) {
                        var object = error.response.data.errors;
                        for (const key in object) {
                            var message = object[key][0]
                            break;
                        }
                        toastr.error(message);
                    } else {
                        toastr.error(error.response.data.message);
                    }
                });
        });
    </script>
@endpush
