@extends('layouts.master')
@section('title', __('Buildings'))
@section('stylesheet')


    {{-- <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"> --}}

@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card mt-1">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">أضف طلب ترخيص جديد</h5>
                        </div>
                    </div>

                    <div class="card px-3">
                        <form id="addDataForm" enctype="multipart/form-data" action="{{ route('license_forms.store') }}"
                            method="post">
                            @csrf
                            @method('post')
                            <div class="row my-3">
                                <div class="col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">موضوع الطلب</label>
                                    <input type="text" class="form-control" name="subject" id="subject">
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="text-light small fw-semibold">بيانات الأرض:</div>

                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput"
                                            class="form-label">{{ __('building number') }}:</label>
                                        <input type="text" class="form-control" name="building_number"
                                            id="e_building_number">
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput"
                                            class="form-label">{{ __('block number') }}:</label>
                                        <input type="number" class="form-control" name="block_number">
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput"
                                            class="form-label">{{ __('parcel number') }}:</label>
                                        <input type="number" class="form-control" name="parcel_number">
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">المنطقة</label>
                                        <input type="text" class="form-control" name="region">
                                    </div>
                                </div>
                                <hr>
                                <div class="text-light small fw-semibold">بيانات المالك:</div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الاسم الأول</label>
                                    <input type="text" class="form-control" name="first_name" required>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">اسم الأب</label>
                                    <input type="text" class="form-control" name="second_name" required>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">اسم الجد</label>
                                    <input type="text" class="form-control" name="third_name" required>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">اسم العائلة</label>
                                    <input type="text" class="form-control" name="sur_name" required>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم الهوية</label>
                                    <input type="number" class="form-control" name="id_card" required>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم المكلف</label>
                                    <input type="number" class="form-control" name="mokalaf">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم الاتصال</label>
                                    <input type="text" class="form-control" name="phone_number" required>
                                </div>
                                <div class="col-md-12 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">ملاحظات حول المالك</label>
                                    <textarea class="form-control" name="notes" rows="3"></textarea>
                                </div>
                            </div>
                            <hr>
                            {{-- <div class="text-light small fw-semibold">المرفقات:</div>
                            <div class="row">
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="formFile" class="form-label">سندات الملكية</label>
                                    <input class="form-control" type="file" name="title_deedPhoto"
                                        id="title_deedPhoto" data-allow-reorder="true">
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="formFile" class="form-label">مخطط الموقع العام</label>
                                    <input class="form-control" type="file" name="general_site_planPhoto">
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="formFile" class="form-label">خرائط البناء</label>
                                    <input class="form-control" type="file" name="construction_mapPhoto">
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="formFile" class="form-label">تعهد بالإشراف</label>
                                    <input class="form-control" type="file" name="undertaking_supervisePhoto">
                                </div>
                                <div class="col-md-4 col-12 mb-3">
                                    <label for="formFile" class="form-label">مصادقات جهات أخرى</label>
                                    <input class="form-control" type="file" name="aprobaciones_tercerosPhoto">
                                </div>
                            </div> --}}
                            <div class="col-12 my-3">
                                {{-- <button type="submit" id="print" name="submit" class="btn btn-label-success waves-effect mx-2" value="print">طباعة</button> --}}
                                <button class="btn btn-label-primary waves-effect" type="submit">التالي</button>

                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    {{-- <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,

        );
        FilePond.create(document.getElementById("title_deedPhoto"));
        FilePond.setOptions({
            server: {
                process: "{{ route('license_forms.tmpUpload') }}",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            },
        });
    </script> --}}
    <script>
        $("#addDataForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#addDataForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('license_forms.store') }}",
                    data: formData
                })
                .then(function(response) {
                    console.log(response.data)
                    // alert('done')
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    let num = $('#e_building_number').val();
                    window.location.href = "{{ url('/') }}" + "/home/license_forms/" + response.data
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
