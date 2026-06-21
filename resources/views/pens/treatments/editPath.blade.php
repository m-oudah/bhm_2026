@extends('layouts.master')
@section('title', 'المعاملات')
@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/select2/select2.css') }}"/>
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
                            <h5 class="card-title mb-0">
                                موظفين المعاملة
                            </h5>
                        </div>
                        <div class="dt-buttons btn-group flex-wrap">
                            <a class="btn btn-primary waves-effect waves-light" href="javascript:;"
                               data-bs-toggle="modal" data-bs-target="#show_path_model">
                                <span style=" color: #fff; "> {{ __('Add New') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>الموظف</th>
                        <th>الترتيب</th>
                        <th>ملاحظات</th>
                        <th>التحكم</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($treatment as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$item->user ? $item->user->name : ''}}</td>
                            <td>{{$item->order}}</td>
                            <td>{{$item->notes}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);" id="editRow"
                                           data-id="{{$item->id}}" data-bs-toggle="modal"
                                           data-bs-target="#edit_path_model"><i class="ti ti-pencil me-2"></i>تعديل</a>
                                        <a id="deleteRow" data-id="{{$item->id }} " class="dropdown-item"
                                           href="javascript:;"><i
                                                class="ti ti-trash me-2"></i>
                                            حذف</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{--  Add To Path--}}
    <div class="modal fade" id="show_path_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-md" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addPath" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('post')
                    <input type="hidden" name="treatment_id" value="{{$treatment_id}}">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الموظف</label>
                            <select class="form-select js-example-basic-multiple" name="user_id">
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الترتيب</label>
                            <select class="form-select" name="order">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                            <textarea class="form-control" name="notes" id="PathNotes" rows="3"></textarea>
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Edit --}}
    <div class="modal fade" id="edit_path_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-md" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editPath" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الموظف</label>
                            <select class="form-select js-example-basic-multiple" name="user_id" id="user_id">
                                @foreach ($users as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الترتيب</label>
                            <select class="form-select" name="order" id="order">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                            <textarea class="form-control" name="notes" id="notes" rows="3"></textarea>
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
    <script src="{{ asset('dash/assets/vendor/libs/select2/select2.js') }}"></script>


    <script>
        $('.js-example-basic-multiple').select2({
            placeholder: 'Select an option',
            width: '100%'
        });

        $("#addPath").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#addPath')[0]);
            axios({
                method: 'post',
                url: "{{ route('treatment-users.store') }}",
                data: formData
            })
                .then(function (response) {
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    window.location.href = "{{ url()->current() }}"
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
                    axios.delete("{{ url('/') }}" + '/home/treatment-users/' + id)
                        .then(function (response) {
                            // console.log(response);
                            showMessage(response.data);
                            window.location.href = "{{ url()->current() }}"
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

        $('body').on('click', '#editRow', function (e) {
            let id = $(this).data('id')
            axios({
                method: 'get',
                url: "{{ url('/') }}" + '/home/treatment-users/' + id + '/edit',
            })
                .then(function (response) {
                    console.log(response.data);
                    $('#id').val(response.data.id)
                    $('#user_id').val(response.data.user_id)
                    $('#order').val(response.data.order)
                    $('#notes').val(response.data.notes)
                })
        })

        $("#editPath").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#editPath')[0]);
            axios({
                method: 'post',
                url: "{{ route('treatment-users.update_data') }}",
                data: formData
            })
                .then(function (response) {
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    window.location.href = "{{ url()->current() }}"
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
