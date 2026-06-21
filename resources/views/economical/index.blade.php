@extends('layouts.master')
@section('title', 'الحرف')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
            <!-- Statistics -->
            <div class="col-xl-12 mb-4 col-lg-7 col-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                        <i class="ti ti-chart-pie-2 ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$data['all']}}</h5>
                                        <small>إجمالي عدد الحرف</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-info me-3 p-2">
                                        <i class="ti ti-users ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$data['licenced']}}</h5>
                                        <small>حرف مرخصة</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <i class="ti ti-shopping-cart ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$data['not_licenced']}}</h5>
                                        <small>حرف غير مرخصة</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-currency-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$data['not_approved']}}</h5>
                                        <small>حرف جديدة غير معتمدة</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-currency-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$data['closed']}}</h5>
                                        <small>حرف مغلقة</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics -->
</div>
        <div class="card">
            <div class="card-datatable pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0">الحرف</h5>
                        </div>
                        <div class="dt-action-buttons text-end pt-3 pt-md-0">
                            <div class="dt-buttons btn-group flex-wrap">
                                <div class="btn-group">
                                    {{-- <button
                                        class="btn btn-secondary buttons-collection dropdown-toggle btn-label-primary me-2 waves-effect"
                                        tabindex="0" aria-controls="DataTables_Table_0" type="button"
                                        aria-haspopup="dialog" aria-expanded="false"><span><i
                                                class="ti ti-file-export me-sm-1"></i> <span
                                                class="d-none d-sm-inline-block">Export</span></span><span
                                            class="dt-down-arrow"></span>
                                    </button> --}}
                                </div>
                                <div class="dt-buttons btn-group flex-wrap">

                                    <a href="javascript:;"
                                       class="btn btn-secondary create-new btn-warning waves-effect waves-light"
                                       id="add_craft_unit" data-bs-toggle="modal"
                                       data-bs-target="#craft_form_model" type="button"><span><i
                                                class="ti ti-plus me-sm-1">
                                                   </i> <span
                                                class="d-none d-sm-inline-block">طباعة طلب ترخيص</span></span>
                                    </a>
                                </div>
                                 <button class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                    id="add_new" tabindex="0" aria-controls="DataTables_Table_0" type="button" data-bs-toggle="modal"
                                               data-bs-target="#add_craft_model"><span><i
                                            class="ti ti-plus me-sm-1">
                                        </i> <span class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
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
    <div class="modal fade" id="craft_form_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">نموذج ترخيص حرفة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="printCraftForm" action="{{route('economical.printFrom')}}" class="p-3" method="post" enctype="multipart/form-data" target="_blank">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="bulding_id" value="">

                        <div class="row my-3">
                            <div class="text-light small fw-semibold">بيانات صاحب الحرفة:</div>
                            <div class="col-md-12 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الاسم صاحب الحرفة</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>

                            <div class="col-md-6 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الهوية</label>
                                <input type="text" class="form-control" name="id_card" required>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الجوال</label>
                                <input type="text" class="form-control" name="mobile" required>
                            </div>
                            <div class="col-md-12 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">العنوان</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="col-md-12 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم صاحب المبنى</label>
                                <input type="text" class="form-control" name="owner_name" value="" required>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم هوية صاحب المبنى</label>
                                <input type="text" class="form-control" name="owner_id_card" required>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم جوال صاحب المبنى</label>
                                <input type="text" class="form-control" name="owner_mobile" required>
                            </div>


                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">حالة الحرفة</label>
                                <select class="form-select " name="type_property" required>
                                    <option value="ملك">ملك</option>
                                    <option value="ايجار">إيجار</option>
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit">طباعة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="show_edit_craft_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">تعديل بيانات الحرفة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editCraft" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="id" id="craft_id">

                        <div class="row my-3">
                            <div class="text-light small fw-semibold">بيانات صاحب الحرفة:</div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الاسم الأول</label>
                                <input type="text" class="form-control" name="first_name" id="craft_first_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم الأب</label>
                                <input type="text" class="form-control" name="second_name"
                                       id="craft_second_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم الجد</label>
                                <input type="text" class="form-control" name="third_name" id="craft_third_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم العائلة</label>
                                <input type="text" class="form-control" name="sur_name" id="craft_sur_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم ملف الحرفة</label>
                                <input type="text" class="form-control" id="craft_number" name="craft_number">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الهوية</label>
                                <input type="number" class="form-control" name="id_card" id="craft_id_card">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم المكلف</label>
                                <input type="number" class="form-control" name="mokalaf" id="craft_mokalaf">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الاتصال</label>
                                <input type="number" class="form-control" name="phone_number"
                                       id="craft_phone_number">
                            </div>
                            <div class="col-md-12 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الاسم التجاري</label>
                                <input type="text" class="form-control" name="job_formal_name"
                                       id="craft_job_formal_name">
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">حالة الحرفة</label>
                                <select class="form-select " name="type_property" id="craft_type_property" required>
                                    <option value="1">ملك</option>
                                    <option value="0">إيجار</option>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                            <textarea class="form-control" name="notes" rows="3" id="craft_notes"></textarea>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_craft_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">أضف حرفة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNewCraft" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="bulding_id" id="bulding_id" value="">

                        <div class="row my-3">
                            <div class="text-light small fw-semibold">بيانات مالك المبنى:</div>
                            <div class="col-md-5 col-12 ">
                                <input type="text" class="form-control" name="street_number" id="street_number" placeholder="رقم الشارع" required>

                            </div>
                            <div class="col-md-5 col-12 ">
                                <input type="text" class="form-control" name="building_number" id="building_number" placeholder="رقم المبني" required>

                            </div>
                            <div class="col-md-2 col-12 ">
                                <button type="button" class="btn btn-warning" id="fetchBuilding">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                </button>

                            </div>
                            <div class="col-md-12 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">مالك المنزل</label>
                                <input type="text" class="form-control" name="building_owner" id="building_owner" required>

                            </div>
                            <div class="text-light small fw-semibold">بيانات صاحب الحرفة:</div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الاسم الأول</label>
                                <input type="text" class="form-control" name="first_name" required>
                                <input hidden name="created_by" type="text" value="{{Auth::id()}}">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم الأب</label>
                                <input type="text" class="form-control" name="second_name" required>
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم الجد</label>
                                <input type="text" class="form-control" name="third_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم العائلة</label>
                                <input type="text" class="form-control" name="sur_name" required>
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم ملف الحرفة</label>
                                <input type="text" class="form-control" name="craft_number">
                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الهوية</label>
                                <input type="text" class="form-control" name="id_card" required>
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم المكلف</label>
                                <input type="text" class="form-control" name="mokalaf" required>
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الاتصال</label>
                                <input type="text" class="form-control" name="phone_number" required>
                            </div>
                            <div class="col-md-12 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الاسم التجاري</label>
                                <input type="text" class="form-control" name="job_formal_name" required>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">تاريخ البداية</label>
                                <input type="date" class="form-control" value="{{\Carbon\Carbon::now()}}" name="creation_date" required>
                            </div>
                            <div class="col-md-6 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">تاريخ الانتهاء</label>
                                <input type="date" class="form-control" value="{{\Carbon\Carbon::now()}}" name="end_at" required>
                            </div>

                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">حالة الحرفة</label>
                                <select class="form-select " name="type_property" required>
                                    <option value="1">ملك</option>
                                    <option value="0">إيجار</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">مالك العقار</label>
                                <select class="form-select " name="building_owner_id" required>
                                </select>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الوحدة</label>
                                <select class="form-select " name="unit_id" id="unit_id" required>
                                </select>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">طبيعة الحرفة</label>
                                <select class="form-select " name="isDanger" required>
                                    <option value="0">عادية</option>
                                    <option value="1">خطرة</option>
                                </select>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">فئة الحرفة</label>
                                <select class="form-select " name="craft_category_id" required onchange="fillCraftTypes(this.value)">
                                    @foreach (\App\Models\CraftCategory::all() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم الحرفة</label>
                                <select class="form-select " name="craft_type_id" id="crafts_list">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">حالة الحرفة</label>
                            <select class="form-select " name="isActive" required ">
                            <option value="2">طلب جديد</option>
                            <option value="1">فعال</option>
                            <option value="0">مغلق</option>

                            </select>
                        </div>

                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
                        </div>
                        <hr>
                        <label>المرفقات</label>
                        <div class="col-md-12 col-12 mb-3 demo-inline-spacing" id="attchments_list">
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        <button class="btn btn-label-success waves-effect" type="submit">اعتماد</button>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    {!! $dataTable->scripts() !!}
    <script>
        //  $('.building_owner').select2({
        //     width: "100%",
        //     placeholder: "المبنى",
        //     allowClear: true
        // });
        $("#editCraft").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#editCraft')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('economical.update_data') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_craft').DataTable().ajax.reload();
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
        $('.building_owner').on('change',function(){
            let data = JSON.parse($(this).val());
            let i=0
            $('#units_area').empty()
            for(i=0;i<data.units.length;i++)
            {
                $('#units_area').append('<div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="'+ data.units[i].id+'">'
                                            + '<label class="form-check-label" for="inlineRadio1">'+ data.units[i].unit_number +'</label></div>')
            }
            console.log(data.units)
        })
          $('body').on('click', '#deleteRowEconomical', function (e) {
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
                        axios.delete("{{ url('/') }}" + '/home/economical/' + id)
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

            // fetch building data

            $('body').on('click', '#fetchBuilding', function (e)
            {
                e.preventDefault();
                $(this).empty();
                $(this).html('<div class="spinner-grow text-success mr-1" role="status"><span class="sr-only">Loading...</span></div>')

                        axios.get("{{ url('/home/fetchBuilding') }}" + '/' + $('#street_number').val() + '/' + $('#building_number').val())
                            .then(function (response) {
                                let data = response.data.body
                                console.log(data);
                                let owner = data.owner.first_name + ' ' + data.owner.second_name + ' ' + data.owner.third_name + ' ' + data.owner.sur_name
                                $('#building_owner').val(data.owner.first_name + ' ' + data.owner.second_name + ' ' + data.owner.third_name + ' ' + data.owner.sur_name )
                                $(this).empty();
                                $('#fetchBuilding').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>')
                                $('#unitsArea').empty()
                                let units = response.data.body.units
                                let i=0
                                for(i=0;i<units.length;i++)
                                {
                                    $('#unitsArea').append('<div class="card card-congratulation-medal unitCard"><div class="card-body"><h5>'+ units[i].unit_number +'</h5><p class="card-text font-small-3">مالك الوحدة: '+owner+'</p></div>')
                                }


                            }).catch(function (error) {
                            // console.log(error);
                            showMessage(error.response.data);
                        })

            });


            $('body').on('click', '.unitCard', function (e)
            {
                $('.unitCard').removeClass('bg-success');
                $(this).addClass('bg-success');


            });
            $('body').on('click', '#editRowCraft', function () {
                let id = $(this).data('id');
                let edit = "{{ url('/') }}" + '/home/economical/' + id + '/edit';
                axios.get(edit)
                    .then(function (res) {
                        console.log(res.data)
                        $('#craft_id').val(res.data.id)
                        $('#craft_first_name').val(res.data.owners.first_name)
                        $('#craft_second_name').val(res.data.owners.second_name)
                        $('#craft_third_name').val(res.data.owners.third_name)
                        $('#craft_sur_name').val(res.data.owners.sur_name)
                        $('#craft_id_card').val(res.data.owners.id_card)
                        $('#craft_mokalaf').val(res.data.owners.mokalaf)
                        $('#craft_phone_number').val(res.data.owners.phone_number)
                        $('#craft_job_formal_name').val(res.data.job_formal_name)
                        $('#craft_type_property').val(res.data.type_property)
                        $('#craft_building_owner_id').val(res.data.building_owner_id)
                        $('#craft_unit_id').val(res.data.unit_id)
                        $('#craft_notes').val(res.data.notes)
                        $('#craft_number').val(res.data.craft_number)


                    })
            })
        fillCraftTypes(1)
        function fillCraftTypes(category)
        {
            $('#crafts_list').empty()

            $('#crafts_list').append('<option>جاري التحميل ...</option>')


            axios({
                method: 'get',
                url: "{{ url('home/economical/getTypes/')}}" + "/" + category,
            })
                .then(function (response) {
                    console.log(response.data.attachments)
                    i=0;
                    types  = response.data.data;
                    files = response.data.attachments
                    $('#crafts_list').empty()

                    for(i==0;i<types.length;i++)
                    {
                        $('#crafts_list').append('<option value"'+ parseInt(types[i].id) +'">' + types[i].name +'</option>')
                    }
                    i=0;
                    $('#attchments_list').empty()
                    for(i==0;i<files.length;i++)
                    {
                        if(files[i].required == 0)
                        {
                            var req = '(اختياري)'
                            var color = 'btn-secondary'
                        }
                        else
                        {
                            var req = '(اجباري)'
                            var color = 'btn-primary'
                        }

                        $('#attchments_list').append('<label>' + files[i].name + req + '</label>'

                            + '<input type="file" id="attachment'+ files[i].id +'" name="attachments[]" class="form-control">')
                    }

                })

        }


        $('body').on('click', '#fetchBuilding', function (e)
        {
            e.preventDefault();
            $(this).empty();
            $(this).html('<div class="spinner-grow text-success mr-1" role="status"><span class="sr-only">Loading...</span></div>')

            axios.get("{{ url('/home/fetchBuilding') }}" + '/' + $('#street_number').val() + '/' + $('#building_number').val())
                .then(function (response) {
                    let data = response.data.body
                    console.log(data);
                    let owner = data.owner.first_name + ' ' + data.owner.second_name + ' ' + data.owner.third_name + ' ' + data.owner.sur_name
                    $('#building_owner').val(data.owner.first_name + ' ' + data.owner.second_name + ' ' + data.owner.third_name + ' ' + data.owner.sur_name )
                    $('#building_id').val(data.id)
                    $(this).empty();
                    $('#fetchBuilding').html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>')
                    $('#unitsArea').empty()
                    let units = response.data.body.units
                    let i=0
                    for(i=0;i<units.length;i++)
                    {
                        $('#unit_id').append('<option value="'+ units[i].id +'">'+ units[i].unit_number + ' - ' + units[i].floor_number + '</option>')
                    }


                }).catch(function (error) {
                // console.log(error);
                showMessage(error.response.data);
            })

        });

        function printLicence()
        {
            alert('لا يمكن طباعة الرخصة حيث أن بيانات الرخصة غير مكتملة')
        }
    </script>
@endpush
