@extends('layouts.master')
@section('title', __('Buildings'))
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
    </style>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card mt-1">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">أضف مبنى جديد</h5>
                        </div>
                    </div>

                    <div class="card px-3">
                        <form id="addDataForm" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="row">
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">{{ __('file number') }}:</label>
                                    <input type="text" class="form-control" name="file_number">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                        class="form-label">{{ __('building number') }}:</label>
                                    <input type="text" class="form-control" name="building_number">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                        class="form-label">{{ __('block number') }}:</label>
                                    <input type="text" class="form-control" name="block_number">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                        class="form-label">{{ __('parcel number') }}:</label>
                                    <input type="text" class="form-control" name="parcel_number">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">مساحة الأرض:</label>
                                    <input type="number" class="form-control" name="area">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                        class="form-label">{{ __('building name') }}:</label>
                                    <input type="text" class="form-control" name="building_name">
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('Street number') }}:</label>
                                    <select class="form-select street_id" name="street_id">
                                        @foreach ($streets as $item)
                                            <option value="{{ $item->id }}">{{ $item->street_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('Zone number') }}:</label>
                                    <select class="form-select street_id zone_id" name="zone_id">
                                        @foreach ($zones as $item)
                                            <option value="{{ $item->id }}">{{ $item->zone_number }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('SubZone number') }}:</label>
                                    <select class="form-select street_id" id="subzone_id" name="subzone_id">
                                        <option></option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('Property Type') }}:</label>
                                    <select class="form-select street_id" name="building_property_type_id">
                                        @foreach ($propertyTypes as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('Building type') }}:</label>
                                    <select class="form-select street_id" name="building_type">

                                        @foreach ($buildingTypes as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('construction status') }}:</label>
                                    <select class="form-select street_id" name="building_status_id">
                                        @foreach ($buildingStatus as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('The type of final finishing of the building') }}:</label>
                                    <select class="form-select street_id" name="building_finish_id">
                                        @foreach ($buildingFinish as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('The general condition of the building') }}:</label>
                                    <select class="form-select street_id" name="general_condition">
                                        <option value="1">ممتازة</option>
                                        <option value="2">جيدة</option>
                                        <option value="3">سيئة</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('The external condition of the building') }}:</label>
                                    <select class="form-select street_id" name="external_condition">
                                        <option value="1">مشطب كامل
                                        </option>
                                        <option value="2">مشطب جزئي
                                        </option>
                                        <option value="3">غير مشطب
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('Sewage') }}:</label>
                                    <select class="form-select street_id" name="sewage">
                                        <option value="1">شبكة بلدية</option>
                                        <option value="2">حفر امتصاصية
                                        </option>
                                        <option value="3">لا يوجد
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('escape staircase') }}:</label>
                                    <select class="form-select street_id" name="escape_staircase">
                                        <option value="1">متوفر</option>
                                        <option value="2">غير متوفر
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('water network') }}:</label>
                                    <select class="form-select street_id" name="waterNetwork">
                                        <option value="1">شبكة عامة
                                        </option>
                                        <option value="2">شبكة خاصة
                                        </option>
                                        <option value="3">لا يوجد
                                        </option>

                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1"
                                        class="form-label">{{ __('power network') }}:</label>
                                    <select class="form-select street_id" name="sewageNetwork">
                                        <option value="1">شبكة عامة
                                        </option>
                                        <option value="2">شبكة خاصة
                                        </option>
                                        <option value="3">لا يوجد
                                        </option>

                                    </select>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                {{-- ========================= --}}
                                {{-- uses --}}
                                <div class="col-12">
                                    <div class="demo-inline-spacing">
                                        <div class="row">
                                            <div class="text-light small fw-semibold">
                                                {{ __('Building use') }}:</div>
                                            <div class="col-md-12">
                                                <ul class="pro-feature-add" style=" padding: 0; ">
                                                    @foreach ($buildingUse as $item)
                                                        <label class="switch switch-primary my-2">
                                                            <input type="checkbox" class="switch-input"
                                                                id="{{ $item->id }}" name="uses[]"
                                                                value="{{ $item->id }}">
                                                            <span class="switch-toggle-slider">
                                                                <span class="switch-on">
                                                                    <i class="ti ti-check"></i>
                                                                </span>
                                                                <span class="switch-off">
                                                                    <i class="ti ti-x"></i>
                                                                </span>
                                                            </span>
                                                            <span class="switch-label"
                                                                for="{{ $item->id }}">{{ $item->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="demo-inline-spacing">
                                        <div class="row">
                                            <div class="text-light small fw-semibold">
                                                {{ __('The last roof construction material') }}:</div>
                                            <div class="col-md-12">
                                                <ul class="pro-feature-add" style=" padding: 0; ">
                                                    @foreach ($buildingMaterial as $item)
                                                        <label class="switch switch-primary">
                                                            <input type="checkbox" class="switch-input"
                                                                id="{{ $item->id }}" name="material[]"
                                                                value="{{ $item->id }}">
                                                            <span class="switch-toggle-slider">
                                                                <span class="switch-on"><i
                                                                        class="ti ti-check"></i></span><span
                                                                    class="switch-off"><i
                                                                        class="ti ti-x"></i></span></span>
                                                            <span class="switch-label"
                                                                for="{{ $item->id }}">{{ $item->name }}</span>
                                                        </label>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row my-3">
                                <div class="text-light small fw-semibold">بيانات المالك:</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الاسم الأول</label>
                                    <input type="text" class="form-control" name="first_name">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">اسم الأب</label>
                                    <input type="text" class="form-control" name="second_name">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">اسم الجد</label>
                                    <input type="text" class="form-control" name="third_name">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">اسم العائلة</label>
                                    <input type="text" class="form-control" name="sur_name">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم الهوية</label>
                                    <input type="text" class="form-control" name="id_card">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم المكلف</label>
                                    <input type="text" class="form-control" name="mokalaf">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم الاتصال</label>
                                    <input type="text" class="form-control" name="phone_number">
                                </div>
                                <div class="col-md-12 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">ملاحظات حول المالك</label>
                                    <textarea class="form-control" name="notes" rows="3"></textarea>
                                </div>
                            </div>
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
        $("#addDataForm").on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData($('#addDataForm')[0]);
            axios({
                    method: 'post',
                    url: "{{ route('buildings.store') }}",
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
        //add sub zone to form where zone selected
        $('.zone_id').on('change', function() {
            var zone_id = this.value;
            $("#subzone_id").html('');
            $.ajax({
                url: "{{ route('buildings.fetchSubZone') }}",
                type: "POST",
                data: {
                    zone_id: zone_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(res) {
                    console.log(res);
                    $('#subzone_id').html('<option value="">-- Select SubZone --</option>');
                    $.each(res.subzones, function(key, value) {
                        $("#subzone_id").append('<option value="' + value
                            .id + '">' + value.zone_number + '</option>');
                    });
                }
            });
        });
    </script>
@endpush
