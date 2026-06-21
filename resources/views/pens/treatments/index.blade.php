@extends('layouts.master')
@section('title', 'المعاملات')
@section('stylesheet')
    <style>
        .select2-container {
            z-index: 999999;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0"><span class="text-muted fw-light">قلم الجمهور /</span> المعاملات
                            </h5>
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
    {{--  add  form --}}
    <div class="modal fade" id="add" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addForm" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الاسم</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">القسم</label>
                            <select class="form-select " name="department_id">
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">حدد مرفقات المعاملة</label>
                            <select class="form-select treatment_name_attachment" name="treatment_name_attachment[]"
                                    multiple>
                                @foreach ($treatmentNameAttchment as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الرسوم المطلوبة</label>
                            <input type="number" class="form-control" name="fee_required">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الوقت المتوقع للإنجاز</label>
                            <input type="text" class="form-control" name="expected_time">
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>
                    </div>
                </form>
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
                            <label for="defaultFormControlInput" class="form-label">القسم</label>
                            <select class="form-select " name="department_id" id="department_id">
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">حدد مرفقات المعاملة</label>
                            <select class="form-select treatment_name_attachment" name="treatment_name_attachment[]"
                                    multiple>
                                @foreach ($treatmentNameAttchment as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الرسوم المطلوبة</label>
                            <input type="number" class="form-control" name="fee_required" id="fee_required">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الوقت المتوقع للإنجاز</label>
                            <input type="text" class="form-control" name="expected_time" id="expected_time">
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
        $('.treatment_name_attachment').select2({
            placeholder: 'Select an option',
            width: '100%'
        });

        $("#addForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#addForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('treatments.store') }}",
                data: formData
            })
                .then(function (response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    $('#addForm').trigger("reset");
                    $(".treatment_name_attachment").val('').trigger('change')
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
                    axios.delete("{{ url('/') }}" + '/home/treatments/' + id)
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

        $('body').on('click', '#edit', function () {
            $(".treatment_name_attachment").val('').trigger('change')
            let id = $(this).data('id');
            axios({
                method: 'get',
                url: "{{ url('/') }}" + '/home/treatments/' + id + '/edit',
            })
                .then(function (response) {
                    // console.log(response.data);
                    $('#id').val(response.data.id)
                    $('#name').val(response.data.name)
                    $('#department_id').val(response.data.department_id)
                    $('#fee_required').val(response.data.fee_required)
                    $('#expected_time').val(response.data.expected_time)
                })

        });

        $("#editForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#editForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('treatments.update_data') }}",
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
