@extends('layouts.master')
@section('title', 'أضف جديد')
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

        div#table_owner_length,
        div#table_owner_filter,
        div#table_unit_filter,
        div#table_unit_length,
        div#table_subscription_filter,
        div#table_subscription_length,
        div#table_floor_filter,
        div#table_floor_length {
            display: none;
        }

        .bhm_icon_search {
            position: relative;
            display: block;
            width: 40px;
            bottom: 29px;
            left: 0;
            right: 245px;
            text-align: center;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card mt-1">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">أضف طلب جديد</h5>
                        </div>
                    </div>

                    <div class="card px-3">
                        <form id="addDataForm" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="text-light small fw-semibold">
                                     بيانات المكلف:</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label">رقم الهوية:</label>
                                    <input type="text" class="form-control" name="id_no" id="id_no" required>
                                    <div class="bhm_icon_search" id="bhm_icon_search"><i class="fa fa-search"></i></div>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label"> رقم الاتصال:</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile">
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label">الاسم الأول</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label">اسم الأب</label>
                                    <input type="text" class="form-control" name="second_name" id="second_name">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label">اسم الجد</label>
                                    <input type="text" class="form-control" name="third_name" id="third_name">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label">اسم العائلة</label>
                                    <input type="text" class="form-control" name="sur_name" id="sur_name">
                                </div>
                            </div>
                            <hr>
                            <div class="row mt-3">
                                <div class="text-light small fw-semibold">
                                    بيانات الطلب:</div>
                                <div class="col-md-12 col-12 my-3">
                                    <label for="exampleFormControlSelect1"
                                           class="form-label">المعاملة:</label>
                                    <select class="form-select street_id" name="treatment_id">
                                        @foreach ($treatments as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-12 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label">العنوان:</label>
                                    <input type="text" class="form-control" name="title">
                                </div>

                                <div class="col-md-12 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الوصف</label>
                                    <textarea class="form-control" name="description" rows="3"></textarea>
                                </div>

                            </div>
                            <hr>

                            <div class="col-12 my-3">
                                <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $('.street_id').select2();
        // ============================
        $("#addDataForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#addDataForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('customer-pen-treatments.store') }}",
                data: formData
            })
                .then(function (response) {
                    $('#DataTables_Table_0').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    $('#addDataForm').trigger("reset");
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
        $('body').on('click', '#bhm_icon_search', function () {
            axios({
                method: 'post',
                url: "{{ route('search_Id_Num') }}",
                data: {
                    id_num: $('#id_no').val()
                }
            })
                .then(function (res) {
                    // console.log(res.data);
                    $('#id').val(res.data.id)
                    $('#mobile').val(res.data.mobile)
                    $('#first_name').val(res.data.first_name)
                    $('#second_name').val(res.data.second_name)
                    $('#third_name').val(res.data.third_name)
                    $('#sur_name').val(res.data.sur_name)
                });
        })

    </script>
@endpush
