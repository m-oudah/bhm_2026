@extends('layouts.master')
@section('title', __('Buildings'))
@section('stylesheet')
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
          rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet"/>
    <link href="https://unpkg.com/filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.css"
          rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <script type="text/javascript" src="{{url('editor/js/jquery.js')}}"></script> 
<script type="text/javascript" src="{{url('editor/js/bootstrap.js')}}"></script> 
<script type="text/javascript" src="{{url('editor/js/bootstrap-wysiwyg.js')}}"></script> 

<link href="{{url('editor/css/bootstrap-responsive.min.css')}}" rel="stylesheet">
<link href="{{url('editor/css/font-awesome.css')}}" rel="stylesheet">
<style>
.content{
	width: 80%;
	margin: 0 auto;
	margin-top: 50px;
}


#editor {
	max-height: 250px;
	height: 250px;
	background-color: white;
	border-collapse: separate; 
	border: 1px solid rgb(204, 204, 204); 
	padding: 10px; 
	box-sizing: content-box; 
	-webkit-box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset; 
	box-shadow: rgba(0, 0, 0, 0.0745098) 0px 1px 1px 0px inset;
	border-top-right-radius: 3px; border-bottom-right-radius: 3px;
	border-bottom-left-radius: 3px; border-top-left-radius: 3px;
	overflow: auto;
	outline: none;
}

#voiceBtn {
  width: 20px;
  color: transparent;
  background-color: transparent;
  transform: scale(2.0, 2.0);
  -webkit-transform: scale(2.0, 2.0);
  -moz-transform: scale(2.0, 2.0);
  border: transparent;
  cursor: pointer;
  box-shadow: none;
  -webkit-box-shadow: none;
}

div[data-role="editor-toolbar"] {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.dropdown-menu a {
  cursor: pointer;
}

</style>

<script src="{{url('editor/external/jquery.hotkeys.js')}}"></script>
<script src="{{url('editor/external/google-code-prettify/prettify.js')}}"></script>
<script src="{{url('editor/js/bootstrap-wysiwyg.js')}}"></script>
<script language="javascript">
function loadVal(){
	desc = $("#editor").html();
	document.form1.desc.value = desc;
}
</script>

@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="demo-inline-spacing">
                            <div class="list-group list-group-horizontal-md text-md-center m-0" role="tablist"
                                 style=" margin: 0 !important; ">
                                @if (Auth::user()->can('Read-LicenseForms'))
                                    <a class="list-group-item list-group-item-action active" id="home-list-item"
                                       data-bs-toggle="list" href="#info" aria-selected="true"
                                       role="tab">{{ __('Informations') }}</a>
                                @endif
                                @if (Auth::user()->can('Read-LicenseForms'))
                                    <a class="list-group-item list-group-item-action" id="home-list-item"
                                       data-bs-toggle="list" href="#report" aria-selected="true" role="tab">تقرير كشف
                                        تنظيمي</a>
                                @endif
                                @if (Auth::user()->can('Read-Floors'))
                                    <a class="list-group-item list-group-item-action" id="messages-list-item"
                                       data-bs-toggle="list" href="#floor" aria-selected="false" role="tab"
                                       tabindex="-1">الطوابق والتقرير المالي</a>
                                @endif
                                @if (Auth::user()->hasAnyPermission([
                                        'Legal-Opinions',
                                        'SurveyDepartment-Opinion',
                                        'UrbanPlanning-Opinion',
                                        'WaterDepartment-Opinion',
                                        'SewerDepartment-Opinion',
                                        'CollectionDepartment-Opinion','Show-Opinions'
                                    ]))
                                    <a class="list-group-item list-group-item-action" id="profile-list-item"
                                       data-bs-toggle="list" href="#opinion" aria-selected="false" role="tab"
                                       tabindex="-1">اّراء الأقسام</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="tab-content px-0 mt-0">
                {{-- ====================================================== --}}
                {{-- info --}}
                <div class="tab-pane fade active show" id="info" role="tabpanel" aria-labelledby="#home-list-item">
                    <div class="row">
                        <div class="col-xl-12 order-0 order-md-1">
                            <!-- Project table -->
                            <div class="card mb-4">
                                <div class="mb-3">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                        <form id="editInfo" enctype="multipart/form-data">
                                            @method('put')
                                            @csrf

                                            <div class="row my-3">
                                                <div class="timeline-header border-bottom mb-3">
                                                    <h6 class="mb-0">اّخر تحديث</h6>
                                                    <span
                                                        class="text-muted">{{ $licenseForm->updated_at->format('Y-m-d') ?? '' }}</span>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">موضوع
                                                        الطلب</label>
                                                    <input type="text" class="form-control" name="subject"
                                                           value="{{ $licenseForm->subject }}"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="text-light small fw-semibold">بيانات الأرض:</div>

                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput" class="form-label">رقم
                                                            المبنى:</label>
                                                        <input type="text" class="form-control" name="building_number"
                                                               id="e_building_number"
                                                               value="{{ $licenseForm->building_number }}"
                                                            {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput" class="form-label">رقم
                                                            القطعة:</label>
                                                        <input type="number" class="form-control" name="block_number"
                                                               value="{{ $licenseForm->block_number }}"
                                                            {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput" class="form-label">رقم
                                                            القسيمة:</label>
                                                        <input type="number" class="form-control" name="parcel_number"
                                                               value="{{ $licenseForm->parcel_number }}"
                                                            {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput"
                                                               class="form-label">المنطقة</label>
                                                        <input type="text" class="form-control" name="region"
                                                               value="{{ $licenseForm->region }}"
                                                            {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="text-light small fw-semibold">بيانات المالك:</div>

                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">الاسم
                                                        الأول</label>
                                                    <input type="text" class="form-control" name="first_name"
                                                           required=""
                                                           value="{{ $licenseForm->owner->first_name ?? '' }}"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">اسم
                                                        الأب</label>
                                                    <input type="text" class="form-control" name="second_name"
                                                           required=""
                                                           value="{{ $licenseForm->owner->second_name ?? '' }}"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">اسم
                                                        الجد</label>
                                                    <input type="text" class="form-control" name="third_name"
                                                           required=""
                                                           value="{{ $licenseForm->owner->third_name ?? '' }}"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">اسم
                                                        العائلة</label>
                                                    <input type="text" class="form-control" name="sur_name"
                                                           required="" value="{{ $licenseForm->owner->sur_name ?? '' }}"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">رقم
                                                        الهوية</label>
                                                    <input type="number" class="form-control" name="id_card"
                                                           required="" value="{{ $licenseForm->owner->id_card ?? '' }}"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">رقم
                                                        المكلف</label>
                                                    <input type="number" class="form-control" name="mokalaf"
                                                           value="{{ $licenseForm->owner->mokalaf ?? '' }}"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">رقم
                                                        الاتصال</label>
                                                    <input type="text" class="form-control" name="phone_number"
                                                           required=""
                                                           value="{{ $licenseForm->owner->phone_number ?? '' }}"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-12 col-12 mb-3">
                                                    <label for="defaultFormControlInput" class="form-label">ملاحظات حول
                                                        المالك</label>
                                                    <textarea class="form-control" name="notes" rows="3"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>{{ $licenseForm->owner->notes ?? '' }}</textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="text-light small fw-semibold">المرفقات:</div>
                                            <div class="row">
                                                <div class="col-md-4 col-12 mb-3">
                                                    <label for="formFile" class="form-label">سندات الملكية</label>
                                                    <input class="form-control" type="file" name="title_deedPhoto"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        @if($licenseForm->deedPhoto)
                                                        <a href="{{url($licenseForm->deedPhoto->url)}}" target="_blanck" class="btn btn-success">عرض الملف</a>
                                                        @endif
                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <label for="formFile" class="form-label">بيان الشروط
                                                        التنظيمية</label>
                                                    <input class="form-control" type="file"
                                                           name="general_site_planPhoto"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        @if($licenseForm->generalSitePhoto)
                                                        <a href="{{url($licenseForm->generalSitePhoto->url)}}" target="_blanck" class="btn btn-success">عرض الملف</a>
                                                        @endif

                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <label for="formFile" class="form-label">مخططات البناء</label>
                                                    <input class="form-control" type="file"
                                                           name="construction_mapPhoto"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        @if($licenseForm->constructionMaphoto)
                                                        <a href="{{url($licenseForm->constructionMaphoto->url)}}" target="_blanck" class="btn btn-success">عرض الملف</a>
                                                        @endif


                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <label for="formFile" class="form-label">تعهد بالإشراف</label>
                                                    <input class="form-control" type="file"
                                                           name="undertaking_supervisePhoto"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        @if($licenseForm->undertakingSupervisePhoto)
                                                        <a href="{{url($licenseForm->undertakingSupervisePhoto->url)}}" target="_blanck" class="btn btn-success">عرض الملف</a>
                                                        @endif
                                                        
                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <label for="formFile" class="form-label">مصادقات جهات أخرى</label>
                                                    <input class="form-control" type="file"
                                                           name="aprobaciones_tercerosPhoto"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        @if($licenseForm->aprobacionesTercerosPhoto)
                                                        <a href="{{url($licenseForm->aprobacionesTercerosPhoto->url)}}" target="_blanck" class="btn btn-success">عرض الملف</a>
                                                        @endif

                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <label for="formFile" class="form-label"> 1 ملفات اخرى</label>
                                                    <input class="form-control" type="file"
                                                           name="attachment_one"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        @if($licenseForm->attachmentOne)
                                                        <a href="{{url($licenseForm->attachmentOne->url?? '#')}}" target="_blanck" class="btn btn-success">عرض الملف</a>
                                                        @endif

                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <label for="formFile" class="form-label"> 2 ملفات اخرى</label>
                                                    <input class="form-control" type="file"
                                                           name="attachmentTow"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        @if($licenseForm->attachmentTow)
                                                        <a href="{{url($licenseForm->attachmentTow->url?? '#')}}" target="_blanck" class="btn btn-success">عرض الملف</a>
                                                        @endif

                                                </div>
                                                <div class="col-md-4 col-12 mb-3">
                                                    <label for="formFile" class="form-label"> 3 ملفات اخرى</label>
                                                    <input class="form-control" type="file"
                                                           name="attachmentThree"
                                                        {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        @if($licenseForm->attachmentThree)
                                                        <a href="{{url($licenseForm->attachmentThree->url?? '#')}}" target="_blanck" class="btn btn-success">عرض الملف</a>
                                                        @endif

                                                </div>

                                            </div>
                                            <div class="col-12 my-3">
                                                <button class="btn btn-label-primary waves-effect"
                                                    {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>حفظ
                                                    البيانات
                                                </button>
                                                @if (Auth::user()->can('FinalConfirmation'))
                                                    <a href="javascript:;" id="conversion"
                                                       class="btn btn-label-info waves-effect">اعتماد
                                                        نهائي</a>
                                                @endif
                                                @if (Auth::user()->can('LicensePrint'))
                                                    <a href="{{ route('license_forms.print', $licenseForm->id) }}"
                                                       target="_blank" type="button"
                                                       class="btn btn-label-success waves-effect">طباعة الطلب</a>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- /Project table -->
                        </div>
                    </div>
                </div>
                {{-- ====================================================== --}}
                {{-- report --}}
                <div class="tab-pane fade " id="report" role="tabpanel" aria-labelledby="#home-list-item">
                    <div class="row">
                        <div class="col-xl-12 order-0 order-md-1">
                            <!-- Project table -->
                            <div class="card mb-4">
                                <div class="mb-3">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                        <form id="regulatory_disclosure_report" class="py-3  mx-2"
                                              enctype="multipart/form-data">
                                            @method('put')
                                            @csrf
                                            <div class="timeline-header border-bottom mb-3">
                                                <h6 class="mb-0">اّخر تحديث</h6>
                                                <span
                                                    class="text-muted">{{ $licenseForm->report->updated_at->format('Y-m-d') ?? '' }}</span>
                                            </div>
                                            <input type="hidden" name="license_form_id" value="{{ $licenseForm->id }}">
                                            <div class="row">
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1"
                                                           class="form-label">المستدعي</label>
                                                    <select class="form-select" name="isproperty"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                        <option
                                                            value="1" @selected($licenseForm->report->isproperty == '1')>
                                                            يملك
                                                        </option>
                                                        <option
                                                            value="0" @selected($licenseForm->report->isproperty == '0')>
                                                            مستأجر
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1"
                                                           class="form-label">القسيمة</label>
                                                    <select class="form-select" name="isorted"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                        <option
                                                            value="1" @selected($licenseForm->report->isorted == '1')>
                                                            مفروزة
                                                        </option>
                                                        <option
                                                            value="0" @selected($licenseForm->report->isorted == '0')>
                                                            غير مفروزة
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1"
                                                           class="form-label">المنطقة</label>
                                                    <select class="form-select" name="region"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                        <option
                                                            value="1" @selected($licenseForm->report->region == '1')>
                                                            سكنية
                                                        </option>
                                                        <option
                                                            value="2" @selected($licenseForm->report->region == '2')>
                                                            تجارية
                                                        </option>
                                                        <option
                                                            value="3" @selected($licenseForm->report->region == '3')>
                                                            زراعية
                                                        </option>
                                                        <option
                                                            value="4" @selected($licenseForm->report->region == '4')>
                                                            زراعية مساعدة
                                                        </option>
                                                        <option
                                                            value="5" @selected($licenseForm->report->region == '5')>
                                                            صناعية
                                                        </option>
                                                        <option
                                                            value="6" @selected($licenseForm->report->region == '6')>
                                                            سياحية
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">حالة
                                                        الموقع
                                                        وقت تقديم الطلب</label>
                                                    <select class="form-select" name="location_status"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                        <option
                                                            value="1" @selected($licenseForm->report->location_status == '1')>
                                                            فراغ
                                                        </option>
                                                        <option
                                                            value="2" @selected($licenseForm->report->location_status == '2')>
                                                            تحت الإنشاء
                                                        </option>
                                                        <option
                                                            value="3" @selected($licenseForm->report->location_status == '3')>
                                                            تام الإنشاء
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">المساحة
                                                        الكلية</label>
                                                    <input type="number" class="form-control" name="total_coupon_space"
                                                           id="total_coupon_space"
                                                           value="{{ $licenseForm->report->total_coupon_space }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">مساحة
                                                        البناء</label>
                                                    <input type="number" class="form-control" name="building_area"
                                                           id="building_area"
                                                           value="{{ $licenseForm->report->building_area }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">نسبة
                                                        البناء</label>
                                                    <input type="number" class="form-control" name="construction_ratio"
                                                           id="construction_ratio"
                                                           value="{{ $licenseForm->report->construction_ratio }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">عدد
                                                        الطوابق</label>
                                                    <input type="number" class="form-control" name="number_floor"
                                                           value="{{ $licenseForm->report->number_floor }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">مساحة
                                                        التطوير</label>
                                                    <input type="number" class="form-control" name="development_area"
                                                           value="{{ $licenseForm->report->development_area }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">الارتدادات
                                                        فرونت</label>
                                                    <input type="text" class="form-control" name="rebounds_front"
                                                           value="{{ $licenseForm->report->rebounds_front }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">الارتدادات
                                                        باك</label>
                                                    <input type="text" class="form-control" name="rebounds_back"
                                                           value="{{ $licenseForm->report->rebounds_back }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">الارتدادات
                                                        يمين</label>
                                                    <input type="text" class="form-control" name="rebounds_right"
                                                           value="{{ $licenseForm->report->rebounds_right }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                                <div class="col-md-3 col-12 mb-3">
                                                    <label for="exampleFormControlSelect1" class="form-label">الارتدادات
                                                        شمال</label>
                                                    <input type="text" class="form-control" name="rebounds_left"
                                                           value="{{ $licenseForm->report->rebounds_left }}"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 col-12 mb-3">
                                                    <label for="purpose_building_use" class="form-label">هدف استعمال
                                                        البناء
                                                    </label>
                                                    <textarea class="form-control" name="purpose_building_use" rows="3"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>{{ $licenseForm->report->purpose_building_use }}</textarea>
                                                </div>
                                                <div class="col-md-12 col-12 mb-3">
                                                    <label for="site_on_structural" class="form-label">الموقع على شارع
                                                        أو
                                                        شوارع هيكلية أو تفصيلية أو تنظيمية
                                                    </label>
                                                    <textarea class="form-control" name="site_on_structural" rows="3"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>{{ $licenseForm->report->site_on_structural }}</textarea>
                                                </div>
                                                <div class="col-md-12 col-12 mb-3">
                                                    <label for="passes_through_site" class="form-label">يمر بالموقع شارع
                                                        أو شوارع هيكيلية أو تفصيلية أو مساحية
                                                    </label>
                                                    <textarea class="form-control" name="passes_through_site" rows="3"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>{{ $licenseForm->report->passes_through_site }}</textarea>
                                                </div>
                                                <div class="col-md-12 col-12 mb-3">
                                                    <label for="territory_regulatory_requirement"
                                                           class="form-label">الشروط التنظيمية للمنطقة
                                                    </label>
                                                    <textarea class="form-control"
                                                              name="territory_regulatory_requirement" rows="3"
                                                        {{ Auth::user()->can('Update-RegulatoryDisclosureReport') ? '' : 'disabled' }}>{{ $licenseForm->report->territory_regulatory_requirement }}</textarea>
                                                </div>
                                              
                                                <div class="col-md-12 col-12 mb-3">
                                                    <label for="department_notes" class="form-label">ملاحظات دائرة
                                                        التنظيم
                                                    </label>
                                                    <textarea class="form-control" name="department_notes" rows="3"
                                                        {{ Auth::user()->can('DepartmentNotes') ? '' : 'disabled' }}>{{ $licenseForm->report->department_notes }}</textarea>
                                                        <textarea rows="2" name="desc" cols="20" style="display:none; " > Enter your text here.. </textarea>

                                                </div>
                                            </div>
                                            <hr>
                                            <div class="col-12 mt-3">
                                                @if(Auth::user()->can('Update-RegulatoryDisclosureReport'))
                                                    <button class="btn btn-label-primary waves-effect"
                                                            id="save_regulatory_disclosure_report" type="button">حفظ
                                                        البيانات
                                                    </button>
                                                @endif
                                                @if (Auth::user()->can('FinalConfirmation'))
                                                    <button class="btn btn-label-info waves-effect"
                                                            id="confirm_regulatory_disclosure_report" type="button"
                                                            name="trust" value="trust">اعتماد
                                                    </button>
                                                @endif

                                                @if(Auth::user()->can('LicensePrint'))
                                                    <a href="{{ route('license_forms.printRegulatory', $licenseForm->id) }}"
                                                       target="_blank" type="button"
                                                       class="btn btn-label-success waves-effect">طباعة الطلب</a>                                                  
                                                      <a href="{{ route('license_forms.printFania', $licenseForm->id) }}"
                                                       target="_blank" type="button"
                                                       class="btn btn-label-warning waves-effect">طباعة نموذج اللجنة الفنية</a>


                                                @endif
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                            <!-- /Project table -->
                        </div>
                    </div>
                </div>
                {{-- ====================================================== --}}
                {{-- floor --}}
                <div class="tab-pane fade" id="floor" role="tabpanel" aria-labelledby="#messages-list-item">
                    <div class="col-xl-12 order-0 order-md-1">
                        <div class="card mb-4">
                            <div class="dt-action-buttons text-end pt-3 pt-md-0 m-3">
                                <div class="dt-buttons btn-group flex-wrap">
                                    @if (Auth::user()->can('Create-Floor'))
                                        <a href="javascript:;"
                                           class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                           id="add_new_floor" data-bs-toggle="modal"
                                           data-bs-target="#show_add_floor_model"
                                           type="button"><span><i class="ti ti-plus me-sm-1">
                                        </i> <span class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
                                        </a>
                                        <a href="{{route('license_forms.printFloor', $licenseForm->id)}}" target="_blank"
                                           class="btn btn-secondary create-new btn-primary waves-effect waves-light mx-2"><span><i class="ti ti-plus me-sm-1">
                                        </i> <span class="d-none d-sm-inline-block">طباعة</span></span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <div id="DataTables_Table_0_wrapper"
                                     class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                    <table class="datatables-basic table dataTable no-footer dtr-column"
                                           id="table_floor"
                                           aria-describedby="DataTables_Table_0_info">
                                        <thead>
                                        <tr>
                                            <th class="sorting">{{ __('#') }}</th>
                                            <th class="sorting">{{ __('Floor Number') }}</th>
                                            <th class="sorting">المساحة الكلية</th>
                                            <th class="sorting">المرخصة سابقا</th>
                                            <th class="sorting">المراد ترخيصه</th>
                                            <th class="sorting">سعر الترخيص لكل متر</th>
                                            <th class="sorting">الملبغ الإجمالي</th>
                                            <th class="sorting">الملبغ الإجمالي بعد الخصم</th>
                                            {{--                                            <th class="sorting">نسبة الخصم</th>--}}
                                            <th class="sorting">قيمة الخصم</th>
                                            <th class="sorting">المبلغ المدفوع</th>
                                            <th class="sorting">المبلغ المتبقي</th>
                                            <th class="sorting">حالة الترخيص</th>
                                            <th class="sorting">{{ __('Control') }}</th>
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
                {{-- ====================================================== --}}
                {{-- opinion --}}
                <div class="tab-pane fade" id="opinion" role="tabpanel" aria-labelledby="#messages-list-item">
                    <div class="col-xl-12 order-0 order-md-1">
                        <div class="card mb-4">
                            {{--الرأي القانوني--}}
                            <form id="legal_opinForm" class="py-3  mx-3" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="legal_opinion" class="form-label">الرأي القانوني</label><br>
                                        @if ($licenseForm->legal_opin)
                                            <label class="text-muted">اّخر تحديث :
                                                {{ $licenseForm->legal_opin->updated_at->format('Y-m-d') ?? '' }}
                                                بواسطة
                                                :
                                                {{ $licenseForm->legal_opin->user->name }}</label>
                                            @if ($licenseForm->legal_opin->status == 1)
                                                <span class="badge rounded-pill bg-success m-2">معتمد</span>
                                            @endif
                                        @endif
                                        <textarea class="form-control" name="legal_opinion" id="legal_opinion"
                                                  rows="3"
                                            {{ Auth::user()->can('Legal-Opinions') ? '' : 'disabled' }}>{{ $licenseForm->legal_opin->reply ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        @if(Auth::user()->can('Legal-Opinions'))
                                            @if($licenseForm->legal_opin)
                                                @if($licenseForm->legal_opin->status == 0)
                                                    <button class="btn btn-label-primary waves-effect"
                                                            type="submit">حفظ
                                                    </button>
                                                    <button id="trust" type="button"
                                                            class="btn btn-label-success waves-effect m-2"
                                                            data-bs-toggle="modal" data-bs-target="#trustModal"
                                                            data-id="1">
                                                        اعتماد الرأي
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                </button>

                                                <button id="trust" type="button"
                                                        class="btn btn-label-success waves-effect m-2"
                                                        data-bs-toggle="modal" data-bs-target="#trustModal"
                                                        data-id="1">
                                                    اعتماد نهائي
                                                </button>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            </form>
                            {{--رأي قسم المساحة--}}
                            <form id="SurveyDepartmentForm" class="py-3  mx-3" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="area_opinion" class="form-label">رأي قسم المساحة</label><br>
                                        @if ($licenseForm->area_opin)
                                            <label class="text-muted">اّخر تحديث :
                                                {{ $licenseForm->area_opin->updated_at->format('Y-m-d') ?? '' }} بواسطة
                                                :
                                                {{ $licenseForm->area_opin->user->name }}</label>
                                            @if ($licenseForm->area_opin->status == 1)
                                                <span class="badge rounded-pill bg-success m-2">معتمد</span>
                                            @endif
                                        @endif
                                        <textarea class="form-control" name="area_opinion" id="area_opinion" rows="3"
                                            {{ Auth::user()->can('SurveyDepartment-Opinion') ? '' : 'disabled' }}>{{ $licenseForm->area_opin->reply ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        @if(Auth::user()->can('SurveyDepartment-Opinion'))
                                            @if($licenseForm->area_opin)
                                                @if($licenseForm->area_opin->status == 0)
                                                    <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                    </button>
                                                    <button id="trustSurveyDepartment" type="button"
                                                            class="btn btn-label-success waves-effect m-2"
                                                            data-bs-toggle="modal" data-bs-target="#trustModal">
                                                        اعتماد الرأي
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                </button>

                                                <button id="trustSurveyDepartment" type="button"
                                                        class="btn btn-label-success waves-effect m-2"
                                                        data-bs-toggle="modal" data-bs-target="#trustModal" data-id="1">
                                                    اعتماد نهائي
                                                </button>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            </form>
                            {{--رأي قسم التخطيط الحضري--}}
                            <form id="plan_opinForm" class="py-3  mx-3" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="plan_opinion" class="form-label">رأي قسم التخطيط
                                            الحضري</label><br>
                                        @if ($licenseForm->plan_opin)
                                            <label class="text-muted">اّخر تحديث :
                                                {{ $licenseForm->plan_opin->updated_at->format('Y-m-d') ?? '' }}
                                                بواسطة :
                                                {{ $licenseForm->plan_opin->user->name }}</label>
                                            @if ($licenseForm->plan_opin->status == 1)
                                                <span class="badge rounded-pill bg-success m-2">معتمد</span>
                                            @endif
                                        @endif
                                        <textarea class="form-control" name="plan_opinion" id="plan_opinion" rows="3"
                                            {{ Auth::user()->can('UrbanPlanning-Opinion') ? '' : 'disabled' }}>{{ $licenseForm->plan_opin->reply ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        @if(Auth::user()->can('UrbanPlanning-Opinion'))
                                            @if($licenseForm->plan_opin)
                                                @if($licenseForm->plan_opin->status == 0)
                                                    <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                    </button>
                                                    <button id="trustplan_opin" type="button"
                                                            class="btn btn-label-success waves-effect m-2"
                                                            data-bs-toggle="modal" data-bs-target="#trustModal">
                                                        اعتماد الرأي
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                </button>

                                                <button id="trustplan_opin" type="button"
                                                        class="btn btn-label-success waves-effect m-2"
                                                        data-bs-toggle="modal" data-bs-target="#trustModal" data-id="1">
                                                    اعتماد نهائي
                                                </button>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            </form>
                            {{-- رأي قسم المياه--}}
                            <form id="WaterDepartmentForm" class="py-3  mx-3" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="water_opinion" class="form-label">رأي قسم المياه </label><br>
                                        @if ($licenseForm->water_opin)
                                            <label class="text-muted">اّخر تحديث :
                                                {{ $licenseForm->water_opin->updated_at->format('Y-m-d') ?? '' }}
                                                بواسطة :
                                                {{ $licenseForm->water_opin->user->name }}</label>
                                            @if ($licenseForm->water_opin->status == 1)
                                                <span class="badge rounded-pill bg-success m-2">معتمد</span>
                                            @endif
                                        @endif
                                        <textarea class="form-control" name="water_opinion" id="water_opinion" rows="3"
                                            {{ Auth::user()->can('WaterDepartment-Opinion') ? '' : 'disabled' }}>{{ $licenseForm->water_opin->reply ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        @if(Auth::user()->can('WaterDepartment-Opinion'))
                                            @if($licenseForm->water_opin)
                                                @if($licenseForm->water_opin->status == 0)
                                                    <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                    </button>
                                                    <button id="trustWaterDepartment" type="button"
                                                            class="btn btn-label-success waves-effect m-2"
                                                            data-bs-toggle="modal" data-bs-target="#trustModal">
                                                        اعتماد الرأي
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                </button>

                                                <button id="trustWaterDepartment" type="button"
                                                        class="btn btn-label-success waves-effect m-2"
                                                        data-bs-toggle="modal" data-bs-target="#trustModal">
                                                    اعتماد نهائي
                                                </button>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            </form>
                            {{-- رأي قسم المجاري--}}
                            <form id="SewerDepartmentForm" class="py-3  mx-3" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="sewer_opinion" class="form-label">رأي قسم المجاري </label><br>
                                        @if ($licenseForm->sewer_opin)
                                            <label class="text-muted">اّخر تحديث :
                                                {{ $licenseForm->sewer_opin->updated_at->format('Y-m-d') ?? '' }} بواسطة
                                                :
                                                {{ $licenseForm->sewer_opin->user->name }}</label>
                                            @if ($licenseForm->sewer_opin->status == 1)
                                                <span class="badge rounded-pill bg-success m-2">معتمد</span>
                                            @endif
                                        @endif
                                        <textarea class="form-control" name="sewer_opinion" id="sewer_opinion" rows="3"
                                            {{ Auth::user()->can('SewerDepartment-Opinion') ? '' : 'disabled' }}>{{ $licenseForm->sewer_opin->reply ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        @if(Auth::user()->can('SewerDepartment-Opinion'))
                                            @if($licenseForm->sewer_opin)
                                                @if($licenseForm->sewer_opin->status == 0)
                                                    <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                    </button>
                                                    <button id="trustsewer_opin" type="button"
                                                            class="btn btn-label-success waves-effect m-2"
                                                            data-bs-toggle="modal" data-bs-target="#trustModal">
                                                        اعتماد الرأي
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                </button>

                                                <button id="trustsewer_opin" type="button"
                                                        class="btn btn-label-success waves-effect m-2"
                                                        data-bs-toggle="modal" data-bs-target="#trustModal">
                                                    اعتماد نهائي
                                                </button>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            </form>
                            {{-- رأي قسم الجباية--}}
                            <form id="CollectionDepartmentForm" class="py-3  mx-3" enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="collection_opinion" class="form-label">رأي قسم الجباية
                                        </label><br>
                                        @if ($licenseForm->collection_opin)
                                            <label class="text-muted">اّخر تحديث :
                                                {{ $licenseForm->collection_opin->updated_at->format('Y-m-d') ?? '' }}
                                                بواسطة :
                                                {{ $licenseForm->collection_opin->user->name }}</label>
                                            @if ($licenseForm->collection_opin->status == 1)
                                                <span class="badge rounded-pill bg-success m-2">معتمد</span>
                                            @endif
                                        @endif
                                        <textarea class="form-control" name="collection_opinion" id="collection_opinion"
                                                  rows="3"
                                            {{ Auth::user()->can('CollectionDepartment-Opinion') ? '' : 'disabled' }}>{{ $licenseForm->collection_opin->reply ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        @if(Auth::user()->can('CollectionDepartment-Opinion'))
                                            @if($licenseForm->collection_opin)
                                                @if($licenseForm->collection_opin->status == 0)
                                                    <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                    </button>
                                                    <button id="trustCollectionDepartment" type="button"
                                                            class="btn btn-label-success waves-effect m-2"
                                                            data-bs-toggle="modal" data-bs-target="#trustModal">
                                                        اعتماد الرأي
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                </button>

                                                <button id="trustCollectionDepartment" type="button"
                                                        class="btn btn-label-success waves-effect m-2"
                                                        data-bs-toggle="modal" data-bs-target="#trustModal">
                                                    اعتماد نهائي
                                                </button>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            </form>
                            {{-- رأي قسم GIS--}}
                            <form id="Gis_opinionForm" class="py-3  mx-3"
                                  enctype="multipart/form-data">
                                @method('put')
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="collection_opinion" class="form-label">رأي قسم GIS
                                        </label><br>
                                        @if ($licenseForm->gis_opin)
                                            <label class="text-muted">اّخر تحديث :
                                                {{ $licenseForm->gis_opin->updated_at->format('Y-m-d') ?? '' }}
                                                بواسطة :
                                                {{ $licenseForm->gis_opin->user->name }}</label>
                                            @if ($licenseForm->gis_opin->status == 1)
                                                <span class="badge rounded-pill bg-success m-2">معتمد</span>
                                            @endif
                                        @endif
                                        <textarea class="form-control" name="gis_opinion" id="gis_opinion" rows="3"
                                            {{ Auth::user()->can('Gis-Opinion') ? '' : 'disabled' }}>{{ $licenseForm->gis_opin->reply ?? '' }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        @if(Auth::user()->can('Gis-Opinion'))
                                            @if($licenseForm->gis_opin)
                                                @if($licenseForm->gis_opin->status == 0)
                                                    <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                    </button>
                                                    <button id="trustGis" type="button"
                                                            class="btn btn-label-success waves-effect m-2"
                                                            data-bs-toggle="modal" data-bs-target="#trustModal">
                                                        اعتماد الرأي
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-label-primary waves-effect" type="submit">حفظ
                                                </button>

                                                <button id="trustGis" type="button"
                                                        class="btn btn-label-success waves-effect m-2"
                                                        data-bs-toggle="modal" data-bs-target="#trustModal">
                                                    اعتماد نهائي
                                                </button>
                                            @endif

                                        @endif
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12">
                                                    <a href="{{route('license_forms.printOpin',$licenseForm->id)}}" target="_blanck" class="btn btn-label-success waves-effect m-2">
                                                        طباعة الآراء
                                </a>
                                    </div>
                        </div>
                    </div>
                </div>
                {{-- ====================================================== --}}
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    {{-- Add Floor --}}
    <div class="modal fade" id="show_add_floor_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">إضافة طابق جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNewFloor" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="license_form_id" value="{{ $licenseForm->id }}">

                        @if(Auth::user()->can('Create-Floor-Data'))
                            <div class="row">
                                <div class="text-light small fw-semibold">بيانات المبنى</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1" class="form-label">رقم الدور</label>
                                <select class="form-select " name="floor_number" id="floor_number">
                                    <option value="">أختر الدور</option>
                                    <option value="10" >بدروم
                                    </option>

                                    <option value="0" >ارضي سكني
                                    <option value="100" >ارضي تجاري
                                    </option>
                                    <option value="1" >أول
                                    </option>
                                    <option value="2" >ثاني
                                    </option>
                                    <option value="3">ثالث
                                    </option>
                                    <option value="4" >رابع
                                    </option>
                                    <option value="5" >خامس
                                    </option>
                                    <option value="6" >سادس
                                    </option>
                                    <option value="7">سابع
                                    </option>
                                    <option value="8" >ثامن
                                    </option>
                                    <option value="9" >روف
                                    </option>
                                    <option value="11" >بركس تجاري
                                    </option>
                                    <option value="12">بركس مزرعة دواجن
                                    </option>
                                    <option value="13" >بركس مزرعة ابقار
                                    </option>
                                    <option value="14" >بركس
                                    </option>


                                </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1" class="form-label">الحالة</label>
                                    <select class="form-select " name="is_licensed">
                                        <option value="1">غير مرخص</option>
                                        <option value="2">مرخص وغير مستوفي الشروط</option>
                                        <option value="4">مرخص ومستوفي الشروط</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المساحة المراد
                                        ترخيصها</label>
                                    <input type="text" class="form-control" name="area" id="area">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المرخصة سابقا</label>
                                    <input type="text" class="form-control" name="area_before" id="area_before">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم طلب الترخيص</label>
                                    <input type="text" class="form-control" name="lic_number">
                                </div>
                            </div>
                        @endif
                        <hr>
                        @if(Auth::user()->can('Create-Floor-Financial'))
                            <div class="row">
                                <div class="text-light small fw-semibold">بيانات الترخيص</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المساحة المرخصة</label>
                                    <input type="number" class="form-control" name="licensed_area" id="licensed_area">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">سعر الترخيص لكل متر</label>
                                    <input type="number" class="form-control" name="lic_per_meter" id="lic_per_meter">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">نسبة الخصم</label>
                                    <input type="text" class="form-control" name="lic_fees_discount"
                                           id="lic_fees_discount">
                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المبلغ المدفوع</label>
                                    <input type="number" class="form-control" name="license_fees">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم إيصال الدفع</label>
                                    <input type="text" class="form-control" name="payment_number" id="payment_number">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي</label>
                                    <input type="number" class="form-control" id="total" value="0" disabled>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">قيمة الخصم</label>
                                    <input type="number" class="form-control" id="lic_fees_disc_val" value="0"
                                           disabled>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي بعد
                                        الخصم</label>
                                    <input type="number" class="form-control" id="required_pay" value="0" disabled>
                                </div>
                                <div class="col-md-12 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                                    <textarea class="form-control" name="floors_notes" rows="3"></textarea>
                                </div>
                            </div>
                        @endif
                        <hr>
                        <div id="devlopment" style="display: none">
                            <div class="row">
                                <div class="text-light small fw-semibold">بيانات التطوير</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">مساحة الأرض</label>
                                    <input type="number" class="form-control" name="dev_buliding_area"
                                           id="dev_buliding_area"
                                           value="{{ $licenseForm->report->development_area ?? '' }}">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">سعر التطوير لكل
                                        متر</label>
                                    <input type="number" class="form-control" name="dev_price_per_meter"
                                           id="dev_price_per_meter">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">نسبة الخصم</label>
                                    <input type="number" class="form-control" name="discount" id="dev_discount">
                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المبلغ المدفوع</label>
                                    <input type="number" class="form-control" name="pay_fees" id="dev_pay_fees">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي</label>
                                    <input type="number" class="form-control" id="dev_totle_fees" value="0"
                                           disabled>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">قيمة الخصم</label>
                                    <input type="number" class="form-control" id="dev_discount_val" value="0"
                                           disabled>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي بعد
                                        الخصم</label>
                                    <input type="number" class="form-control" id="dev_required_pay" value="0"
                                           disabled>
                                </div>
                                <div class="col-md-12 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label">{{ __('notes') }}:</label>
                                    <textarea class="form-control" name="dev_notes" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- Edit Floor --}}
    <div class="modal fade" id="show_floor_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">تحديث بيانات</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDataFloor" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <input type="hidden" name="id" id="_id">
                        @if(Auth::user()->can('Edit-Floor-Data'))
                            <div class="row">
                                <div class="text-light small fw-semibold">بيانات المبنى</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1" class="form-label">رقم الدور</label>
                                    <select class="form-select " name="floor_number" id="e_floor_number">
                                    <option value="">أختر الدور</option>
                                    <option value="10" >بدروم
                                    </option>

                                    <option value="0" >ارضي سكني
                                    <option value="100" >ارضي تجاري
                                    </option>
                                    <option value="1" >أول
                                    </option>
                                    <option value="2" >ثاني
                                    </option>
                                    <option value="3">ثالث
                                    </option>
                                    <option value="4" >رابع
                                    </option>
                                    <option value="5" >خامس
                                    </option>
                                    <option value="6" >سادس
                                    </option>
                                    <option value="7">سابع
                                    </option>
                                    <option value="8" >ثامن
                                    </option>
                                    <option value="9" >روف
                                    </option>
                                    <option value="11" >بركس تجاري
                                    </option>
                                    <option value="12">بركس مزرعة دواجن
                                    </option>
                                    <option value="13" >بركس مزرعة ابقار
                                    </option>
                                    <option value="14" >بركس
                                    </option>


                                </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="exampleFormControlSelect1" class="form-label">الحالة</label>
                                    <select class="form-select" name="is_licensed" id="e_floor_is_licensed">
                                        <option value="1">غير مرخص</option>
                                        <option value="2">مرخص وغير مستوفي الشروط</option>
                                        <option value="4">مرخص ومستوفي الشروط</option>
                                    </select>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المساحة المراد
                                        ترخيصها</label>
                                    <input type="text" class="form-control" name="area" id="e_floor_area">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المرخصة سابقا</label>
                                    <input type="text" class="form-control" name="area_before" id="e_area_before">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم طلب الترخيص</label>
                                    <input type="text" class="form-control" name="lic_number">
                                </div>
                            </div>
                        @endif
                        @if(Auth::user()->can('Edit-Floor-Financial'))
                            <hr>
                            <div class="row">
                                <div class="text-light small fw-semibold">بيانات الترخيص</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المساحة المرخصة</label>
                                    <input type="number" class="form-control" name="licensed_area"
                                           id="e_floor_licensed_area">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">سعر الترخيص لكل متر</label>
                                    <input type="number" class="form-control" name="lic_per_meter"
                                           id="e_floor_lic_per_meter">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">نسبة الخصم</label>
                                    <input type="text" class="form-control" name="lic_fees_discount"
                                           id="e_floor_lic_fees_discount">
                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المبلغ المدفوع</label>
                                    <input type="number" class="form-control" name="license_fees"
                                           id="e_floor_license_fees">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">رقم إيصال الدفع</label>
                                    <input type="text" class="form-control" name="payment_number" id="payment_number">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي</label>
                                    <input type="number" class="form-control" id="e_floor_total" value="0" disabled>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">قيمة الخصم</label>
                                    <input type="number" class="form-control" id="e_floor_lic_fees_disc_val" value="0"
                                           disabled>
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي بعد
                                        الخصم</label>
                                    <input type="number" class="form-control" id="e_floor_required_pay" value="0"
                                           disabled>
                                </div>
                                <div class="col-md-12 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                                    <textarea class="form-control" name="floors_notes" id="e_floor_notes"
                                              rows="3"></textarea>
                                </div>
                            </div>
                            <hr>
                            <div id="edit_devlopment" style="display: none">
                                <div class="row">
                                    <div class="text-light small fw-semibold">بيانات التطوير</div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">مساحة الأرض</label>
                                        <input type="text" class="form-control" id="dev_buliding_area"
                                               value="{{ $licenseForm->report->development_area }}" disabled>
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">سعر التطوير لكل
                                            متر</label>
                                        <input type="text" class="form-control" name="dev_price_per_meter"
                                               id="e_dev_price_per_meter">
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">نسبة الخصم</label>
                                        <input type="text" class="form-control" name="discount" id="e_dev_discount">
                                    </div>

                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">المبلغ المدفوع</label>
                                        <input type="text" class="form-control" name="pay_fees" id="e_dev_pay_fees">
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي</label>
                                        <input type="text" class="form-control" id="e_dev_totle_fees" name="e_dev_totle_fees" value="0"
                                               >
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">قيمة الخصم</label>
                                        <input type="text" class="form-control" id="e_dev_discount_val" name="e_dev_discount_val" value="0"
                                               >
                                    </div>
                                    <div class="col-md-3 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي بعد
                                            الخصم</label>
                                        <input type="text" class="form-control" id="e_dev_required_pay" name="e_dev_required_pay" value="0"
                                               >
                                    </div>
                                    <div class="col-md-12 col-12 mb-3">
                                        <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}
                                            :</label>
                                        <textarea class="form-control" name="notes" id="e_dev_notes"
                                                  rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
    {{-- ===================================== --}}
@endsection
@push('scripts')
<script>
  $(function(){
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
            'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
            'Times New Roman', 'Verdana'],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      $.each(fonts, function (idx, fontName) {
          fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
      });
      $('a[title]').tooltip({container:'body'});
    	$('.dropdown-menu input').click(function() {return false;})
		    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
        .keydown('esc', function () {this.value='';$(this).change();});

      $('[data-role=magic-overlay]').each(function () { 
        var overlay = $(this), target = $(overlay.data('target')); 
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });
      if ("onwebkitspeechchange"  in document.createElement("input")) {
        var editorOffset = $('#editor').offset();
        $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
      } else {
        $('#voiceBtn').hide();
      }
	};
	function showErrorAlert (reason, detail) {
		var msg='';
		if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
		else {
			console.log("error uploading file", reason, detail);
		}
		$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
		 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
	};
    initToolbarBootstrapBindings();  
	$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
    window.prettyPrint && prettyPrint();
  });
</script>

    <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script>
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFilePoster,
            FilePondPluginPdfPreview,
            FilePondPluginFileMetadata,
        );

        var inputs = document.querySelectorAll('input[type=file]');

        for (let i = 0; i < inputs.length; i++) {

            const inputFile = FilePond.create(inputs[i]);

            if (i == 0) {
                inputFile.server = {
                    url: '',
                    process: {
                        url: "{{ route('license_forms.title_deedUpload') }}",
                        method: 'POST',
                        withCredentials: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        timeout: 7000,
                        onload: null,
                        onerror: null,
                    },
                }

                @if ($licenseForm->deedPhoto)
                    inputFile.files = [{
                    source: "{{url('/').'/'. $licenseForm->deedPhoto->url ?? '' }}",
                    options: {
                        type: "pdf",
                        metadata: {
                            poster: "{{url('/').'/'. $licenseForm->deedPhoto->url ?? '' }}",
                        }
                    }
                }];
                @endif
            }
            if (i == 1) {
                inputFile.server = {
                    url: '',
                    process: {
                        url: "{{ route('license_forms.generalSitePlanUpload') }}",
                        method: 'POST',
                        withCredentials: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        timeout: 7000,
                        onload: null,
                        onerror: null,
                    },
                }
                @if ($licenseForm->generalSitePhoto)
                    inputFile.files = [{
                    source: "{{url('/').'/'. $licenseForm->generalSitePhoto->url ?? '' }}",
                    options: {
                        type: "pdf",
                        metadata: {
                            poster: "{{url('/').'/'. $licenseForm->generalSitePhoto->url ?? '' }}",
                        }
                    }
                }];
                @endif

            }
            if (i == 2) {
                inputFile.server = {
                    url: '',
                    process: {
                        url: "{{ route('license_forms.constructionMapUpload') }}",
                        method: 'POST',
                        withCredentials: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        timeout: 7000,
                        onload: null,
                        onerror: null,
                    },
                }
                @if ($licenseForm->constructionMaphoto)
                    inputFile.files = [{
                    source: "{{url('/').'/'. $licenseForm->constructionMaphoto->url ?? '' }}",
                    options: {
                        type: "pdf",
                        metadata: {
                            poster: "{{url('/').'/'. $licenseForm->constructionMaphoto->url ?? '' }}",
                        }
                    }
                }];
                @endif
            }
            if (i == 3) {
                inputFile.server = {
                    url: '',
                    process: {
                        url: "{{ route('license_forms.undertakingSuperviseUpload') }}",
                        method: 'POST',
                        withCredentials: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        timeout: 7000,
                        onload: null,
                        onerror: null,
                    },
                }
                @if ($licenseForm->undertakingSupervisePhoto)
                    inputFile.files = [{
                    source: "{{url('/').'/'. $licenseForm->undertakingSupervisePhoto->url ?? '' }}",
                    options: {
                        type: "pdf",
                        metadata: {
                            poster: "{{url('/').'/'. $licenseForm->undertakingSupervisePhoto->url ?? '' }}",
                        }
                    }
                }];
                @endif
            }
            if (i == 4) {
                inputFile.server = {
                    url: '',
                    process: {
                        url: "{{ route('license_forms.aprobacionesTercerosUpload') }}",
                        method: 'POST',
                        withCredentials: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        timeout: 7000,
                        onload: null,
                        onerror: null,
                    },
                }
                @if ($licenseForm->aprobacionesTercerosPhoto)
                    inputFile.files = [{
                    source: "{{url('/').'/'. $licenseForm->aprobacionesTercerosPhoto->url ?? '' }}",
                    options: {
                        type: "pdf",
                        metadata: {
                            poster: "{{url('/').'/'. $licenseForm->aprobacionesTercerosPhoto->url ?? '' }}",
                        }
                    }
                }];
                @endif
            }
            if (i == 5) {
                inputFile.server = {
                    url: '',
                    process: {
                        url: "{{ route('license_forms.attachmentOneUpload') }}",
                        method: 'POST',
                        withCredentials: false,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        timeout: 7000,
                        onload: null,
                        onerror: null,
                    },
                }
                @if ($licenseForm->attachmentOne)
                    inputFile.files = [{
                    source: "{{url('/').'/'. $licenseForm->attachmentOne->url ?? '' }}",
                    options: {
                        type: "pdf",
                        metadata: {
                            poster: "{{url('/').'/'. $licenseForm->attachmentOne->url ?? '' }}",
                        }
                    }
                }];
                @endif
            }

        }

        // const title_deedPhoto = FilePond.create(document.getElementById("title_deedPhoto"));
        // const inputElement = document.querySelector('input[type="file"]');
        // const title_deedPhoto = FilePond.create(document.querySelector('input[type="file"]'));


        // title_deedPhoto.server = {
        //     url: '',
        //     process: {
        //         url: "{{ route('license_forms.generalSitePlanUpload') }}",
        //         method: 'POST',
        //         withCredentials: false,
        //         headers: {
        //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //         },
        //         timeout: 7000,
        //         onload: null,
        //         onerror: null,
        //     },
        // }

        // title_deedPhoto.files = [{
        //     source: "{{ $licenseForm->deedPhoto->url ?? '' }}",
        //     options: {
        //         type: 'PDF',
        //         metadata: {
        //             poster: "{{ $licenseForm->deedPhoto->url ?? '' }}",
        //         }
        //     }
        // }];
    </script>

    <script>
        $('#table_floor').DataTable({
            processing: true,
            bDestroy: true,
            serverSide: true,
            ajax: "{{ Route('licenseFloor.all', $licenseForm->id) }}",
            language: {
                'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
            },
            columns: [{
                data: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
                {
                    data: 'floor_number',
                    orderable: false,
                },
                {
                    data: 'area',
                    orderable: false,
                }, {
                    data: 'area_before',
                    orderable: false,
                }, {
                    data: 'licensed_area',
                    orderable: false,
                },
                {
                    data: 'lic_per_meter',
                    orderable: false,
                },
                {
                    data: 'lic_fees',
                    orderable: false,
                },
                {
                    data: 'required_pay',
                    orderable: false,
                },
                // {
                //     data: 'lic_fees_discount',
                //     orderable: false,
                // },
                {
                    data: 'lic_fees_disc_val',
                    orderable: false,
                }, {
                    data: 'license_fees',
                    orderable: false,
                }, {
                    data: "remaining_amount",
                    orderable: false,
                }, {
                    data: 'is_licensed',
                    orderable: false,
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        //edit FloorDescription
        $("#License_request_edit_opinion").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#License_request_edit_opinion')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
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
        // ================================================
        //الرأي القانوني
        $("#legal_opinForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#legal_opinForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
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
        //الاعتماد
        $('body').on('click', '#trust', function (e) {
            e.preventDefault();
            let id = $(this).data('id')
            Swal.fire({
                title: 'هل تريد اعتماد الرأي بشكل نهائي؟',
                text: "لن تتمكن من التعديل بعد ذلك!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، اعتماد نهائي!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put("{{ route('license_forms.update', $licenseForm->id) }}",
                        data = {
                            legal_opinion: $('#legal_opinion').val(),
                            status: '1',
                        }
                    ).then(function (response) {
                        location.reload();
                    });
                }
            });
        });
        // ================================================
        //رأي قسم المساحة
        $("#SurveyDepartmentForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#SurveyDepartmentForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
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
        $('body').on('click', '#trustSurveyDepartment', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'هل تريد اعتماد الرأي بشكل نهائي؟',
                text: "لن تتمكن من التعديل بعد ذلك!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، اعتماد نهائي!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put("{{ route('license_forms.update', $licenseForm->id) }}",
                        data = {
                            area_opinion: $('#area_opinion').val(),
                            status: '1',
                        }
                    ).then(function (response) {
                        location.reload();
                    });
                }
            });
        });
        // ================================================
        //رأي قسم التخطيط الحضري
        $("#plan_opinForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#plan_opinForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
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
        $('body').on('click', '#trustplan_opin', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'هل تريد اعتماد الرأي بشكل نهائي؟',
                text: "لن تتمكن من التعديل بعد ذلك!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، اعتماد نهائي!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put("{{ route('license_forms.update', $licenseForm->id) }}",
                        data = {
                            plan_opinion: $('#plan_opinion').val(),
                            status: '1',
                        }
                    ).then(function (response) {
                        location.reload();
                    });
                }
            });
        });
        // ================================================
        //رأي قسم المياه
        $("#WaterDepartmentForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#WaterDepartmentForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
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
        $('body').on('click', '#trustWaterDepartment', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'هل تريد اعتماد الرأي بشكل نهائي؟',
                text: "لن تتمكن من التعديل بعد ذلك!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، اعتماد نهائي!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put("{{ route('license_forms.update', $licenseForm->id) }}",
                        data = {
                            water_opinion: $('#water_opinion').val(),
                            status: '1',
                        }
                    ).then(function (response) {
                        location.reload();
                    });
                }
            });
        });
        // ================================================
        //رأي قسم المجاري
        $("#SewerDepartmentForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#SewerDepartmentForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
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
        $('body').on('click', '#trustsewer_opin', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'هل تريد اعتماد الرأي بشكل نهائي؟',
                text: "لن تتمكن من التعديل بعد ذلك!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، اعتماد نهائي!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put("{{ route('license_forms.update', $licenseForm->id) }}",
                        data = {
                            sewer_opinion: $('#sewer_opinion').val(),
                            status: '1',
                        }
                    ).then(function (response) {
                        location.reload();
                    });
                }
            });
        });
        // ================================================
        //رأي قسم الجباية
        $("#CollectionDepartmentForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#CollectionDepartmentForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
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
        $('body').on('click', '#trustCollectionDepartment', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'هل تريد اعتماد الرأي بشكل نهائي؟',
                text: "لن تتمكن من التعديل بعد ذلك!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، اعتماد نهائي!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put("{{ route('license_forms.update', $licenseForm->id) }}",
                        data = {
                            collection_opinion: $('#collection_opinion').val(),
                            status: '1',
                        }
                    ).then(function (response) {
                        location.reload();
                    });
                }
            });
        });
        // ================================================
        // رأي قسم GIS
        $("#Gis_opinionForm").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#Gis_opinionForm')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
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
        $('body').on('click', '#trustGis', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'هل تريد اعتماد الرأي بشكل نهائي؟',
                text: "لن تتمكن من التعديل بعد ذلك!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم ، اعتماد نهائي!',
                cancelButtonText: 'إلغاء',

            }).then((result) => {
                if (result.isConfirmed) {
                    axios.put("{{ route('license_forms.update', $licenseForm->id) }}",
                        data = {
                            gis_opinion: $('#gis_opinion').val(),
                            status: '1',
                        }
                    ).then(function (response) {
                        location.reload();
                    });
                }
            });
        });
        // ================================================

        //edit info
        $("#editInfo").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#editInfo')[0]);
            axios({
                method: 'post',
                url: "{{ route('license_forms.update', $licenseForm->id) }}",
                data: formData
            })
                .then(function (response) {
                    $('#table_floor').DataTable().ajax.reload();
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

        // =====================================
        //remove data form when click add button
        $('body').on('click', '#add_new_floor', function () {
            $('#addNewFloor')[0].reset();
        });
        //add FloorDescription
        $("#addNewFloor").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#addNewFloor')[0]);
            axios({
                method: 'post',
                url: "{{ route('floor-descriptions.store') }}",
                data: formData
            })
                .then(function (response) {
                    $('#table_floor').DataTable().ajax.reload();
                    toastr.success(response.data.message, "{{ __('Saved') }}")
                    $('#addNewFloor').trigger("reset");
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
        //بحسب المجموع الكلي
        $('body').on('change', '#lic_per_meter', function () {
            document.getElementById("total").value = document.getElementById("area").value * document
                .getElementById("lic_per_meter").value;
        });
        //قيمة الخصم
        $('body').on('change', '#lic_fees_discount', function () {
            document.getElementById("lic_fees_disc_val").value = document.getElementById("total")
                .value * document.getElementById("lic_fees_discount").value / 100;
            //الملبغ الإجمالي بعد الخصم
            document.getElementById("required_pay").value = document.getElementById("total").value -
                document.getElementById("lic_fees_disc_val").value;
        });
        // ======
        //بحسب المجموع الكلي للتطوير
        $('body').on('change', '#dev_price_per_meter', function () {
            document.getElementById("dev_totle_fees").value = document.getElementById(
                "dev_price_per_meter").value * document.getElementById("dev_buliding_area").value;
        });
        //قيمة الخصم للتطوير
        $('body').on('change', '#dev_discount', function () {
            document.getElementById("dev_discount_val").value = document.getElementById(
                "dev_totle_fees").value * document.getElementById("dev_discount").value / 100;
            //الملبغ الإجمالي بعد الخصم
            document.getElementById("dev_required_pay").value = document.getElementById(
                "dev_totle_fees").value - document.getElementById("dev_discount_val").value;
        });

        ///////////// edit count
        $('body').on('change', '#e_floor_lic_per_meter', function () {
            document.getElementById("e_floor_total").value = document.getElementById("e_floor_area")
                .value * document.getElementById("e_floor_lic_per_meter").value;
        });
        //قيمة الخصم
        $('body').on('change', '#e_floor_lic_fees_discount', function () {
            document.getElementById("e_floor_lic_fees_disc_val").value = document.getElementById(
                "e_floor_total").value * document.getElementById("e_floor_lic_fees_discount")
                .value / 100;
            //الملبغ الإجمالي بعد الخصم
            document.getElementById("e_floor_required_pay").value = document.getElementById(
                "e_floor_total").value - document.getElementById("e_floor_lic_fees_disc_val").value;
        });
        // ======
        // show form devlopment earth
        $('body').on('change', '#floor_number', function () {
            let number = document.getElementById("floor_number").value;
            if (number == '0' || number == '100' || number == '11' || number == '12' || number == '13' || number == '14') {
                document.getElementById("devlopment").style.display = "block";
            } else {
                document.getElementById("devlopment").style.display = "none";
            }
        });
        // edit Floor
        $("#editDataFloor").on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($('#editDataFloor')[0]);
            axios({
                method: 'post',
                url: "{{ route('floor-descriptions.update_data') }}",
                data: formData
            })
                .then(function (response) {
                    $('#table_floor').DataTable().ajax.reload();
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
        // =======
        //get data for edit
        $('body').on('click', '#editRowFloor', function () {
            $('#editDataFloor')[0].reset();
            let id = $(this).data('id');
            let edit = "{{ url('/') }}" + '/home/floor-descriptions/' + id + '/edit';
            axios.get(edit)
                .then(function (res) {
                    // console.log(res.data)
                    $('#_id').val(res.data.id)
                    $('#e_floor_number').val(res.data.floor_number)
                    $('#e_floor_area').val(res.data.area)
                    $('#e_area_before').val(res.data.area_before)
                    $('#e_floor_licensed_area').val(res.data.licensed_area)

                    $('#e_floor_licensed_area').val(res.data.licensed_area)
                    $('#e_floor_lic_per_meter').val(res.data.lic_per_meter)
                    $('#e_floor_lic_fees_discount').val(res.data.lic_fees_discount)
                    $('#e_floor_total').val(res.data.lic_fees)
                    $('#e_floor_lic_fees_disc_val').val(res.data.lic_fees_disc_val)
                    $('#e_floor_license_fees').val(res.data.license_fees)
                    $('#e_floor_is_licensed').val(res.data.is_licensed)
                    $('#e_floor_notes').val(res.data.notes)
                    if (res.data.devlopments.length > 0) {
                        document.getElementById('edit_devlopment').style.display = "block";
                        let devlopments = res.data.devlopments;
                        for (var i = 0; i < devlopments.length; i++) {
                            // console.log(devlopments[i].price_per_meter)
                            $('#e_dev_price_per_meter').val(devlopments[i].dev_price_per_meter)
                            $('#e_dev_discount').val(devlopments[i].discount)
                            $('#e_dev_pay_fees').val(devlopments[i].pay_fees)
                            $('#e_dev_totle_fees').val(devlopments[i].totle_fees)
                            $('#e_dev_discount_val').val(devlopments[i].discount_val)
                            $('#e_dev_required_pay').val(devlopments[i].required_pay)
                        }
                    } else {
                        document.getElementById('edit_devlopment').style.display = "none";
                    }
                })
        })
        // =======
        //delete-fllor
        $('body').on('click', '#deleteRowFloor', function (e) {
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
                    axios.delete("{{ url('/') }}" + '/home/floor-descriptions/' + id)
                        .then(function (response) {
                            // console.log(response);
                            showMessage(response.data);
                            $('#table_floor').DataTable().ajax.reload();
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
        // add تقرير كشف تنظيمي
        $("#save_regulatory_disclosure_report").on('click', function () {
            var formData = new FormData($('#regulatory_disclosure_report')[0]);
            axios({
                method: 'post',
                url: "{{ route('regulatory-disclosure-reports.update_data') }}",
                data: formData
            })
                .then(function (response) {
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
        $("#confirm_regulatory_disclosure_report").on('click', function () {
            var formData = new FormData($('#regulatory_disclosure_report')[0]);
            axios({
                method: 'post',
                url: "{{ route('regulatory-disclosure-reports.confirm_data') }}",
                data: formData
            })
                .then(function (response) {
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

        // ======================================المرفقات:

        $('body').on('click', '#conversion', function (e) {
            e.preventDefault();
            axios.get("{{ route('license_forms.certified', $licenseForm->id) }}")
                .then(function (response) {
                    toastr.error(response.data.message)
                    if (response.data.message == 'تم الحفظ') {
                        window.location.href = "{{ route('buildings.index') }}";
                    }
                });
        });
        // ======================================
        $('body').on('change', '#building_area', function () {
            document.getElementById("construction_ratio").value = document.getElementById("building_area").value / document
                .getElementById("total_coupon_space").value * 100;
        });
        $('body').on('change', '#total_coupon_space', function () {
            document.getElementById("construction_ratio").value = document.getElementById("building_area").value / document
                .getElementById("total_coupon_space").value * 100;
        });
        // ======================================
        //المساحة المرخصة
        $('body').on('change', '#e_area_before', function () {
            document.getElementById("e_floor_licensed_area").value = document.getElementById(
                "e_floor_area").value - document.getElementById("e_area_before").value;
        });

    </script>
@endpush
