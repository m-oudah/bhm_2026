@extends('layouts.master')
@section('title', 'الأدوار')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">الأدوار</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <button type="button" class="btn btn-primary waves-effect waves-light"
                                    data-bs-toggle="modal" data-bs-target="#role">
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
    {{--  add role form --}}
    <div class="modal fade" id="role" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-md" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addRoleForm" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--  edit role form --}}
    <div class="modal fade" id="role_edit" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-md" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editRoleForm" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <input type="hidden" name="id" id="id">

                        <div class="col-md-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="name" id="name">
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
                    axios.delete("{{ url('/') }}" + '/home/roles/' + id)
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

        $("#addRoleForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#addRoleForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('roles.store') }}",
                    data: formData
                })
                .then(function(response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    $('#addRoleForm').trigger("reset");
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

        $('body').on('click', '#edit', function() {
            let id = $(this).data('id');
            axios({
                    method: 'get',
                    url: "{{ url('/') }}" + '/home/roles/' + id + '/edit',
                })
                .then(function(response) {
                    console.log(response.data);
                    $('#id').val(response.data.id)
                    $('#name').val(response.data.name)
                });
        });

        $("#editRoleForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#editRoleForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('roles.update_data') }}",
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
