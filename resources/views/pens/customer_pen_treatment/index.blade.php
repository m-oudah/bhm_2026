@extends('layouts.master')
@section('title', 'طلبات المكلفين')
@section('stylesheet')

@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0"><span class="text-muted fw-light">قلم الجمهور /</span>طلبات
                                المكلفين
                            </h5>
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

    {{--  edit form --}}
    <div class="modal fade" id="show_edit_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <input type="hidden" name="id" id="id">
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">INNER_TELEPHONE</label>
                            <input type="number" class="form-control" name="inner_telephone" id="inner_telephone">
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--  All Reply --}}
    <div class="modal fade" id="show_all_reply_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editForm" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row" id="allReply">
                        <div class="col-md-6 mb-3">
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
        // $(document).ready(function() {
        //     $('.customer').select2();
        // });
        $("#addForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#addForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('departments.store') }}",
                data: formData
            })
                .then(function (response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    $('#addForm').trigger("reset");
                })
                .catch(function (error) {
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
        $('body').on('click', '#deleteRow', function (e) {
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
                    axios.delete("{{ url('/') }}" + '/home/departments/' + id)
                        .then(function (response) {
                            // console.log(response);
                            showMessage(response.data);
                            $('#DataTables_Table_0').DataTable().ajax.reload();
                        }).catch(function (error) {
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
        $('body').on('click', '#editRow', function () {
            let id = $(this).data('id');
            let edit = "{{ url('/') }}" + '/home/departments/' + id + '/edit';
            axios.get(edit)
                .then(function (res) {
                    // console.log(res);
                    $('#id').val(res.data.id)
                    $('#name').val(res.data.name)
                    $('#inner_telephone').val(res.data.inner_telephone)
                })
            $("#editFormData").fadeIn("fast");
        })
        // =====================================
        $("#editForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#editForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('departments.update_data') }}",
                data: formData
            })
                .then(function (response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                })
                .catch(function (error) {
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
