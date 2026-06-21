@extends('layouts.master')
@section('title', 'المعاملات')
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/select2/select2.css') }}" />
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
                            <h5 class="card-title mb-0"><span class="text-muted fw-light">قلم الجمهور /</span> تعديل بيانات
                            </h5>
                        </div>

                    </div>

                    <div class="card">
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
                                <div class="col-md-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">القسم</label>
                                    <select class="form-select js-example-basic-multiple" name="users[]" id="users[]"
                                        multiple="multiple">
                                        @foreach ($users as $user)
                                        {{-- @selected($treatment->id == $user->pivot->treatment_id && $user->id == $user->pivot->user_id) --}}
                                            <option value="{{ $user->id }}" >
                                                {{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mt-3">
                                    <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{ asset('dash/assets/vendor/libs/select2/select2.js') }}"></script>


    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: 'Select an option',
                width: '100%'
            });
        });

        $("#addForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#addForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('treatments.store') }}",
                    data: formData
                })
                .then(function(response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    $('#addForm').trigger("reset");
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
                    axios.delete("{{ url('/') }}" + '/home/treatments/' + id)
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

        $('body').on('click', '#edit', function() {
            let id = $(this).data('id');
            axios({
                    method: 'get',
                    url: "{{ url('/') }}" + '/home/treatments/' + id + '/edit',
                })
                .then(function(response) {
                    console.log(response.data);
                    $('#id').val(response.data.id)
                    $('#name').val(response.data.name)
                    $('#department_id').val(response.data.department_id)


                    // let users = response.data.all_users
                    // $('#users').empty()
                    // for (var i = 0; i < users.length; i++) {
                    //     // console.log(user[i].name);
                    //     $('#users').val(user[i].name)

                    //     if(users[i].id in )
                    //     $('#users').append('<option value="' + users[i].id + '">' + users[i].name +'</option>')

                    // }

                });
        });

        $("#editForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#editForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('treatments.update_data') }}",
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
