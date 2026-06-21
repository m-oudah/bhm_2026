@extends('layouts.master')
@section('title', 'المكلفين')
@section('stylesheet')

@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0"><span class="text-muted fw-light">قلم الجمهور /</span> المكلفين</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#add">
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
    <!-- Modal -->
    {{--  add --}}
    <div class="modal fade" id="add" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNew" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="row">
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('first_name') }}:</label>
                                <input type="text" class="form-control" name="first_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('second_name') }}:</label>
                                <input type="text" class="form-control" name="second_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('third_name') }}:</label>
                                <input type="text" class="form-control" name="third_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('sur_name') }}:</label>
                                <input type="text" class="form-control" name="sur_name">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الهوية</label>
                            <input type="number" class="form-control" name="id_no">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الاتصال</label>
                            <input type="number" class="form-control" name="telephone">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">العنوان</label>
                            <input type="text" class="form-control" name="address">
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="show_edit_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editData" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <input type="hidden" id="id" name="id">
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('first_name') }}:</label>
                                <input type="text" class="form-control" name="first_name" id="first_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('second_name') }}:</label>
                                <input type="text" class="form-control" name="second_name" id="second_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('third_name') }}:</label>
                                <input type="text" class="form-control" name="third_name" id="third_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('sur_name') }}:</label>
                                <input type="text" class="form-control" name="sur_name" id="sur_name">
                            </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الهوية</label>
                            <input type="number" class="form-control" name="id_no" id="id_no">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الاتصال</label>
                            <input type="number" class="form-control" name="telephone" id="telephone">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">العنوان</label>
                            <input type="text" class="form-control" name="address" id="address">
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        $("#addNew").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#addNew')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('customer-pens.store') }}",
                    data: formData
                })
                .then(function(response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    $('#addNew').trigger("reset");
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
                    axios.delete("{{ url('/') }}" + '/home/customer-pens/' + id)
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
            let edit = "{{ url('/') }}" + '/home/customer-pens/' + id + '/edit';
            axios.get(edit)
                .then(function(res) {
                    // console.log(res);
                    $('#id').val(res.data.id)
                    $('#first_name').val(res.data.first_name)
                    $('#second_name').val(res.data.second_name)
                    $('#third_name').val(res.data.third_name)
                    $('#sur_name').val(res.data.sur_name)
                    $('#id_no').val(res.data.id_no)
                    $('#telephone').val(res.data.telephone)
                    $('#address').val(res.data.address)
                })
        })
        // =====================================
        $("#editData").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#editData')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('customer-pens.update_data') }}",
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
