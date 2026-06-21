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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">{{ __('Home') }} /</span> {{ __('Buildings') }}
        </h4>
        <section id="basic-input py-3 mb-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="accordion" id="accordionExample" data-toggle-hover="true">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#accordionFour" aria-expanded="false"
                                                aria-controls="accordionFour">
                                            <i class="fa-solid fa-magnifying-glass" style=" padding: 0 6px; "></i> بحث
                                            متقدم
                                        </button>
                                    </h2>
                                    <div id="accordionFour" class="accordion-collapse collapse"
                                         aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <form id="export_excel_New my-form">
                                                @method('get')
                                                <div class="row">
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="id_card"
                                                                   id="id_card"
                                                                   placeholder="رقم الهوية .."
                                                                   value="{{ request('id_card') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="phone_number"
                                                                   placeholder="رقم الجوال .."
                                                                   value="{{ request('phone_number') }}"
                                                                   id="phone_number">
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control"
                                                                   name="building_number" placeholder="رقم المبنى .."
                                                                   value="{{ request('building_number') }}"
                                                                   id="building_number">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <select class="form-select street_id" name="street_id" id="street_id">
                                                                <option></option>
                                                                @foreach ($streets as $street)
                                                                    <option value="{{ $street->id }}">
                                                                        {{ $street->street_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="first_name"
                                                                   placeholder="الاسم الأول .."
                                                                   value="{{ request('first_name') }}" id="first_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="second_name"
                                                                   placeholder="اسم الأب"
                                                                   value="{{ request('second_name') }}"
                                                                   id="second_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="third_name"
                                                                   placeholder="اسم الجد"
                                                                   value="{{ request('third_name') }}" id="third_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="sur_name"
                                                                   placeholder="اسم العائلة .."
                                                                   value="{{ request('sur_name') }}" id="sur_name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="file_number"
                                                                   placeholder="رقم الملف .."
                                                                   value="{{ request('file_number') }}"
                                                                   id="file_number">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="mokalaf" id="mokalaf"
                                                                   placeholder="رقم المكلف .."
                                                                   value="{{ request('mokalaf') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" name="block_number" id="block_number"
                                                                   placeholder="رقم القطعة .."
                                                                   value="{{ request('block_number') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control"
                                                                   name="parcel_number" id="parcel_number" placeholder="رقم القسيمة .."
                                                                   value="{{ request('parcel_number') }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control"
                                                                   name="building_name" id="building_name" placeholder="اسم المبنى .."
                                                                   value="{{ request('building_name') }}">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <select class="form-select zone_id" name="zone_id" id="zone_id">
                                                                <option></option>
                                                                @foreach ($streets as $street)
                                                                    <option value="{{ $street->id }}">
                                                                        {{ $street->street_number }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <select class="form-select subzone_id" id="subzone_id"
                                                                    name="subzone_id">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <select class="form-select license" name="license" id="license">
                                                                <option value="">حالة الترخيص</option>
                                                                <option value="1" @selected(request('license') == '1')>
                                                                    مباني غير مرخصة
                                                                </option>
                                                                <option value="2" @selected(request('license') == '2')>
                                                                    مباني مرخصة وغير مستوفية الرسوم
                                                                </option>
                                                                <option value="3" @selected(request('license') == '3')>
                                                                    مباني مرخصة ومتبقي طوابق غير مرخصة
                                                                </option>
                                                                <option value="4" @selected(request('license') == '4')>
                                                                    مباني مرخصة ومستوفية الشروط
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <select class="form-select buildingType" name="building_type" id="building_type">
                                                            <option value="">تصنيف المبنى
                                                            </option>
                                                            @foreach ($buildingTypes as $item)
                                                                <option
                                                                    value="{{ $item->id }}" @selected(request('building_type') == $item->id)>{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <select class="form-select subscription" name="subscription" id="subscription">
                                                            <option value="">حالة الاشتراك
                                                            </option>
                                                            <option value="1" @selected(request('subscription') == '1')>
                                                                لا يوجد اشترك
                                                            </option>
                                                            <option value="2" @selected(request('subscription') == '2')>
                                                                يوجد اشتراك
                                                            </option>
                                                            <option value="3" @selected(request('subscription') == '3')>
                                                                يوجد اشتراك ولا يوجد عداد
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <select class="form-select craft" name="craft" id="craft">
                                                            <option value="">حالة الحرف
                                                            </option>
                                                            <option value="1" @selected(request('craft') == '1')>مباني
                                                                لا يوجد فيها حرف
                                                            </option>
                                                            <option value="2" @selected(request('craft') == '2')>مباني
                                                                فيها حرف
                                                            </option>
                                                            <option value="3" @selected(request('craft') == '3')>حرف
                                                                مرخصة
                                                            </option>
                                                            <option value="4" @selected(request('craft') == '4')>حرف
                                                                مرخصة وخطرة
                                                            </option>
                                                            <option value="5" @selected(request('craft') == '5')>حرف غير
                                                                مرخصة
                                                            </option>
                                                            <option value="6" @selected(request('craft') == '6')>حرف غير
                                                                مرخصة وخطرة
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <button class="btn btn-primary" type="submit" name="submit"
                                                                    value="222"
                                                                    style=" width: 100%; ">بحث متقدم
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-md-6 col-12 d-inline-block">
                                                        <div class="mb-2">
                                                            <button class="btn btn-primary" type="button"
                                                                    style=" width: 100%; " id="export_excel_btn">تصدير
                                                                Excel
                                                            </button>
                                                        </div>
                                                    </div>


                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="card mt-4">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">{{ __('Buildings') }}</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">

                                <a href="{{ route('buildings.create') }}"
                                   class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                   id="add_new" tabindex="0" aria-controls="DataTables_Table_0"
                                   type="button"><span><i class="ti ti-plus me-sm-1">
                                        </i> <span class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
                                </a>
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
    {{-- Owners --}}
    <div class="modal fade" id="show_owner_model" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">{{ __('Owners') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <table class="datatables-basic table dataTable no-footer dtr-column" id="table_owner"
                                   aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr>
                                    <th class="sorting">{{ __('#') }}</th>
                                    <th class="sorting">{{ __('ID') }}</th>
                                    <th class="sorting">{{ __('Full Name') }}</th>
                                    <th class="sorting">{{ __('Mokalaf Number') }}</th>
                                    <th class="sorting">{{ __('Phone Number') }}</th>
                                    <th class="sorting">{{ __('Notes') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    {{-- Units --}}
    <div class="modal fade" id="show_unit_model" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">{{ __('Units') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <table class="datatables-basic table dataTable no-footer dtr-column" id="table_unit"
                                   aria-describedby="DataTables_Table_0_info" style="width: 1303px;">
                                <thead>
                                <tr>
                                    <th class="sorting">{{ __('#') }}</th>
                                    <th class="sorting">{{ __('Full Name') }}</th>
                                    <th class="sorting">{{ __('Street Number') }}</th>
                                    <th class="sorting">{{ __('Building Number') }}</th>
                                    <th class="sorting">{{ __('Floor Number') }}</th>
                                    <th class="sorting">{{ __('Unit Number') }}</th>
                                    <th class="sorting">{{ __('Unit Name') }}</th>
                                    <th class="sorting">{{ __('Unit Type') }}</th>
                                    <th class="sorting">{{ __('System Number') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    {{-- floor --}}
    <div class="modal fade" id="show_floor_model" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">{{ __('Units') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <table class="datatables-basic table dataTable no-footer dtr-column" id="table_floor"
                                   aria-describedby="DataTables_Table_0_info" style="width: 1303px;">
                                <thead>
                                <tr>
                                    <th class="sorting">{{ __('#') }}</th>
                                    <th class="sorting">{{ __('Floor Number') }}</th>
                                    <th class="sorting">{{ __('Stores') }}</th>
                                    <th class="sorting">{{ __('Departments') }}</th>
                                    <th class="sorting">{{ __('Total Count') }}</th>
                                    <th class="sorting">{{ __('Notes') }}</th>
                                    <th class="sorting">{{ __('isLicensed') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    {{-- Craft --}}
    <div class="modal fade" id="show_craft_model" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">{{ __('Units') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <table class="datatables-basic table dataTable no-footer dtr-column" id="table_craft"
                                   aria-describedby="DataTables_Table_0_info" style="width: 1303px;">
                                <thead>
                                <tr>
                                    <th class="sorting">{{ __('#') }}</th>
                                    <th class="sorting">{{ __('Id Number') }}</th>
                                    <th class="sorting">{{ __('Mobile') }}</th>
                                    <th class="sorting">{{ __('Business Name') }}</th>
                                    <th class="sorting">{{ __('Address') }}</th>
                                    <th class="sorting">{{ __('Notes') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    {{-- subscription --}}
    <div class="modal fade" id="show_subscription_model" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">{{ __('Units') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <table class="datatables-basic table dataTable no-footer dtr-column" id="table_subscription"
                                   aria-describedby="DataTables_Table_0_info" style="width: 1303px;">
                                <thead>
                                <tr>
                                    <th class="sorting">{{ __('#') }}</th>
                                    <th class="sorting">{{ __('Id Number') }}</th>
                                    <th class="sorting">{{ __('Name') }}</th>
                                    <th class="sorting">{{ __('customer_number') }}</th>
                                    <th class="sorting">{{ __('Address') }}</th>
                                    <th class="sorting">{{ __('Mobile') }}</th>
                                    <th class="sorting">{{ __('Notes') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        $('.street_id').select2({
            allowClear: true,
            width: "100%",
            placeholder: "رقم الشارع",
        });
        $('.street_id').val('initial-value').trigger('change');

        $('.zone_id').select2({
            width: "100%",
            placeholder: "zone",
            allowClear: true
        });
        $('.subzone_id').select2({
            width: "100%",
            placeholder: "sub zone",
            allowClear: true
        });
        $('.buildingType').select2({
            width: "100%",
            placeholder: "تصنيف المبنى",
            allowClear: true
        });
        $('.subscription').select2({
            width: "100%",
            placeholder: "حالة الاشتراكات",
            allowClear: true
        });
        $('.craft').select2({
            width: "100%",
            placeholder: "حالة الحرف",
            allowClear: true
        });
        $('.license').select2({
            width: "100%",
            placeholder: "حالة الترخيص",
            allowClear: true
        });
        // =====================================
        $("#editClose").click(function () {
            $("#editFormData").fadeOut("fast");
        });
        // =====================================
        $("#addDataForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#addDataForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('zones.store') }}",
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
                    axios.delete("{{ url('/') }}" + '/home/zones/' + id)
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
        // =====================================
        //data for owner model with datatable
        $('body').on('click', '#showRow', function () {
            let id = $(this).data('id');
            // alert(id)
            $('#table_owner').dataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ url('/') }}" + '/home/buildings/get-owner-for-building/' + id,
                // language: {
                //     'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                // },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'id_card',
                    name: 'id_card',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'fullName',
                    name: 'fullName',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'mokalaf',
                    name: 'mokalaf',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'phone_number',
                        name: 'phone_number',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'notes',
                        name: 'notes',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        })
        // =====================================
        //data for unit model with datatable
        $('body').on('click', '#show_unit', function () {
            let id = $(this).data('id');
            // alert(id)
            $('#table_unit').dataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ url('/') }}" + '/home/buildings/get-unit-for-building/' + id,
                // language: {
                //     'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                // },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'unit_number',
                    name: 'unit_number',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'unit_owners',
                    name: 'unit_owners',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'building_number',
                        name: 'building_number',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'floor_number',
                        name: 'floor_number',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'unit_number',
                        name: 'unit_number',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'unit_name',
                        name: 'unit_name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'unit_type',
                        name: 'unit_type',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'system_number',
                        name: 'system_number',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        })
        // =====================================
        //data for floor model with datatable
        $('body').on('click', '#show_floor', function () {
            let id = $(this).data('id');
            // alert(id)
            $('#table_floor').dataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ url('/') }}" + '/home/buildings/get-floor-for-building/' + id,
                // language: {
                //     'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                // },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'floor_number',
                    name: 'floor_number',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'stores',
                    name: 'stores',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'departments',
                        name: 'departments',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'total_count',
                        name: 'total_count',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'notes',
                        name: 'notes',
                        orderable: false,
                        searchable: false
                    }, {
                        data: 'is_licensed',
                        name: 'is_licensed',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        })
        // =====================================
        //data for craft model with datatable
        $('body').on('click', '#show_craft', function () {
            let id = $(this).data('id');
            // alert(id)
            // $('#table_craft').dataTable({
            //     processing: true,
            //     bDestroy: true,
            //     serverSide: true,
            //     ajax: "{{ url('/') }}" + '/home/buildings/get-craft-for-building/' + id,
            //     // language: {
            //     //     'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
            //     // },
            //     columns: [{
            //             data: 'DT_RowIndex',
            //             name: 'DT_RowIndex',
            //             orderable: false,
            //             searchable: false
            //         }, {
            //             data: 'id_number',
            //             name: 'id_number',
            //             orderable: false,
            //             searchable: false
            //         }, {
            //             data: 'mobile',
            //             name: 'mobile',
            //             orderable: false,
            //             searchable: false
            //         },
            //         {
            //             data: 'business_name',
            //             name: 'business_name',
            //             orderable: false,
            //             searchable: false
            //         },
            //         {
            //             data: 'address',
            //             name: 'address',
            //             orderable: false,
            //             searchable: false
            //         },
            //         {
            //             data: 'notes',
            //             name: 'notes',
            //             orderable: false,
            //             searchable: false
            //         }
            //     ]
            // });

        })
        // =====================================
        //data for subscription model with datatable
        $('body').on('click', '#show_subscription', function () {
            let id = $(this).data('id');
            // alert(id)
            $('#table_subscription').dataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ url('/') }}" + '/home/buildings/get-subscription-for-building/' + id,
                // language: {
                //     'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                // },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'id_number',
                    name: 'id_number',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'name',
                    name: 'name',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'customer_number',
                    name: 'customer_number',
                    orderable: false,
                    searchable: false
                },
                    {
                        data: 'address',
                        name: 'address',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'mobile',
                        name: 'mobile',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'notes',
                        name: 'notes',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

        })
        // =====================================
        //add sub zone to form where zone selected
        $('.zone_id').on('change', function () {
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
                success: function (res) {
                    console.log(res);
                    $('#subzone_id').html('<option value="">-- Select City --</option>');
                    $.each(res.subzones, function (key, value) {
                        $("#subzone_id").append('<option value="' + value
                            .id + '">' + value.zone_number + '</option>');
                    });
                }
            });
        });
        // =====================================
        //deleteRowBuilding
        $('body').on('click', '#deleteBuilding', function (e) {
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
                    axios.delete("{{ url('/') }}" + '/home/buildings/' + id)
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
        $('#export_excel_btn').on('click', function () {
            axios({
                method: 'get',
                url: "{{ route('buildings.exportExcel') }}",
                params: {
                    id_card: $('#id_card').val(),
                    phone_number: $('#phone_number').val(),
                    file_number: $('#file_number').val(),
                    building_number: $('#building_number').val(),
                    first_name: $('#first_name').val(),
                    second_name: $('#second_name').val(),
                    third_name: $('#third_name').val(),
                    sur_name: $('#sur_name').val(),
                    mokalaf: $('#mokalaf').val(),
                    block_number: $('#block_number').val(),
                    parcel_number: $('#parcel_number').val(),
                    building_name: $('#building_name').val(),
                    street_id: $('#street_id').val(),
                    zone_id: $('#zone_id').val(),
                    subzone_id: $('#subzone_id').val(),
                    license: $('#license').val(),
                    building_type: $('#building_type').val(),
                    subscription: $('#subscription').val(),
                    craft: $('#craft').val(),
                },
                // responseType: 'blob' // مهم جداً للتأكد من أن الرد هو ملف بحد ذاته
            })
                .then(response => {
                    console.log(response.data.url)
                    toastr.success("جاري التنزيل")
                    window.open(
                        "{{url('/')}}" + '/' + response.data.url,
                        '_blank' // <- This is what makes it open in a new window.
                    );
                });

        });
    </script>
@endpush
