@extends('layouts.master')
@section('title', __('Buildings'))
@section('stylesheet')
    <link href="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/css/lightgallery.css" rel="stylesheet"
          type="text/css"/>
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
          rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css" rel="stylesheet"/>
    <link href="https://unpkg.com/filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.css"
          rel="stylesheet">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <style>
        li.fl-wrap.filter-tags.clearfix {
            display: inline-block;
            margin: 10px;
        }


        button#click_transfer_photo {
            position: relative;
            top: -36px;
        }

        .demo-gallery li.menu-item {
            width: 23%;
            height: 200px;
            margin: 20px 10px;
            float: right;
            border-radius: 4px;
            overflow: hidden;
        }

        .demo-gallery img.img-responsive {
            width: 100%;
            height: 100%;
        }
        #del_license_pdf {
            background: beige;
            position: absolute;
            bottom: 0;
            left: 0;
            padding: 10px;
            border-radius: 10px;
        }
    </style>
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
                                @if (Auth::user()->can('Show-Building'))
                                    <a class="list-group-item list-group-item-action active" id="home-list-item"
                                       data-bs-toggle="list" href="#info" aria-selected="true"
                                       role="tab">{{ __('Informations') }}</a>
                                @endif
                                @if (Auth::user()->can('Read-Owners'))
                                    <a class="list-group-item list-group-item-action" id="home-list-item"
                                       data-bs-toggle="list" href="#owner" aria-selected="true"
                                       role="tab">{{ __('Owners') }}</a>
                                @endif
                                @if (Auth::user()->can('Read-Floors'))
                                    <a class="list-group-item list-group-item-action" id="messages-list-item"
                                       data-bs-toggle="list" href="#floor" aria-selected="false" role="tab"
                                       tabindex="-1">{{ __('Floors') }}</a>
                                @endif
                                @if (Auth::user()->can('Read-Units'))
                                    <a class="list-group-item list-group-item-action" id="profile-list-item"
                                       data-bs-toggle="list" href="#unit" aria-selected="false" role="tab"
                                       tabindex="-1">{{ __('Units') }}</a>
                                @endif
                                @if (Auth::user()->can('Read-Crafts'))
                                    <a class="list-group-item list-group-item-action" id="settings-list-item"
                                       data-bs-toggle="list" href="#craft" aria-selected="false" role="tab"
                                       tabindex="-1">{{ __('Crafts') }}</a>
                                @endif
                                @if (Auth::user()->can('Read-Subscriptions'))
                                    <a class="list-group-item list-group-item-action" id="settings-list-item"
                                       data-bs-toggle="list" href="#subscription" aria-selected="false" role="tab"
                                       tabindex="-1">{{ __('Subscriptions') }}</a>
                                @endif
                                @if (Auth::user()->can('Read-Financial'))
                                    <a class="list-group-item list-group-item-action" id="settings-list-item"
                                       data-bs-toggle="list" href="#getTaxTotalsByCustomer" aria-selected="false"
                                       role="tab" tabindex="-1">الملف المالي</a>
                                @endif
                                @if (Auth::user()->can('Read-Organizational'))
                                    <a class="list-group-item list-group-item-action" id="settings-list-item"
                                       data-bs-toggle="list" href="#organizationFile" aria-selected="false" role="tab"
                                       tabindex="-1">الملف التنظيمي</a>
                                @endif
                                @if (Auth::user()->can('Read-ProofOfCase'))
                                    <a class="list-group-item list-group-item-action" id="settings-list-item"
                                       data-bs-toggle="list" href="#ProofOfCase" aria-selected="false" role="tab"
                                       tabindex="-1">إثبات حالة</a>
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
                @if (Auth::user()->can('Show-Building'))
                    <div class="tab-pane fade active show" id="info" role="tabpanel" aria-labelledby="#home-list-item">

                        <div class="row">
                            <div class="col-xl-9 order-0 order-md-1">
                                <!-- Project table -->
                                <div class="card mb-4">
                                    <div class="mb-3">
                                        <div id="DataTables_Table_0_wrapper"
                                             class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                            <form id="editDataFormBuilding" class="py-3" enctype="multipart/form-data">
                                                @method('put')
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12 col-12 mb-3">
                                                        <label for="defaultFormControlInput"
                                                               class="form-label">اسم المبنى</label>
                                                        <input type="text" class="form-control" name="building_name"
                                                               value="{{ $building->building_name }}"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput"
                                                               class="form-label">{{ __('file number') }}:</label>
                                                        <input type="text" class="form-control" name="file_number"
                                                               value="{{ $building->file_number }}"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput"
                                                               class="form-label">{{ __('building number') }}:</label>
                                                        <input type="text" class="form-control" name="building_number"
                                                               value="{{ $building->building_number }}"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput"
                                                               class="form-label">{{ __('block number') }}:</label>
                                                        <input type="number" class="form-control" name="block_number"
                                                               value="{{ $building->block_number }}"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput"
                                                               class="form-label">{{ __('parcel number') }}:</label>
                                                        <input type="number" class="form-control" name="parcel_number"
                                                               value="{{ $building->parcel_number }}"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput"
                                                               class="form-label">{{ __('Area') }}:</label>
                                                        <input type="number" class="form-control" name="area"
                                                               value="{{ $building->area }}"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="defaultFormControlInput"
                                                               class="form-label">{{ __('building name') }}:</label>
                                                        <input type="text" class="form-control" name="building_name"
                                                               value="{{ $building->building_name }}"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('Street number') }}:</label>
                                                        <select class="form-select street_id" name="street_id"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @foreach ($streets as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @selected($item->id == $building->street_id)>{{ $item->street_number }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('Zone number') }}:</label>
                                                        <select class="form-select street_id" name="zone_id"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @foreach ($zones as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @selected($item->id == $building->zone_id)>{{ $item->zone_number }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('SubZone number') }}:</label>
                                                        <select class="form-select street_id" name="subzone_id"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @foreach ($subzones as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @selected($item->id == $building->subzone_id)>{{ $item->zone_number }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('Property Type') }}:</label>
                                                        <select class="form-select street_id"
                                                                name="building_property_type_id"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->building_property_type_id == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            @foreach ($propertyTypes as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @selected($item->id == $building->building_property_type_id)>{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('Building type') }}:</label>
                                                        <select class="form-select street_id" name="building_type"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->building_type == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            @foreach ($buildingTypes as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @selected($item->id == $building->building_type)>{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('construction status') }}
                                                            :</label>
                                                        <select class="form-select street_id" name="building_status_id"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->building_status_id == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            @foreach ($buildingStatus as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @selected($item->id == $building->building_status_id)>{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('The type of final finishing of the building') }}
                                                            :</label>
                                                        <select class="form-select street_id" name="building_finish_id"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->building_finish_id == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            @foreach ($buildingFinish as $item)
                                                                <option value="{{ $item->id }}"
                                                                    @selected($item->id == $building->building_finish_id)>{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('The general condition of the building') }}
                                                            :</label>
                                                        <select class="form-select street_id" name="general_condition"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->general_condition == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            <option
                                                                value="1" @selected($building->general_condition == '1')>
                                                                ممتازة
                                                            </option>
                                                            <option
                                                                value="2" @selected($building->general_condition == '2')>
                                                                جيدة
                                                            </option>
                                                            <option
                                                                value="3" @selected($building->general_condition == '3')>
                                                                سيئة
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('The external condition of the building') }}
                                                            :</label>
                                                        <select class="form-select street_id" name="external_condition"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->general_condition == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            <option
                                                                value="1" @selected($building->external_condition == '1')>
                                                                مشطب كامل
                                                            </option>
                                                            <option
                                                                value="2" @selected($building->external_condition == '2')>
                                                                مشطب جزئي
                                                            </option>
                                                            <option
                                                                value="3" @selected($building->external_condition == '3')>
                                                                غير مشطب
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('Sewage') }}:</label>
                                                        <select class="form-select street_id" name="sewage"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->sewage == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            <option value="1" @selected($building->sewage == '1')>بلدية
                                                            </option>
                                                            <option value="2" @selected($building->sewage == '2')>بئر
                                                                خاص
                                                            </option>
                                                            <option value="3" @selected($building->sewage == '3')>لا
                                                                يوجد
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('escape staircase') }}:</label>
                                                        <select class="form-select street_id" name="escape_staircase"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->escape_staircase == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            <option
                                                                value="1" @selected($building->escape_staircase == '1')>
                                                                متوفر
                                                            </option>
                                                            <option
                                                                value="2" @selected($building->escape_staircase == '2')>
                                                                غير متوفر
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('water network') }}:</label>
                                                        <select class="form-select street_id" name="waterNetwork"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->waterNetwork == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            <option value="1" @selected($building->waterNetwork == '1')>
                                                                شبكة عامة
                                                            </option>
                                                            <option value="2" @selected($building->waterNetwork == '2')>
                                                                شبكة خاصة
                                                            </option>
                                                            <option value="3" @selected($building->waterNetwork == '3')>
                                                                لا يوجد
                                                            </option>

                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-12 mb-3">
                                                        <label for="exampleFormControlSelect1"
                                                               class="form-label">{{ __('power network') }}:</label>
                                                        <select class="form-select street_id" name="sewageNetwork"
                                                            {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                                            @if ($building->sewageNetwork == null)
                                                                <option value="">لا يوجد بيانات</option>
                                                            @endif
                                                            <option
                                                                value="1" @selected($building->sewageNetwork == '1')>
                                                                شبكة عامة
                                                            </option>
                                                            <option
                                                                value="2" @selected($building->sewageNetwork == '2')>
                                                                شبكة خاصة
                                                            </option>
                                                            <option
                                                                value="3" @selected($building->sewageNetwork == '3')>لا
                                                                يوجد
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
                                                                    {{ __('Building use') }}:
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <ul class="pro-feature-add" style=" padding: 0; ">
                                                                        @foreach ($buildingUse as $item)
                                                                            <label class="switch switch-primary">
                                                                                <input type="checkbox"
                                                                                       class="switch-input"
                                                                                       id="{{ $item->id }}"
                                                                                       name="uses[]"
                                                                                       value="{{ $item->id }}"
                                                                                @foreach ($item->buildings as $item2)
                                                                                    @checked($building->id == $item2->pivot->building_id && $item->id == $item2->pivot->building_use_id)
                                                                                    @endforeach
                                                                                    {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
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
                                                                    {{ __('The last roof construction material') }}:
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <ul class="pro-feature-add" style=" padding: 0; ">
                                                                        @foreach ($buildingMaterial as $item)
                                                                            <label class="switch switch-primary">
                                                                                <input type="checkbox"
                                                                                       class="switch-input"
                                                                                       id="{{ $item->id }}"
                                                                                       name="material[]"
                                                                                       value="{{ $item->id }}"
                                                                                @foreach ($item->buildings as $item2)
                                                                                    @checked($building->id == $item2->pivot->building_id && $item->id == $item2->pivot->building_material_id)
                                                                                    @endforeach
                                                                                    {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
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
                                                </div>
                                                <hr>
                                                <div class="col-12 mt-3">
                                                    <button class="btn btn-label-primary waves-effect" type="submit"
                                                        {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>حفظ
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /Project table -->
                            </div>
                            <div class="col-xl-3 order-0 order-md-1">
                            <div class="card">
                                <div class="card-body">
                                    <p id="imageArea" >

                                    @if($building->image == NULL)
                                    @if(\App\Models\Street::where('id',$building->street_id)->first())
                                    <a target="_blank" href="{{url('building/ready/') . '/' . \App\Models\Street::where('id',$building->street_id)->first()->street_number . '-' . $building->building_number . '.jpg'}}">
                                    <img src="{{url('building/ready/') . '/' . \App\Models\Street::where('id',$building->street_id)->first()->street_number . '-' . $building->building_number . '.jpg'}}" width="100%">
                                    </a>
                                    @endif
                                    @else
                                    <a target="_blank" href="{{$building->image}}">
                                    <img src="{{$building->image}}" width="300">
                                    </a>
                                    @endif
                                    <span>اخر تخديث بتاريخ : {{$building->updated_at}}</span>
                                    <!-- <button type="button" class="btn btn-outline-primary waves-effect btn-block" data-toggle="modal" data-target="#xlarge">
                                                تكبير
                                            </button> -->
                                            <div class="modal fade text-left" id="xlarge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-modal="true" style="padding-right: 15px; display: none;">
                                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                        @if($building->image == NULL)
                                                        <img src="https://i.etsystatic.com/26264481/r/il/d2d288/3766684098/il_570xN.3766684098_smuu.jpg" width="100%">
                                                        @else
                                                        <img src="{{$building->image}}" width="300">

                                                        @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-dismiss="modal">اغلاق</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                    </p>
                                    <form class="needs-validation" novalidate="" id="changeImage" method="post">
                                        <div class="form-row">
                                            <div class="col-md-12 col-12 mb-3">
                                                <label for="validationTooltip01">اختر صورة بديلة</label>
                                                <input type="file" class="form-control" name="buildingImage" id="validationTooltip01" placeholder="First name" value="Mark" required="">
                                                <input hidden name="building_id" value="{{$building->id}}">
                                                <!-- <div class="valid-tooltip">Looks good!</div> -->
                                            </div>
                                        </div>
                                        <button class="btn btn-primary waves-effect waves-float waves-light" type="submit">تحميل</button>
                                    </form>
                                </div>
                            </div>

                            </div>

                        </div>
                    </div>

                @endif
                {{-- ====================================================== --}}
                {{-- owner --}}
                @if (Auth::user()->can('Read-Owners'))
                    <div class="tab-pane fade" id="owner" role="tabpanel" aria-labelledby="#home-list-item">
                        <div class="col-xl-12 order-0 order-md-1">
                            <div class="card mb-4">
                                @if (Auth::user()->can('Create-Owner'))
                                    <div class="dt-action-buttons text-end pt-3 pt-md-0 m-3">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <a href="javascript:;"
                                               class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                               id="add_new_owner" data-bs-toggle="modal"
                                               data-bs-target="#show_add_owner_model" type="button"><span><i
                                                        class="ti ti-plus me-sm-1">
                                                    </i> <span
                                                        class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                        <table class="datatables-basic table dataTable no-footer dtr-column"
                                               id="table_owner" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr>
                                                <th class="sorting">{{ __('#') }}</th>
                                                <th class="sorting">{{ __('Full Name') }}</th>
                                                <th class="sorting">{{ __('ID') }}</th>
                                                <th class="sorting">{{ __('Mokalaf Number') }}</th>
                                                <th class="sorting">{{ __('Phone Number') }}</th>
                                                <th class="sorting">{{ __('Notes') }}</th>
                                                <th class="sorting">{{ __('Control') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <div class="card my-2">
                                <div class="mb-3">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper dt-bootstrap5 no-footer px-4">
                                        <div class="head-label text-start">
                                            <h5 class="card-title pt-3 mt-2">المالكين السابقين</h5>
                                        </div>
                                        {{-- <a class="dt-button buttons-reload btn btn-warning waves-effect waves-float waves-light"
                                            id="load_table_owner_previous" tabindex="0"
                                            aria-controls="admin-table"><span><i class="fa-solid fa-rotate"></i></span></a> --}}
                                        <table class="datatables-basic table dataTable no-footer dtr-column"
                                               id="table_owner_previous" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr>
                                                <th class="sorting">{{ __('#') }}</th>
                                                <th class="sorting">{{ __('Full Name') }}</th>
                                                <th class="sorting">{{ __('ID') }}</th>
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
                @endif
                {{-- ====================================================== --}}
                {{-- floor --}}
                @if (Auth::user()->can('Read-Floors'))
                    <div class="tab-pane fade" id="floor" role="tabpanel" aria-labelledby="#messages-list-item">
                        <div class="col-xl-12 order-0 order-md-1">

                            <div class="row">
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0">
                                                <h5 class="mb-0 me-2">{{ $building->floors_sum_area ?? 0 }}م</h5>
                                                <small>المساحة الكلية</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                    <i class="ti ti-cpu ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0">
                                                <h5 class="mb-0 me-2">{{ $building->floors_sum_licensed_area ?? 0 }}
                                                    م</h5>
                                                <small>المساحة المرخصة</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                    <i class="ti ti-cpu ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0">
                                                <h5 class="mb-0 me-2">{{ $building->floors_sum_license_fees ?? 0 }}</h5>
                                                <small>المبلغ المدفوع</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                    <i class="ti ti-cpu ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0">
                                                <h5 class="mb-0 me-2">
                                                    {{$building->remaining_amount ?? 0}}
                                                </h5>
                                                <small>المبلغ المتبقي</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                    <i class="ti ti-cpu ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0">
                                                <h5 class="mb-0 me-2">{{ $building->area ?? 0 }}م</h5>
                                                <small>مساحة الأرض</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                    <i class="ti ti-cpu ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0">
                                                <h5 class="mb-0 me-2">{{ $building->area * 2 ?? 0 }} $</h5>
                                                <small> المبلغ المطلوب للتطوير</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                    <i class="ti ti-cpu ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0">
                                                <h5 class="mb-0 me-2">{{ $building->dev_required_pay ?? 0 }} $</h5>
                                                <small> المبلغ المدفوع للتطوير</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                    <i class="ti ti-cpu ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 mb-4">
                                    <div class="card">
                                        <div class="card-body d-flex justify-content-between align-items-center">
                                            <div class="card-title mb-0">
                                                <h5 class="mb-0 me-2">
                                                    {{$building->dev_remaining_amount ?? 0}} $
                                                </h5>
                                                <small>المبلغ المتبقي للتطوير</small>
                                            </div>
                                            <div class="card-icon">
                                                <span class="badge bg-label-primary rounded-pill p-2">
                                                    <i class="ti ti-cpu ti-sm"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-4">
                                @if (Auth::user()->can('Create-Floor'))
                                    <div class="dt-action-buttons text-end pt-3 pt-md-0 m-3">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <a href="javascript:;"
                                               class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                               id="add_new_floor" data-bs-toggle="modal"
                                               data-bs-target="#show_add_floor_model" type="button"><span><i
                                                        class="ti ti-plus me-sm-1">
                                                    </i> <span
                                                        class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                        <table class="datatables-basic table dataTable no-footer dtr-column"
                                               id="table_floor" aria-describedby="DataTables_Table_0_info">
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
                                                {{--                                                <th class="sorting">نسبة الخصم</th>--}}
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
                @endif
                {{-- ====================================================== --}}
                {{-- unit --}}
                @if (Auth::user()->can('Read-Units'))
                    <div class="tab-pane fade" id="unit" role="tabpanel" aria-labelledby="#profile-list-item">
                        <div class="col-xl-12 order-0 order-md-1">
                            <div class="card mb-4">
                                @if (Auth::user()->can('Create-Unit'))
                                    <div class="dt-action-buttons text-end pt-3 pt-md-0 m-3">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <a href="javascript:;"
                                               class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                               id="add_new_unit" data-bs-toggle="modal"
                                               data-bs-target="#show_add_unit_model" type="button"><span><i
                                                        class="ti ti-plus me-sm-1">
                                                    </i> <span
                                                        class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                        <table class="datatables-basic table dataTable no-footer dtr-column"
                                               id="table_unit" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr>
                                                <th class="sorting">{{ __('#') }}</th>
                                                {{-- <th class="sorting">{{ __('Street Number') }}</th>
                                        <th class="sorting">{{ __('Building Number') }}</th> --}}
                                                <th class="sorting">{{ __('Floor Number') }}</th>
                                                <th class="sorting">{{ __('Unit Number') }}</th>
                                                <th class="sorting">{{ __('Unit Type') }}</th>
                                                <th class="sorting">{{ __('Owner') }}</th>
                                                <th class="sorting">{{ __('User') }}</th>
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
                @endif
                {{-- ====================================================== --}}
                {{-- craft --}}
                @if (Auth::user()->can('Read-Crafts'))
                    <div class="tab-pane fade" id="craft" role="tabpanel" aria-labelledby="#settings-list-item">
                        <div class="col-xl-12 order-0 order-md-1">
                            <div class="card mb-4">
                                @if (Auth::user()->can('Create-Craft'))
                                    <div class="dt-action-buttons text-end pt-3 pt-md-0 m-3">
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
                                    <div class="dt-buttons btn-group flex-wrap">
                                            <a href="javascript:;"
                                               class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                               id="add_craft_unit" data-bs-toggle="modal"
                                               data-bs-target="#add_craft_model" type="button"><span><i
                                                        class="ti ti-plus me-sm-1">
                                                    </i> <span
                                                        class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
                                            </a>

                                        </div>

                                    </div>
                                @endif
                                <div class="card mb-4">
                                    <div class="mb-3">
                                        <div id="DataTables_Table_0_wrapper"
                                             class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                            <table class="datatables-basic table dataTable no-footer dtr-column"
                                                   id="table_craft" aria-describedby="DataTables_Table_0_info">
                                                <thead>
                                                <tr>
                                                    <th class="sorting">{{ __('#') }}</th>
                                                    <th class="sorting">{{ __('Job Formal Name') }}</th>
                                                    <th class="sorting">{{ __('Owner') }}</th>
                                                    <th class="sorting">{{ __('رقم المكلف') }}</th>
                                                    <th class="sorting">رقم الهوية</th>
                                                    <th class="sorting">رقم الاتصال</th>
                                                    <th class="sorting">رقم ملف الحرفة</th>
                                                    <th class="sorting">حالة الحرفة</th>
                                                    <th class="sorting">ملاحظات</th>
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
                    </div>
                @endif
                {{-- ====================================================== --}}
                {{-- subscription --}}
                @if (Auth::user()->can('Read-Subscriptions'))
                    <div class="tab-pane fade" id="subscription" role="tabpanel" aria-labelledby="#settings-list-item">
                        <div class="col-xl-12 order-0 order-md-1">
                            <div class="card mb-4">
                                @if (Auth::user()->can('Create-Subscription'))
                                    <div class="dt-action-buttons text-end pt-3 pt-md-0 m-3">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <a href="javascript:;"
                                               class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                               id="add_new_owner" data-bs-toggle="modal"
                                               data-bs-target="#show_add_subscription" type="button"><span><i
                                                        class="ti ti-plus me-sm-1">
                                                    </i> <span
                                                        class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                        <table class="datatables-basic table dataTable no-footer dtr-column"
                                               id="table_subscription" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr>
                                                <th class="sorting">{{ __('#') }}</th>
                                                <th class="sorting">{{ __('Id Number') }}</th>
                                                <th class="sorting">{{ __('Name') }}</th>
                                                <th class="sorting">{{ __('customer_number') }}</th>
                                                <th class="sorting">رقم الاشتراك</th>
                                                <th class="sorting">{{ __('Mobile') }}</th>
                                                <th class="sorting">الوحدات التي يخدمها</th>
                                                <th class="sorting">التحكم</th>
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
                @endif
                {{-- ====================================================== --}}
                {{-- getTaxTotalsByCustomer --}}
                @if (Auth::user()->can('Read-Financial'))
                    <div class="tab-pane fade" id="getTaxTotalsByCustomer" role="tabpanel"
                         aria-labelledby="#settings-list-item">
                        <div class="col-xl-12 order-0 order-md-1">
                            <div class="row" id="all_owners">
                            </div>
                        </div>
                    </div>
                @endif
                {{-- ====================================================== --}}
                {{-- OrganizationFile --}}
                @if (Auth::user()->can('Read-Organizational'))
                    <div class="tab-pane fade" id="organizationFile" role="tabpanel"
                         aria-labelledby="#profile-list-item">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="demo-inline-spacing">
                                    <div class="list-group list-group-horizontal-md text-md-center" role="tablist">
                                        <a class="list-group-item list-group-item-action active" id="profile-list-item"
                                           data-bs-toggle="list" href="#license" aria-selected="false" role="tab"
                                           tabindex="-1">طلب الترخيص</a>

                                        <a class="list-group-item list-group-item-action" id="home-list-item"
                                           data-bs-toggle="list" href="#Archives" aria-selected="true"
                                           role="tab">الأرشيف</a>
                                        @foreach ($category_archive_attachments as $category_archive_attachment)
                                            <a class="list-group-item list-group-item-action" id="home-list-item"
                                               data-bs-toggle="list" href="#bhm{{ $category_archive_attachment->id }}"
                                               aria-selected="false" tabindex="-1"
                                               role="tab">{{ $category_archive_attachment->name }}</a>
                                        @endforeach
                                    </div>
                                    <div class="tab-content px-0 mt-0">
                                        {{-- ======= --}}
                                        <div class="tab-pane fade active show" id="license" role="tabpanel"
                                             aria-labelledby="#settings-list-item">
                                            <div class="col-xl-12 order-0 order-md-1">
                                                <form id="add_file_for_licenseForm" enctype="multipart/form-data">
                                                    @method('post')
                                                    @csrf
                                                    <input type="hidden" name="building_id" value="{{$building->id}}">
                                                    <div class="text-light small fw-semibold">المرفقات:</div>
                                                    <div class="row">
                                                        <div class="col-md-4 col-12 mb-3">
                                                            <label for="formFile" class="form-label">سندات
                                                                الملكية</label>
                                                            <input class="form-control" type="file"
                                                                   name="title_deedPhoto"
                                                                {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        </div>
                                                        <div class="col-md-4 col-12 mb-3">
                                                            <label for="formFile" class="form-label">بيان الشروط
                                                                التنظيمية</label>
                                                            <input class="form-control" type="file"
                                                                   name="general_site_planPhoto"
                                                                {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        </div>
                                                        <div class="col-md-4 col-12 mb-3">
                                                            <label for="formFile" class="form-label">مخططات
                                                                البناء</label>
                                                            <input class="form-control" type="file"
                                                                   name="construction_mapPhoto"
                                                                {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        </div>
                                                        <div class="col-md-4 col-12 mb-3">
                                                            <label for="formFile" class="form-label">تعهد
                                                                بالإشراف</label>
                                                            <input class="form-control" type="file"
                                                                   name="undertaking_supervisePhoto"
                                                                {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        </div>
                                                        <div class="col-md-4 col-12 mb-3">
                                                            <label for="formFile" class="form-label">مصادقات جهات
                                                                أخرى</label>
                                                            <input class="form-control" type="file"
                                                                   name="aprobaciones_tercerosPhoto"
                                                                {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 my-3">
                                                        <button class="btn btn-label-primary waves-effect"
                                                            {{ Auth::user()->can('Update-LicenseForm') ? '' : 'disabled' }}>
                                                            حفظ
                                                        </button>

                                                    </div>
                                                </form>
                                                <hr/>
                                                <div class="demo-gallery">
                                                    <ul id="lightgallery">

                                                        @foreach ($license_img as $item)
                                                            <li class="menu-item"
                                                                data-src="{{ url('/') . '/' . $item->url }}"
                                                                data-sub-html="<h4>{{ $item->category }}</h4>">
                                                                <a href="">
                                                                    <img class="img-responsive"
                                                                         src="{{ url('/') . '/' . $item->url }}">
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                        @foreach ($license_pdf as $item)
                                                            {{-- <li class="menu-item"> --}}
                                                            <button class="btn btn-success btn-lg mrb50"
                                                                    data-iframe="true" id="open-pdf"
                                                                    data-src="{{ url('/') . '/' . $item->url }}"
                                                                    style=" width: 23%; height: 200px; margin-bottom: 10px ">

                                                                <embed src="{{ url('/') . '/' . $item->url }}"
                                                                       width="100%" height="100%"/>
                                                                       <span>عرض</span>


                                                            </button>

                                                            {{-- </li> --}}
                                                        @endforeach

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ======= --}}
                                        <div class="tab-pane fade" id="Archives" role="tabpanel"
                                             aria-labelledby="#settings-list-item">
                                            <div class="col-xl-12 order-0 order-md-1">
                                                <div class="demo-gallery">
                                                    <ul id="lightgallery_2" class="lightgallery_2">
                                                        <li class="menu-item"
                                                            data-src="https://www.mexatk.com/wp-content/uploads/2015/09/%D8%AA%D9%86%D8%B2%D9%8A%D9%84-%D8%B5%D9%88%D8%B1-%D8%AD%D9%8A%D9%88%D8%A7%D9%86%D8%A7%D8%AA-2.jpg"
                                                            data-sub-html="<h4>111</h4>">
                                                            <a href="">
                                                                <img class="img-responsive"
                                                                     src="https://www.mexatk.com/wp-content/uploads/2015/09/%D8%AA%D9%86%D8%B2%D9%8A%D9%84-%D8%B5%D9%88%D8%B1-%D8%AD%D9%8A%D9%88%D8%A7%D9%86%D8%A7%D8%AA-2.jpg">
                                                            </a>
                                                        </li>

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- ======= --}}
                                        @foreach ($category_archive_attachments as $category_archive_attachment)
                                            <div class="tab-pane fade" id="bhm{{ $category_archive_attachment->id }}"
                                                 role="tabpanel" aria-labelledby="#profile-list-item">
                                                bhm{{ $category_archive_attachment->id }}
                                            </div>
                                        @endforeach
                                        {{-- ======= --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                {{-- ====================================================== --}}
                {{-- ProofOfCase --}}
                @if (Auth::user()->can('Read-ProofOfCase'))
                    <div class="tab-pane fade" id="ProofOfCase" role="tabpanel" aria-labelledby="#settings-list-item">
                        <div class="col-xl-12 order-0 order-md-1">
                            <div class="card mb-4">
                                @if (Auth::user()->can('Create-ProofOfCase'))
                                    <div class="dt-action-buttons text-end pt-3 pt-md-0 m-3">
                                        <div class="dt-buttons btn-group flex-wrap">
                                            <a href="javascript:;"
                                               class="btn btn-secondary create-new btn-primary waves-effect waves-light"
                                               id="add_new_ProofOfCase" data-bs-toggle="modal"
                                               data-bs-target="#show_add_ProofOfCase_model" type="button"><span><i
                                                        class="ti ti-plus me-sm-1">
                                                    </i> <span
                                                        class="d-none d-sm-inline-block">{{ __('Add New') }}</span></span>
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <div id="DataTables_Table_0_wrapper"
                                         class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                                        <table class="datatables-basic table dataTable no-footer dtr-column"
                                               id="table_Proof" aria-describedby="DataTables_Table_0_info">
                                            <thead>
                                            <tr>
                                                <th class="sorting">{{ __('#') }}</th>
                                                <th class="sorting">المراقب</th>
                                                <th class="sorting">المواطن</th>
                                                <th class="sorting">التاريخ</th>
                                                <th class="sorting">الساعة</th>
                                                <th class="sorting">التفاصيل</th>
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
                @endif
                {{-- ====================================================== --}}
            </div>
        </div>
    </div>

    <!-- Modal -->
    {{--  Edit Owners --}}
    <div class="modal fade" id="show_owner_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDataFormOwner" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="id" id="e_id">
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('first_name') }}:</label>
                            <input type="text" class="form-control" name="first_name" id="e_first_name">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('second_name') }}:</label>
                            <input type="text" class="form-control" name="second_name" id="e_second_name">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('third_name') }}:</label>
                            <input type="text" class="form-control" name="third_name" id="e_third_name">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('sur_name') }}:</label>
                            <input type="text" class="form-control" name="sur_name" id="e_sur_name">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('id_card') }}:</label>
                            <input type="number" class="form-control" name="id_card" id="e_id_card">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('phone_number') }}:</label>
                            <input type="number" class="form-control" name="phone_number" id="e_phone_number">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('mokalaf') }}:</label>
                            <input type="number" class="form-control" name="mokalaf" id="e_mokalaf">
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                            <textarea class="form-control" name="notes" id="e_notes" rows="3"></textarea>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
    {{-- Add Owners --}}
    <div class="modal fade" id="show_add_owner_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addFormOwner" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="current_owner" value="new">
                        <input type="hidden" name="building_id" value="{{ $building->id }}">

                        <div class="col-md-3 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('first_name') }}:</label>
                            <input type="text" class="form-control" name="first_name">
                        </div>
                        <div class="col-md-3 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('second_name') }}:</label>
                            <input type="text" class="form-control" name="second_name">
                        </div>
                        <div class="col-md-3 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('third_name') }}:</label>
                            <input type="text" class="form-control" name="third_name">
                        </div>
                        <div class="col-md-3 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('sur_name') }}:</label>
                            <input type="text" class="form-control" name="sur_name">
                        </div>
                        <div class="col-md-3 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('id_card') }}:</label>
                            <input type="number" class="form-control" name="id_card">
                        </div>
                        <div class="col-md-3 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('phone_number') }}:</label>
                            <input type="number" class="form-control" name="phone_number">
                        </div>
                        <div class="col-md-3 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('mokalaf') }}:</label>
                            <input type="number" class="form-control" name="mokalaf">
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                            <textarea class="form-control" name="notes" rows="3"></textarea>
                        </div>
                        <div class="col-12 mt-3">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    <div class="modal fade" id="show_transfer_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">{{ __('Transfer Property') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addDataForm" enctype="multipart/form-data" style="padding: 10px 20px 10px 0px;">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="building_id" value="{{ $building->id }}">
                    <input type="hidden" name="user_current" id="e_user_current">

                    <div class="row">
                        {{-- owner previos --}}
                        <div class="row">
                            <!-- <div class="text-light small fw-semibold py-2">بيانات المالك الحالي:</div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('first_name') }}:</label>
                                <input type="text" class="form-control" name="first_name" id="o_first_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('second_name') }}:</label>
                                <input type="text" class="form-control" name="second_name" id="o_second_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('third_name') }}:</label>
                                <input type="text" class="form-control" name="third_name" id="o_third_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">{{ __('sur_name') }}:</label>
                                <input type="text" class="form-control" name="sur_name" id="o_sur_name">
                            </div> -->
                        </div>
                        {{-- unit --}}
                        <div class="row">
                            {{-- write unit by jquary --}}
                            <div class="col-md-12 col-12 mt-3">
                                <div class="text-light small fw-semibold py-2">الوحدات المراد التنازل عنها لمالك جديد
                                </div>
                                <div class="row mx-3 mb-3 units_" id="units_area">

                                </div>
                            </div>
                        </div>

                        {{-- owner current --}}
                        <div class="row">
                            <div class="col-md-12 col-12 mt-3">
                                <label for="defaultFormControlInput" class="form-label">المالك الجديد:</label>
                                <div class="mb-3">
                                    <select class="form-select" id="current_owner" name="current_owner">
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- add new owner --}}
                        <div class="row mt-3" id="add_new_o">
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button type="button" class="accordion-button collapsed py-2 text-center d-block"
                                            data-bs-toggle="collapse" data-bs-target="#accordionThree"
                                            aria-expanded="false"
                                            aria-controls="accordionThree">
                                        أضف مالك جديد
                                    </button>
                                </h2>
                                <div id="accordionThree" class="accordion-collapse collapse"
                                     aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-3 col-12 mb-3">
                                                <label for="defaultFormControlInput"
                                                       class="form-label">{{ __('first_name') }}:</label>
                                                <input type="text" class="form-control" name="first_name">
                                            </div>
                                            <div class="col-md-3 col-12 mb-3">
                                                <label for="defaultFormControlInput"
                                                       class="form-label">{{ __('second_name') }}:</label>
                                                <input type="text" class="form-control" name="second_name">
                                            </div>
                                            <div class="col-md-3 col-12 mb-3">
                                                <label for="defaultFormControlInput"
                                                       class="form-label">{{ __('third_name') }}:</label>
                                                <input type="text" class="form-control" name="third_name">
                                            </div>
                                            <div class="col-md-3 col-12 mb-3">
                                                <label for="defaultFormControlInput"
                                                       class="form-label">{{ __('sur_name') }}:</label>
                                                <input type="text" class="form-control" name="sur_name">
                                            </div>

                                            <div class="col-md-6 col-12 mb-3">
                                                <label for="defaultFormControlInput"
                                                       class="form-label">{{ __('id_card') }}:</label>
                                                <input type="number" class="form-control" name="id_card">
                                            </div>
                                            <div class="col-md-6 col-12 mb-3">
                                                <label for="defaultFormControlInput"
                                                       class="form-label">{{ __('phone_number') }}:</label>
                                                <input type="number" class="form-control" name="phone_number">
                                            </div>
                                            <div class="col-md-12 col-12 mb-3">
                                                <label for="defaultFormControlInput"
                                                       class="form-label">{{ __('notes') }}:</label>
                                                <textarea class="form-control" name="notes" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="col-12 m-1">
                            <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    {{-- table_tax_details --}}
    <div class="modal fade" id="show_tax_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card mb-4">
                    <div class="mb-3">
                        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer px-3">
                            <table class="datatables-basic table dataTable no-footer dtr-column" id="table_tax_details"
                                   aria-describedby="DataTables_Table_0_info">
                                <thead>
                                <tr>
                                    <th class="sorting">{{ __('CODE') }}</th>
                                    <th class="sorting">{{ __('TAX_NAME') }}</th>
                                    <th class="sorting">{{ __('TAX_AMT') }}</th>
                                    <th class="sorting">{{ __('TAX_AMT_PAID') }}</th>
                                    <th class="sorting">{{ __('PAID') }}</th>
                                    <th class="sorting">{{ __('Notes') }}</th>
                                    <th class="sorting">{{ __('TAX_CURN') }}</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
                        <input type="hidden" name="building_id" value="{{ $building->id }}">

                        <div class="row">
                            <div class="text-light small fw-semibold">بيانات المبنى</div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">رقم الدور</label>
                                <select class="form-select " name="floor_number" id="floor_number">
                                    <option value="">أختر الدور</option>
                                    <option value="10" @if ($building->zero_floor_count > '0') disabled @endif>بدروم
                                    </option>

                                    <option value="0" @if ($building->zero_floor_count > '0') disabled @endif>ارضي سكني
                                    <option value="100" @if ($building->zero_floor_count > '0') disabled @endif>ارضي تجاري
                                    </option>
                                    <option value="1" @if ($building->one_floor_count > '0') disabled @endif>أول
                                    </option>
                                    <option value="2" @if ($building->two_floor_count > '0') disabled @endif>ثاني
                                    </option>
                                    <option value="3" @if ($building->three_floor_count > '0') disabled @endif>ثالث
                                    </option>
                                    <option value="4" @if ($building->four_floor_count > '0') disabled @endif>رابع
                                    </option>
                                    <option value="5" @if ($building->five_floor_count > '0') disabled @endif>خامس
                                    </option>
                                    <option value="6" @if ($building->sex_floor_count > '0') disabled @endif>سادس
                                    </option>
                                    <option value="7" @if ($building->seven_floor_count > '0') disabled @endif>سابع
                                    </option>
                                    <option value="8" @if ($building->zero_floor_count > '0') disabled @endif>ثامن
                                    </option>
                                    <option value="9" @if ($building->zero_floor_count > '0') disabled @endif>روف
                                    </option>
                                    <option value="11" @if ($building->zero_floor_count > '0') disabled @endif>بركس تجاري
                                    </option>
                                    <option value="12" @if ($building->zero_floor_count > '0') disabled @endif>بركس مزرعة دواجن
                                    </option>
                                    <option value="13" @if ($building->zero_floor_count > '0') disabled @endif>بركس مزرعة ابقار
                                    </option>
                                    <option value="14" @if ($building->zero_floor_count > '0') disabled @endif>بركس
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
                                <label for="defaultFormControlInput" class="form-label">المساحة المراد ترخيصها</label>
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
                        <hr>
                        <div class="row">
                            <div class="text-light small fw-semibold">بيانات الترخيص</div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">المساحة المرخصة</label>
                                <input type="text" class="form-control" name="licensed_area" id="licensed_area">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">سعر الترخيص لكل متر</label>
                                <input type="text" class="form-control" name="lic_per_meter" id="lic_per_meter">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">نسبة الخصم</label>
                                <input type="text" class="form-control" name="lic_fees_discount"
                                       id="lic_fees_discount">
                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">المبلغ المدفوع</label>
                                <input type="text" class="form-control" name="license_fees">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم إيصال الدفع</label>
                                <input type="text" class="form-control" name="payment_number" id="payment_number">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي</label>
                                <input type="text" class="form-control" id="total" value="0" >
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">قيمة الخصم</label>
                                <input type="text" class="form-control" id="lic_fees_disc_val" value="0"
                                >
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

                        <hr>
                        <div id="devlopment" style="display: none">
                            <div class="row">
                                <div class="text-light small fw-semibold">بيانات التطوير</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">مساحة الأرض</label>
                                    <input type="number" class="form-control" name="dev_buliding_area"
                                           id="dev_buliding_area" value="{{ $building->area }}">
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
                        <div class="row">
                            <div class="text-light small fw-semibold">بيانات المبنى</div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">رقم الدور</label>
                                <select class="form-select " name="floor_number" id="e_floor_number">
                                    <option value="">أختر الدور</option>
                                    <option value="10" @if ($building->zero_floor_count > '0') disabled @endif>بدروم
                                    </option>

                                    <option value="0" @if ($building->zero_floor_count > '0') disabled @endif>ارضي سكني
                                    <option value="100" @if ($building->zero_floor_count > '0') disabled @endif>ارضي تجاري
                                    </option>
                                    <option value="1" @if ($building->one_floor_count > '0') disabled @endif>أول
                                    </option>
                                    <option value="2" @if ($building->two_floor_count > '0') disabled @endif>ثاني
                                    </option>
                                    <option value="3" @if ($building->three_floor_count > '0') disabled @endif>ثالث
                                    </option>
                                    <option value="4" @if ($building->four_floor_count > '0') disabled @endif>رابع
                                    </option>
                                    <option value="5" @if ($building->five_floor_count > '0') disabled @endif>خامس
                                    </option>
                                    <option value="6" @if ($building->sex_floor_count > '0') disabled @endif>سادس
                                    </option>
                                    <option value="7" @if ($building->seven_floor_count > '0') disabled @endif>سابع
                                    </option>
                                    <option value="8" @if ($building->zero_floor_count > '0') disabled @endif>ثامن
                                    </option>
                                    <option value="9" @if ($building->zero_floor_count > '0') disabled @endif>روف
                                    </option>
                                    <option value="11" @if ($building->zero_floor_count > '0') disabled @endif>بركس تجاري
                                    </option>
                                    <option value="12" @if ($building->zero_floor_count > '0') disabled @endif>بركس مزرعة دواجن
                                    </option>
                                    <option value="13" @if ($building->zero_floor_count > '0') disabled @endif>بركس مزرعة ابقار
                                    </option>
                                    <option value="14" @if ($building->zero_floor_count > '0') disabled @endif>بركس
                                    </option>


                                </select>
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="exampleFormControlSelect1" class="form-label">الحالة</label>
                                <select class="form-select " name="is_licensed" id="e_floor_is_licensed">
                                    <option value="1">غير مرخص</option>
                                    <option value="2">مرخص وغير مستوفي الشروط</option>
                                    <option value="4">مرخص ومستوفي الشروط</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">المساحة المراد ترخيصها</label>
                                <input type="text" class="form-control" name="area" id="e_floor_area">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">المرخصة سابقا</label>
                                <input type="text" class="form-control" name="area_before" id="e_area_before">
                            </div>
                        </div>
                        <div class="col-md-3 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم طلب الترخيص</label>
                            <input type="text" class="form-control" name="payment_number" id="e_payment_number">
                        </div>
                        <hr>
                        <div class="row">
                            <div class="text-light small fw-semibold">بيانات الترخيص</div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">المساحة المرخصة</label>
                                <input type="text" class="form-control" name="licensed_area"
                                       id="e_floor_licensed_area">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">سعر الترخيص لكل متر</label>
                                <input type="text" class="form-control" name="lic_per_meter"
                                       id="e_floor_lic_per_meter">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">نسبة الخصم</label>
                                <input type="text" class="form-control" name="lic_fees_discount"
                                       id="e_floor_lic_fees_discount">
                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">المبلغ المدفوع</label>
                                <input type="text" class="form-control" name="license_fees"
                                       id="e_floor_license_fees">
                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي</label>
                                <input type="text" class="form-control" id="e_floor_total" value="0"
                                       disabled>
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">قيمة الخصم</label>
                                <input type="decimal" class="form-control" id="e_floor_lic_fees_disc_val"
                                       value="0">
                            </div>

                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي بعد
                                    الخصم</label>
                                <input type="text" class="form-control" id="e_floor_required_pay" value="0"
                                       >
                            </div>

                            <div class="col-md-12 col-12 mb-3">
                                <label for="e_floor_notes" class="form-label">{{ __('notes') }}:</label>
                                <textarea class="form-control" name="floors_notes" rows="3" id="e_floor_notes"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div id="edit_devlopment">
                            <div class="row">
                                <div class="text-light small fw-semibold">بيانات التطوير</div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">مساحة الأرض</label>
                                    <input type="text" class="form-control" id="dev_buliding_area"
                                           value="{{ $building->area }}">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">سعر التطوير لكل
                                        متر</label>
                                    <input type="text" class="form-control" name="dev_price_per_meter"
                                           id="e_dev_price_per_meter">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">نسبة الخصم</label>
                                    <input type="text" class="form-control" name="discount" id="e_dev_discount" step="0.001">
                                </div>

                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">المبلغ المدفوع</label>
                                    <input type="text" class="form-control" name="pay_fees" id="e_dev_pay_fees">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي</label>
                                    <input type="text" class="form-control" id="e_dev_totle_fees" step="0.001">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">قيمة الخصم</label>
                                    <input type="text" class="form-control" id="e_dev_discount_val"
                                           value="0" step="0.001">
                                </div>
                                <div class="col-md-3 col-12 mb-3">
                                    <label for="defaultFormControlInput" class="form-label">الملبغ الإجمالي بعد
                                        الخصم</label>
                                    <input type="text" class="form-control" id="e_dev_required_pay"
                                           value="0" step="0.001">
                                </div>
                                <div class="col-md-12 col-12 mb-3">
                                    <label for="defaultFormControlInput"
                                           class="form-label">{{ __('notes') }}:</label>
                                    <textarea class="form-control" name="e_dev_notes" id="e_dev_notes" rows="3"></textarea>
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
    {{-- ===================================== --}}
    {{-- Add Unit --}}
    <div class="modal fade" id="show_add_unit_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">أضف وحدة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNewUnit" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="building_id" value="{{ $building->id }}">

                        <div class="col-12">
                            <div class="demo-inline-spacing">
                                <div class="row">
                                    <div class="text-light small fw-semibold">مالكين الوحدة:</div>
                                    <div class="col-md-12">
                                        <ul class="pro-feature-add" style=" padding: 0; ">
                                            @foreach ($building->owners as $item)
                                                <label class="switch switch-primary my-2">
                                                    <input type="checkbox" class="switch-input"
                                                           id="{{ $item->id }}" name="owners[]"
                                                           value="{{ $item->id }}">
                                                    <span
                                                        class="switch-toggle-slider"><span class="switch-on"><i
                                                                class="ti ti-check"></i></span>
                                                                <span class="switch-off"><i class="ti ti-x"></i></span>
                                                            </span>
                                                    <span class="switch-label"
                                                          for="{{ $item->id }}">{{ $item->FullName }}</span>
                                                </label>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="col-md-4 col-12 mb-3">--}}
                        {{--                            <label for="defaultFormControlInput" class="form-label">المالك</label>--}}
                        {{--                            <select class="form-select " name="building_owner_id">--}}
                        {{--                                @foreach ($building->owners as $item)--}}
                        {{--                                    <option value="{{ $item->id }}">{{ $item->FullName }}</option>--}}
                        {{--                                @endforeach--}}
                        {{--                            </select>--}}
                        {{--                        </div>--}}
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الدور</label>
                            <select class="form-select " name="floor_number">
                                <option value="">أختر الدور</option>
                                <option value="0">أرضي</option>
                                <option value="1">أول</option>
                                <option value="2">ثاني</option>
                                <option value="3">ثالث</option>
                                <option value="4">رابع</option>
                                <option value="5">خامس</option>
                                <option value="6">سادس</option>
                                <option value="7">سابع</option>
                                <option value="8">ثامن</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">نوع الوحدة</label>
                            <select class="form-select " name="unit_type">
                                <option value="1">سكن</option>
                                <option value="2">تجاري</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">مستخدم الوحدة</label>
                            <select class="form-select " name="unit_use" id="unit_use">
                                <option value="1">المالك نفسه</option>
                                <option value="2">مستخدم جديد</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الوحدة</label>
                            <input type="text" class="form-control" name="unit_number">
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                            <textarea class="form-control" name="unit_notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div id="unit_use_form" style="display: none">
                        <div class="row my-3">
                            <div class="text-light small fw-semibold">بيانات مستخدم الوحدة:</div>
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
                                <input type="number" class="form-control" name="id_card">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الاتصال</label>
                                <input type="number" class="form-control" name="phone_number">
                            </div>
                            <div class="col-md-12 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">ملاحظات</label>
                                <textarea class="form-control" name="notes" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Edit Unit --}}
    <div class="modal fade" id="show_edit_unit_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel3">أضف وحدة جديدة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editNewUnit" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <input type="hidden" name="id" id="e_unit_id">
                        <div class="col-12">
                            <div class="demo-inline-spacing">
                                <div class="row">
                                    <div class="text-light small fw-semibold">مالكين الوحدة:</div>
                                    <div class="col-md-12">
                                        <ul class="pro-feature-add" style=" padding: 0; ">
                                            @foreach ($building->owners as $item)
                                                <label class="switch switch-primary my-2">
                                                    <input type="checkbox" class="switch-input"
                                                           id="{{ $item->id }}" name="owners[]"
                                                           value="{{ $item->id }}">
                                                    <span
                                                        class="switch-toggle-slider"><span class="switch-on"><i
                                                                class="ti ti-check"></i></span>
                                                                <span class="switch-off"><i class="ti ti-x"></i></span>
                                                            </span>
                                                    <span class="switch-label"
                                                          for="{{ $item->id }}">{{ $item->FullName }}</span>
                                                </label>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">المالك</label>
                            <select class="form-select " name="building_owner_id" id="e_building_owner_id">
                                @foreach ($building->owners as $item)
                                    <option value="{{ $item->id }}">{{ $item->FullName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الدور</label>
                            <select class="form-select " name="floor_number" id="e_floor_number">
                                <option value="">أختر الدور</option>
                                <option value="0">أرضي</option>
                                <option value="1">أول</option>
                                <option value="2">ثاني</option>
                                <option value="3">ثالث</option>
                                <option value="4">رابع</option>
                                <option value="5">خامس</option>
                                <option value="6">سادس</option>
                                <option value="7">سابع</option>
                                <option value="8">ثامن</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">نوع الوحدة</label>
                            <select class="form-select " name="unit_type" id="e_unit_type">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">مستخدم الوحدة</label>
                            <select class="form-select " name="unit_use" id="e_unit_use">
                                <option value="1">المالك نفسه</option>
                                <option value="2">مستخدم جديد</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الوحدة</label>
                            <input type="text" class="form-control" name="unit_number" id="e_unit_number">
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">{{ __('notes') }}:</label>
                            <textarea class="form-control" name="unit_notes" id="e_unit_notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div id="e_unit_use_form" style="display: none">
                        <div class="row my-3">
                            <div class="text-light small fw-semibold">بيانات مستخدم الوحدة:</div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الاسم الأول</label>
                                <input type="text" class="form-control" name="first_name" id="e_unit_first_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم الأب</label>
                                <input type="text" class="form-control" name="second_name"
                                       id="e_unit_second_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم الجد</label>
                                <input type="text" class="form-control" name="third_name" id="e_unit_third_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">اسم العائلة</label>
                                <input type="text" class="form-control" name="sur_name" id="e_unit_sur_name">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الهوية</label>
                                <input type="number" class="form-control" name="id_card" id="e_unit_id_card">
                            </div>
                            <div class="col-md-3 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">رقم الاتصال</label>
                                <input type="number" class="form-control" name="phone_number"
                                       id="e_unit_phone_number">
                            </div>
                            <div class="col-md-12 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">ملاحظات</label>
                                <textarea class="form-control" name="notes" id="e_unit_notes" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    {{-- Add Craft --}}
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
                        <input type="hidden" name="bulding_id" value="{{ $building->id }}">

                        <div class="row my-3">
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
                                    @foreach ($building->owners as $item)
                                        <option value="{{ $item->id }}">{{ $item->FullName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الوحدة</label>
                                <select class="form-select " name="unit_id" required>
                                    @foreach ($building->units as $item)
                                        <option value="{{ $item->id }}">{{ $item->unit_number }}</option>
                                    @endforeach
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
                        <input type="hidden" name="bulding_id" value="{{ $building->id }}">

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
                                <input type="text" class="form-control" name="owner_name" value="{{$building->owners->first()->first_name??''}}" required>
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
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">مالك العقار</label>
                                <select class="form-select " name="building_owner_id" id="craft_building_owner_id"
                                        required>
                                    @foreach ($building->owners as $item)
                                        <option value="{{ $item->id }}">{{ $item->FullName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 col-12 mb-3">
                                <label for="defaultFormControlInput" class="form-label">الوحدة</label>
                                <select class="form-select " name="unit_id" id="craft_unit_id" required>
                                    @foreach ($building->units as $item)
                                        <option value="{{ $item->id }}">{{ $item->unit_number }}</option>
                                    @endforeach
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
    {{-- ===================================== --}}
    {{--transfer Photo Category--}}
    <div class="modal fade" id="show_transferPhoto_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edittransferPhoto" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <input type="hidden" name="id" id="category_archive_id">
                        <div class="col-12 mb-3">
                            <label for="exampleFormControlSelect1" class="form-label">التصنيف الجديد</label>
                            <select class="form-select" name="name"
                                {{ Auth::user()->can('Update-Building') ? '' : 'disabled' }}>
                                @foreach ($category_archive_attachments as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
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
    {{-- ===================================== --}}
    {{-- Add ProofOfCase --}}
    <div class="modal fade" id="show_add_ProofOfCase_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNewProofOfCase" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="building_id" value="{{ $building->id }}">
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">اليوم</label>
                            <select class="form-select " name="day" required>
                                <option value="1">الأحد</option>
                                <option value="2">الاثنين</option>
                                <option value="3">الثلاثاء</option>
                                <option value="4">الاربعاء</option>
                                <option value="5">الخميس</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">التاريخ</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الساعة</label>
                            <input type="time" class="form-control" name="hours" required>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">المنطقة</label>
                            <input type="text" class="form-control" name="region" required>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label" required>القسمية</label>
                            <input type="text" class="form-control" disabled
                                   value="{{ $building->parcel_number }}">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">القطعة</label>
                            <input type="text" class="form-control" disabled
                                   value="{{ $building->block_number }}">
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">المواطن</label>
                            <input type="text" class="form-control" name="citizen" required>
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">التفاصيل</label>
                            <textarea class="form-control" name="details" rows="3" required></textarea>
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رفع الصور</label>
                            <input id="proof_photo" name="proof_photo[]" type="file" multiple>
                        </div>

                    </div>

                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit"
                                id="addNewProofOfCase_btn">حفظ
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Edit ProofOfCase --}}
    <div class="modal fade" id="show_edit_ProofOfCase_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-xl" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDataProof" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <input type="hidden" name="id" id="proof_id">
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">اليوم</label>
                            <select class="form-select " name="day" id="proof_day" required>
                                <option value="1">الأحد</option>
                                <option value="2">الاثنين</option>
                                <option value="3">الثلاثاء</option>
                                <option value="4">الاربعاء</option>
                                <option value="5">الخميس</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">التاريخ</label>
                            <input type="date" class="form-control" name="date" id="proof_date" required>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">الساعة</label>
                            <input type="time" class="form-control" name="hours" id="proof_hours" required>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">المنطقة</label>
                            <input type="text" class="form-control" name="region" id="proof_region" required>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label" required>القسمية</label>
                            <input type="text" class="form-control" disabled
                                   value="{{ $building->parcel_number }}">
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">القطعة</label>
                            <input type="text" class="form-control" disabled
                                   value="{{ $building->block_number }}">
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">المواطن</label>
                            <input type="text" class="form-control" name="citizen" id="proof_citizen" required>
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">التفاصيل</label>
                            <textarea class="form-control" name="details" rows="3" id="proof_details"
                                      required></textarea>
                        </div>
                        <div class="col-md-12 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رفع الصور</label>
                            <input id="e_proof_photo" name="proof_photo[]" type="file" multiple>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit"
                                id="editProofOfCase_btn">تحديث
                        </button>
                        <button class="btn btn-label-primary waves-effect" type="submit"
                                id="confirmProofOfCase_btn">اعتماد
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
    {{-- Add subscription --}}
    <div class="modal fade" id="show_add_subscription" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addNewSubscription" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="building_id" value="{{ $building->id }}">
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">مالك الاشتراك</label>
                            <select class="form-select " name="owner_id">
                                @foreach ($building->owners as $item)
                                    <option value="{{ $item->id }}">{{ $item->FullName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">نوع الاشتراك</label>
                            <select class="form-select " name="type">
                                <option value="1">اشتراك مياه</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الاشتراك</label>
                            <input type="text" class="form-control" name="subscription_number" required>
                        </div>
                        <div class="col-12">
                            <div class="demo-inline-spacing">
                                <div class="row">
                                    <div class="text-light small fw-semibold">الوحدات التي يخدمها الاشتراك:</div>
                                    <div class="col-md-12">
                                        <ul class="pro-feature-add" style=" padding: 0; ">
                                            @foreach ($building->units as $item)
                                                <label class="switch switch-primary my-2">
                                                    <input type="checkbox" class="switch-input"
                                                           id="{{ $item->id }}" name="units[]"
                                                           value="{{ $item->id }}">
                                                    <span
                                                        class="switch-toggle-slider"><span class="switch-on"><i
                                                                class="ti ti-check"></i></span>
                                                                <span class="switch-off"><i class="ti ti-x"></i></span>
                                                            </span>
                                                    <span class="switch-label"
                                                          for="{{ $item->id }}">{{ $item->unit_number }}</span>
                                                </label>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit"
                                id="addNewProofOfCase_btn">حفظ
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Edit subscription --}}
    <div class="modal fade" id="show_edit_subscription_model" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg" role="dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editSubscriptionForm" class="p-3" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <input type="hidden" name="id" id="subscription_id">
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">مالك الاشتراك</label>
                            <select class="form-select " name="owner_id" id="subscription_owner_id">
                                @foreach ($building->owners as $item)
                                    <option value="{{ $item->id }}">{{ $item->FullName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">نوع الاشتراك</label>
                            <select class="form-select " name="type" id="subscription_type">
                                <option value="1">اشتراك مياه</option>
                            </select>
                        </div>
                        <div class="col-md-4 col-12 mb-3">
                            <label for="defaultFormControlInput" class="form-label">رقم الاشتراك</label>
                            <input type="text" class="form-control" name="subscription_number" id="subscription_number" required>
                        </div>
                        <div class="col-12">
                            <div class="demo-inline-spacing">
                                <div class="row">
                                    <div class="text-light small fw-semibold">الوحدات التي يخدمها الاشتراك:</div>
                                    <div class="col-md-12">
                                        <ul class="pro-feature-add" style=" padding: 0; ">
                                            @foreach ($building->units as $item)
                                                <label class="switch switch-primary my-2">
                                                    <input type="checkbox" class="switch-input"
                                                           id="{{ $item->id }}" name="units[]"
                                                           value="{{ $item->id }}">
                                                    <span
                                                        class="switch-toggle-slider"><span class="switch-on"><i
                                                                class="ti ti-check"></i></span>
                                                                <span class="switch-off"><i class="ti ti-x"></i></span>
                                                            </span>
                                                    <span class="switch-label"
                                                          for="{{ $item->id }}">{{ $item->unit_number }}</span>
                                                </label>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 mt-3">
                        <button class="btn btn-label-primary waves-effect" type="submit"
                                id="addNewProofOfCase_btn">حفظ
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ===================================== --}}
@endsection
@push('scripts')
    <script src="https://unpkg.com/filepond-plugin-file-poster/dist/filepond-plugin-file-poster.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-pdf-preview/dist/filepond-plugin-pdf-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>

    <script src="https://cdn.rawgit.com/sachinchoolur/lightgallery.js/master/dist/js/lightgallery.js"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lg-fullscreen.js/master/dist/lg-fullscreen.js"></script>
    <script src="https://cdn.rawgit.com/sachinchoolur/lg-zoom.js/master/dist/lg-zoom.js"></script>

    {{-- <script src="https://cdn.rawgit.com/sachinchoolur/lg-pager.js/master/dist/lg-pager.js"></script> --}}
    {{-- <script src="https://cdn.rawgit.com/sachinchoolur/lg-autoplay.js/master/dist/lg-autoplay.js"></script> --}}
    {{-- <script src="https://cdn.rawgit.com/sachinchoolur/lg-share.js/master/dist/lg-share.js"></script> --}}

    {{-- <script src="https://cdn.rawgit.com/sachinchoolur/lg-hash.js/master/dist/lg-hash.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script> --}}

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/plugins/rotate/lg-rotate.min.js" integrity="sha512-5RFEmyJMZJEfPcXbVnwKA8SwcS5UqBRBPqpmDr4j37mdR6W2g0oCgnkAnTl6rtTfCumDjyG/A+NT0hPo9qsnpA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/2.7.1/css/lg-thumbnail.min.css" integrity="sha512-GRxDpj/bx6/I4y6h2LE5rbGaqRcbTu4dYhaTewlS8Nh9hm/akYprvOTZD7GR+FRCALiKfe8u1gjvWEEGEtoR6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     --}}

    <script>
        fillCraftTypes(1)
        lightGallery(document.getElementById('lightgallery'), {
            download: true,
            share: false,
            // thumbnail: true,
            // rotate: true,
        });
        lightGallery(document.getElementById('lightgallery_2'), {
            download: true,
            share: false,
            // thumbnail: true,
            // rotate: true,
        });
        // ==========================================
        // FilePond
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFilePoster,
            FilePondPluginPdfPreview,
            FilePondPluginFileMetadata,
        );
        var inputs = document.getElementById('proof_photo');
        const proof = FilePond.create(inputs);
        proof.server = {
            url: '',
            process: {
                url: "{{ route('proof-of-cases.UploadAttachment') }}",
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
        // ==============
        var inputs2 = document.getElementById('e_proof_photo');
        const proof2 = FilePond.create(inputs2);
        proof2.server = {
            url: '',
            process: {
                url: "{{ route('proof-of-cases.UploadAttachment') }}",
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
        {{--proof2.files = [{--}}
        {{--    source: "{{url('/').'/buildings/proof_photo/'. $building->proofs->attachments>url ?? '' }}",--}}
        {{--    options: {--}}
        {{--        type: "pdf",--}}
        {{--        metadata: {--}}
        {{--            poster: "{{url('/').'/buildings/proof_photo/'. $building->proofs->attachments>url ?? '' }}",--}}
        {{--        }--}}
        {{--    }--}}
        {{--}];--}}
        // ==========================================
        $(function () {
            // ==========================================
            //UPDATE BUILDING
            $("#editDataFormBuilding").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#editDataFormBuilding')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('buildings.update', $building->id) }}",
                    data: formData
                })
                    .then(function (response) {
                        toastr.success(response.data.message)
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
            // ==========================================
            $('.street_id').select2();
            // ==========================================
            //owners table
            $('#table_owner').DataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ Route('building_owner.all', $building->id) }}",
                language: {
                    'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'fullName',
                    name: 'fullName',
                    orderable: false,
                }, {
                    data: 'id_card',
                    name: 'id_card',
                    orderable: false,
                }, {
                    data: 'mokalaf',
                    name: 'mokalaf',
                    orderable: false,
                },
                    {
                        data: 'phone_number',
                        name: 'phone_number',
                        orderable: false,
                    }, {
                        data: 'notes',
                        name: 'notes',
                        orderable: false,
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            // ==============
            $('#table_owner_previous').DataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ Route('previous-owners.getPreviousOwnerForBuilding', $building->id) }}",
                language: {
                    'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                },
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'fullName',
                    name: 'fullName',
                    orderable: false,
                }, {
                    data: 'id_card',
                    name: 'id_card',
                    orderable: false,
                }, {
                    data: 'mokalaf',
                    name: 'mokalaf',
                    orderable: false,
                },
                    {
                        data: 'phone_number',
                        name: 'phone_number',
                        orderable: false,
                    }, {
                        data: 'notes',
                        name: 'notes',
                        orderable: false,
                    }
                ],

            });

            // $("#load_table_owner_previous").click(function() {
            //     $('#table_owner_previous').DataTable.ajax.reload();
            //     alert(4)
            // });
            // ==========================================
            $('#table_floor').DataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ Route('building_floor.all', $building->id) }}",
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
                    },{
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
            // ==========================================
            $('#table_unit').DataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ Route('building_unit.all', $building->id) }}",
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
                    }, {
                        data: 'unit_number',
                        orderable: false,
                    }, {
                        data: 'unit_type',
                        orderable: false,
                    }, {
                        data: 'unit_owners',
                        orderable: false,
                    }, {
                        data: 'unit_uses',
                        orderable: false,
                    }, {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
            // ==========================================
            $('#table_craft').DataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ Route('building_craft.all', $building->id) }}",
                language: {
                    'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                },

                columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'job_formal_name',
                    orderable: false,
                }, {
                    data: 'owner',
                    orderable: false,
                }, {
                    data: 'mokalaf',
                    orderable: false,
                }, {
                    data: 'id_card',
                    orderable: false,
                }, {
                    data: 'phone_number',
                    orderable: false,
                }, {
                    data: 'craft_number',
                    orderable: false,
                }, {
                    data: 'type_property',
                    orderable: false,
                }, {
                    data: 'notes',
                    orderable: false,
                }, {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }]
            });
            // ==========================================
            $('#table_subscription').DataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ Route('building_subscription.all', $building->id) }}",
                language: {
                    'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                },
                columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'owner_id_number',
                    orderable: false,
                }, {
                    data: 'owner_name',
                    orderable: false,
                }, {
                    data: 'owner_mokalaf',
                    orderable: false,
                }, {
                    data: 'subscription_number',
                    orderable: false,
                }, {
                    data: 'owner_phone_number',
                    orderable: false,
                },{
                    data: 'units',
                    orderable: false,
                }, {
                    data: 'action',
                    orderable: false,
                }
                ]
            });
            // =====================================
            $('#table_Proof').DataTable({
                processing: true,
                bDestroy: true,
                serverSide: true,
                ajax: "{{ Route('building_proof.all', $building->id) }}",
                language: {
                    'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                },
                columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'user_id',
                    orderable: false,
                }, {
                    data: 'citizen',
                    orderable: false,
                }, {
                    data: 'date',
                    orderable: false,
                }, {
                    data: 'hours',
                    orderable: false,
                }, {
                    data: 'details',
                    orderable: false,
                }, {
                    data: 'action',
                    orderable: false,
                }]


            });
            // =====================================
            //edit-owner
            $('body').on('click', '#show_owner', function () {
                //empty dom for units loop
                $("#units_area").empty();

                let id = $(this).data('id');
                let edit = "{{ url('/') }}" + '/home/building-owners/' + id + '/edit';

                //select all units in the model
                $('body').on('click', '#select-all', function () {
                    $('.selectItems').prop("checked", $(this).prop("checked"));
                })
                axios.get(edit)
                    .then(function (res) {
                        // console.log(res.data.units);
                        let units = res.data.units;
                        // console.log(units)
                        // <input type="checkbox" name="select-all" id="select-all" />

                        $('#units_area').append(
                            '<div class="form-check" style=" width: auto; margin: 0 10px; "><input class="form-check-input" type="checkbox" name="select-all" id="select-all" />الجميع</div>'
                        )
                        for (let i = 0; i < units.length; i++) {
                            console.log(units[i])

                            $('#units_area').append(
                                '<div class="form-check" style=" width: auto; margin: 0 10px; "><input type="checkbox" class="form-check-input selectItems" name="units_transfer[]" value="' +
                                units[i].id + '">' + '<label class="form-check-label"> ' + units[i]
                                    .unit_number + ' </label></div>')
                        }

                        $('#e_id').val(res.data.id)
                        $('#e_user_current').val(res.data.id)
                        $('#e_first_name').val(res.data.first_name)
                        $('#e_second_name').val(res.data.second_name)
                        $('#e_third_name').val(res.data.third_name)
                        $('#e_sur_name').val(res.data.sur_name)
                        $('#e_id_card').val(res.data.id_card)
                        $('#e_phone_number').val(res.data.phone_number)
                        $('#e_mokalaf').val(res.data.mokalaf)
                        $('#e_notes').val(res.data.notes)

                        $('#o_first_name').val(res.data.first_name)
                        $('#o_second_name').val(res.data.second_name)
                        $('#o_third_name').val(res.data.third_name)
                        $('#o_sur_name').val(res.data.sur_name)

                    })
                // ======================================
                let getAllOwners = "{{ Route('building_owner.all', $building->id) }}";
                $("#current_owner").empty();
                axios.get(getAllOwners)
                    .then(function (res) {
                        console.log(res.data.data);
                        let units_owners = res.data.data;
                        $('#current_owner').append(
                            '<option value="new">مالك جديد</option>'
                        )
                        for (let i = 0; i < units_owners.length; i++) {
                            $('#current_owner').append(
                                '<option value="' + units_owners[i].id + '">' + units_owners[i]
                                    .first_name + '</option>'
                            )
                        }
                    })
            })
            $("#editDataFormOwner").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#editDataFormOwner')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('building-owners.update_data') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_owner').DataTable().ajax.reload();
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
            //delete-owner
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
                        axios.delete("{{ url('/') }}" + '/home/building-owners/' + id)
                            .then(function (response) {
                                // console.log(response);
                                showMessage(response.data);
                                $('#table_owner').DataTable().ajax.reload();
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
            $("#addDataForm").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#addDataForm')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('building-owners.store') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_owner').DataTable().ajax.reload();
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
            // add owner
            $("#addFormOwner").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#addFormOwner')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('building-owners.storeOwnerNew') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_owner').DataTable().ajax.reload();
                        toastr.success(response.data.message, "{{ __('Saved') }}")
                        $('#addFormOwner').trigger("reset");
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

            // get all owners for building and foreach tax
            axios.get("{{ Route('building_owner.all', $building->id) }}")
                .then(function (res) {
                    // console.log(res.data.data);
                    let allOwners = res.data.data;
                    for (let i = 0; i < allOwners.length; i++) {
                        // console.log("/api/owner/get-tax-totals/" + allOwners[i].mokalaf);
                        if (allOwners[i].mokalaf > 0) {
                            $('#all_owners').append(
                                '<div class="col-md-6"> <div class="card mb-4"> <div class="dataTables_wrapper dt-bootstrap5 no-footer px-3"> <table class="datatables-basic table dataTable no-footer dtr-column mb-3" id="table_getTaxTotalsByCustomer' +
                                allOwners[i].mokalaf +
                                '" aria-describedby="DataTables_Table_0_info"> <thead> <div class="text-light small fw-semibold py-2">' +
                                allOwners[i].fullName +
                                '</div> <tr> <th class="sorting">العملة</th> <th class="sorting">نوع الرسم</th> <th class="sorting">اسم الرسم</th> <th class="sorting">المجموع</th> <th class="sorting">التفاصيل</th></tr> </thead> <tbody> </tbody> </table> </div> </div> </div>'
                            )
                            $('#table_getTaxTotalsByCustomer' + allOwners[i].mokalaf).DataTable({
                                processing: true,
                                ajax: {
                                    url: "{{ url('/') }}" + "/api/owner/get-tax-totals/" +
                                        allOwners[i].mokalaf,
                                    dataSrc: '',
                                },
                                language: {
                                    'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                                },

                                columns: [{
                                    data: 'curnCode',
                                    orderable: false,
                                }, {
                                    data: 'taxCode',
                                    orderable: false,
                                }, {
                                    data: 'taxName',
                                    orderable: false,
                                }, {
                                    data: 'taxTotal',
                                    orderable: false,
                                }, {
                                    data: 'action',
                                    orderable: false,
                                }]
                            });
                        } else {
                            $('#all_owners').append(
                                '<div class="col-md-6"> <div class="card mb-4"> <div class="dataTables_wrapper dt-bootstrap5 no-footer px-3"> <table class="datatables-basic table dataTable no-footer dtr-column mb-3" id="table_getTaxTotalsByCustomer" aria-describedby="DataTables_Table_0_info"> <thead> <div class="text-light small fw-semibold py-2">' +
                                allOwners[i].fullName +
                                '</div> <tr> <th class="sorting">العملة</th> <th class="sorting">نوع الرسم</th> <th class="sorting">اسم الرسم</th> <th class="sorting">المجموع</th> </tr> </thead> <tbody><tr class="odd"><td valign="top" colspan="8" class="dataTables_empty">لا يوجد رقم مكلف لهذا المالك</td></tr></tbody> </table> </div> </div> </div>'
                            )
                        }
                    }
                });
            // =======
            // تفاصيل الرسوم من النظان المالي
            $('body').on('click', '#show_tax', function (e) {
                e.preventDefault();
                let taxCode = $(this).data('id')
                let customer = $(this).data('customer')
                // alert(customer)
                let url = "{{ url('/') }}" + '/api/owner/get-tax-details/' + customer + '/' + taxCode
                $('#table_tax_details').DataTable({
                    processing: true,
                    bDestroy: true,
                    ajax: {
                        url: url,
                        dataSrc: '',
                    },
                    language: {
                        'url': "https://cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json",
                    },

                    columns: [{
                        data: 'TAX_CODE',
                        orderable: false,
                    }, {
                        data: 'TAX_NAME',
                        orderable: false,
                    }, {
                        data: 'TAX_AMT',
                        orderable: false,
                    }, {
                        data: 'TAX_AMT_PAID',
                        orderable: false,
                    }, {
                        data: 'PAID',
                        orderable: false,
                    }, {
                        data: 'NOTES',
                        orderable: false,
                    }, {
                        data: 'TAX_CURN',
                        orderable: false,
                    }]

                });
            });
            // =====================================
            //remove data form when click add button
            $('body').on('click', '#add_new_floor', function () {
                $('#addNewFloor')[0].reset();
            });

            //add Floor
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
                document.getElementById("total").value = document.getElementById("licensed_area").value * document
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

            // للنسبة قيمة الخصم
            $('body').on('change', '#lic_fees_disc_val', function () {
                document.getElementById("lic_fees_discount").value = document.getElementById("lic_fees_disc_val")
                    .value / document.getElementById("total").value * 100;
            });
            // للنسبة قيمة الخصم
            $('body').on('change', '#e_floor_lic_fees_disc_val', function () {
                let discount = Math.round(document.getElementById("e_floor_lic_fees_disc_val").value / document.getElementById("e_floor_total").value * 100)
                alert(discount)
                $("#e_floor_lic_fees_discount").val(parseInt(discount));
                // alert(document.getElementById("e_floor_lic_fees_discount").value)
            });
            $('body').on('change', '#e_floor_lic_fees_disc_val', function () {
                document.getElementById("e_floor_lic_fees_discount").value = document.getElementById("e_floor_lic_fees_disc_val")
                    .value / document.getElementById("e_dev_totle_fees").value * 100;
            });
            //السعر الاجمالي في التعديل
            $('body').on('change', '#e_dev_price_per_meter', function () {
                document.getElementById("e_dev_totle_fees").value = document.getElementById("dev_buliding_area")
                    .value * document.getElementById("e_dev_price_per_meter").value;
            });
            $('body').on('change', '#e_dev_discount_val', function () {
                document.getElementById("e_dev_discount").value = document.getElementById("e_dev_discount_val")
                    .value / document.getElementById("e_dev_totle_fees").value * 100;
                document.getElementById("e_dev_required_pay").value = document.getElementById("e_dev_totle_fees")
                    .value - document.getElementById("e_dev_discount_val").value;

            });
            $('body').on('change', '#e_dev_discount', function () {
                document.getElementById("e_dev_discount_val").value = document.getElementById(
                    "e_dev_totle_fees").value * document.getElementById("e_dev_discount")
                    .value / 100;
                //الملبغ الإجمالي بعد الخصم
                document.getElementById("e_dev_required_pay").value = document.getElementById(
                    "e_dev_totle_fees").value - document.getElementById("e_dev_discount_val").value;
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
                document.getElementById("e_floor_total").value = document.getElementById("e_floor_licensed_area")
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
            // ==================
            //المساحة المرخصة
            $('body').on('change', '#area_before', function () {
                document.getElementById("licensed_area").value = document.getElementById(
                    "area").value - document.getElementById("area_before").value;
            });
            $('body').on('change', '#e_area_before', function () {
                document.getElementById("e_floor_licensed_area").value = document.getElementById(
                    "e_floor_area").value - document.getElementById("e_area_before").value;
            });
            $('body').on('change', '#e_floor_area', function () {
                document.getElementById("e_floor_licensed_area").value = document.getElementById(
                    "e_floor_area").value - document.getElementById("e_area_before").value;
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
            $('body').on('change', '#e_floor_number', function () {

                let number = document.getElementById("e_floor_number").value;

                if (number == '0' || number == '100' || number == '11' || number == '12' || number == '13' || number == '14') {
                    document.getElementById("devlopment").style.display = "block";
                } else {
                    document.getElementById("devlopment").style.display = "none";
                }
            });

            // //بحسب المجموع الكلي
            // $('body').on('change', '#e_floor_lic_per_meter', function() {
            //     let area = document.getElementById("e_floor_area").value;
            //     let lic_per_meter = document.getElementById("e_floor_lic_per_meter").value;
            //     let valueTotal = area * lic_per_meter;
            //     var data = document.getElementById("e_floor_total").value = valueTotal;
            // });
            // //قيمة الخصم
            // $('body').on('change', '#e_floor_lic_fees_discount', function() {
            //     let licensed_area = document.getElementById("e_floor_licensed_area").value;
            //     let lic_fees_discount = document.getElementById("e_floor_lic_fees_discount").value;
            //     let valueTotal = licensed_area * lic_fees_discount / 100;
            //     var data = document.getElementById("e_floor_lic_fees_disc_val").value = valueTotal;
            // });

            // =======
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
                        $('#e_floor_lic_per_meter').val(res.data.lic_per_meter)
                        $('#e_floor_lic_fees_discount').val(res.data.lic_fees_discount)
                        $('#e_floor_total').val(res.data.lic_fees)
                        $('#e_floor_lic_fees_disc_val').val(res.data.lic_fees_disc_val)
                        $('#e_floor_license_fees').val(res.data.license_fees)
                        $('#e_floor_lic_number').val(res.data.lic_number)
                        $('#e_floor_is_licensed').val(res.data.is_licensed)
                        $('#e_floor_notes').val(res.data.notes)
                        if (res.data.floor_number == 0 || res.data.floor_number == 100 ) {
                            // document.getElementById('edit_devlopment').style.display = "block";
                            let devlopments = res.data.devlopments;
                            for (var i = 0; i < devlopments.length; i++) {
                                // console.log(devlopments[i].price_per_meter)
                                $('#e_dev_price_per_meter').val(devlopments[i].dev_price_per_meter)
                                $('#e_dev_discount').val(devlopments[i].discount)
                                $('#e_dev_pay_fees').val(devlopments[i].pay_fees)
                                $('#e_dev_totle_fees').val(devlopments[i].totle_fees)
                                e_dev_discount_val
                                $('#e_dev_totle_fees').val(devlopments[i].dev_price_per_meter * $('#dev_buliding_area').val())
                                $('#e_dev_discount_val').val($('#e_dev_discount').val() * $('#e_dev_totle_fees').val() /100 )
                                $('#e_dev_required_pay').val($('#e_dev_totle_fees').val() - $('#e_dev_discount_val').val())

                                $('#e_dev_notes').val(devlopments[i].dev_notes)

                            }
                        }
                        else {
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
            // ======================================
            // show form unit uses
            $('body').on('change', '#unit_use', function () {
                let val = document.getElementById("unit_use").value;
                if (val == '2') {
                    document.getElementById("unit_use_form").style.display = "block";
                } else {
                    document.getElementById("unit_use_form").style.display = "none";
                }
            });
            //add new unit
            $("#addNewUnit").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#addNewUnit')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('units.store') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_unit').DataTable().ajax.reload();
                        toastr.success(response.data.message, "{{ __('Saved') }}")
                        $('#addNewUnit').trigger("reset");
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
            //get data for edit
            $('body').on('click', '#editRowUnit', function () {
                let id = $(this).data('id');
                let edit = "{{ url('/') }}" + '/home/units/' + id + '/edit';
                axios.get(edit)
                    .then(function (res) {
                        // console.log(res.data)
                        $('#e_unit_id').val(res.data.id)
                        $('#e_building_owner_id').val(res.data.building_owner_id)
                        $('#e_floor_number').val(res.data.floor_number)
                        $('#e_unit_type').val(res.data.unit_type)
                        $('#e_unit_number').val(res.data.unit_number)
                        $('#e_unit_notes').val(res.data.unit_notes)
                        if (res.data.uses) {
                            document.getElementById("e_unit_use_form").style.display = "block";
                            $('#e_unit_first_name').val(res.data.uses.first_name)
                            $('#e_unit_second_name').val(res.data.uses.second_name)
                            $('#e_unit_third_name').val(res.data.uses.third_name)
                            $('#e_unit_sur_name').val(res.data.uses.sur_name)
                            $('#e_unit_id_card').val(res.data.uses.id_card)
                            $('#e_unit_phone_number').val(res.data.uses.phone_number)
                            $('#e_unit_notes').val(res.data.uses.notes)
                        }
                    })
            })
            // save edit unit
            $("#editNewUnit").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#editNewUnit')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('units.update_data') }}",
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
            //delete-unit
            $('body').on('click', '#deleteRowUnit', function (e) {
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
                        axios.delete("{{ url('/') }}" + '/home/units/' + id)
                            .then(function (response) {
                                // console.log(response);
                                showMessage(response.data);
                                $('#table_unit').DataTable().ajax.reload();
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
            // ======================================
            // Craft
            $("#addNewCraft").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#addNewCraft')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('economical.store') }}",
                    data: formData
                })
                    .then(function (response) {
                        console.log(response)
                        $('#table_craft').DataTable().ajax.reload();
                        toastr.success(response.data.message, "{{ __('Saved') }}")
                        $('#addNewCraft').trigger("reset");
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
            $("#changeImage").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#changeImage')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('building.changeImage') }}",
                    data: formData
                })
                    .then(function (response) {
                       $('#imageArea').html('<img src="' + response.data.url + '" width="300">')
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

            $('body').on('click', '#editRowCraft', function () {
                $('#editDataFloor')[0].reset();
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
            //edit Craft
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
                                $('#table_craft').DataTable().ajax.reload();
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
            // ======================================
            //api archive file
            // route('archives.getFileData', $building->file_number ?? 0)

            axios.get("{{route('archives.getFileData', $building->file_number ?? 0)}}")
                .then(function (res) {
                    // console.log(res)
                    let documents = res.data.documents;
                    // console.log(documents)
                    for (i = 0; i < documents.length; i++) {
                        $('.lightgallery_2').append(
                            // '<li class="menu-item" data-src="http://192.168.3.13/archive/public/fotoupload/' +
                           '<li class="menu-item" data-src="http://152.53.237.131/archive/fotoupload/' +
                            documents[i].document_image +
                            // '" data-sub-html="<h4></h4>"><a href="javascript:;"><img class="img-responsive" src="http://192.168.3.13/archive/public/fotoupload/' +
                           '" data-sub-html="<h4></h4>"><a href="javascript:;"><img class="img-responsive" src="http://localhost/archive/fotoupload/' +
                            documents[i].document_image +
                            '"></a><button class="btn btn-primary waves-effect waves-light" id="click_transfer_photo"  data-id="' +
                            documents[i]
                                .id +
                            '" href="javascript:;" data-bs-toggle="modal" data-bs-target="#show_transferPhoto_model" > <i class="fa-regular fa-pen-to-square"></i><span></span> </button></li>'
                        )
                    }
                    $('body').on('click', '#click_transfer_photo', function (e) {
                        e.preventDefault();
                        let id = $(this).data('id')
                        // alert(id)
                        $('#category_archive_id').val(id)
                    });
                    //
                    //         // Fileinput Comment
                    //         // let images = []
                    //         // let info = []
                    //         // let object = []
                    //         // for (i = 0; i < documents.length; i++) {
                    //         //     images[i] = "http://192.168.3.13/archive/public/fotoupload/" + documents[i].document_image
                    //         //     object['caption'] = documents[i].document_image
                    //         //     object['url'] = "http://192.168.3"
                    //         //     object['ke'] = documents[i].id
                    //
                    //         //     info[i] = object
                    //         // }
                    //         // $("#input-pr").fileinput({
                    //         //     minFileCount: 1,
                    //         //     overwriteInitial: false,
                    //         //     initialPreview: images,
                    //         //     initialPreviewAsData: true,
                    //         //     initialPreviewConfig: info,
                    //         // });
                    //
                });
            // ======================================
            //اضافة جديد لاثبات حالة
            $("#addNewProofOfCase_btn").on('click', function (e) {
                e.preventDefault();
                var formData = new FormData($('#addNewProofOfCase')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('proof-of-cases.store') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#addNewProofOfCase').trigger("reset");
                        $('#table_Proof').DataTable().ajax.reload();
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
            //get data for edit
            $('body').on('click', '#editRowProof', function () {
                $('#editDataProof').trigger("reset");
                // $( ".clearfix" ).empty();

                // $('#editDataProof')[0].reset();
                let id = $(this).data('id');
                let edit = "{{ url('/') }}" + '/home/proof-of-cases/' + id + '/edit';

                // $('#e_proof_photo').fileinput('clear');
                // $('#e_proof_photo').fileinput('reset');

                axios.get(edit)
                    .then(function (res) {
                        console.log(res.data)
                        $('#proof_id').val(res.data.id)
                        $('#proof_day').val(res.data.day)
                        $('#proof_date').val(res.data.date)
                        $('#proof_hours').val(res.data.hours)
                        $('#proof_region').val(res.data.region)
                        $('#proof_citizen').val(res.data.citizen)
                        $('#proof_details').val(res.data.details)

                        let photos = []
                        for (i = 0; i < res.data.attachments.length; i++) {
                            photos[i] = res.data.attachments[i].url
                        }
                        $("#e_proof_photo").fileinput({
                            showUpload: false,
                            showRemove: false,
                            overwriteInitial: false,
                            showClose: false,
                            initialPreview: photos,
                            initialPreviewAsData: true,
                        });


                    })
            })
            //edit
            $("#editProofOfCase_btn").on('click', function (e) {
                e.preventDefault();
                var formData = new FormData($('#editDataProof')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('proof-of-cases.update_data') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_Proof').DataTable().ajax.reload();
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
            //اعتماد
            $("#confirmProofOfCase_btn").on('click', function (e) {
                e.preventDefault();
                var formData = new FormData($('#editDataProof')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('proof-of-cases.confirm') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_Proof').DataTable().ajax.reload();
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
            //delete
            $('body').on('click', '#deleteRowProof', function (e) {
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
                        axios.delete("{{ url('/') }}" + '/home/proof-of-cases/' + id)
                            .then(function (response) {
                                // console.log(response);
                                showMessage(response.data);
                                $('#table_Proof').DataTable().ajax.reload();
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
            // ======================================
            $("#add_file_for_licenseForm").on('submit', function (e) {
                e.preventDefault();

                var formData = new FormData($('#add_file_for_licenseForm')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('buildings.uploadAttchment') }}",
                    data: formData
                })
                    .then(function (response) {
                        toastr.success(response.data.message, "{{ __('Saved') }}")
                        location.reload();
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
            // ======================================
            // Subscription
            $("#addNewSubscription").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#addNewSubscription')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('subscriptions.store') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_subscription').DataTable().ajax.reload();
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
            //delete
            $('body').on('click', '#deleteSubscription', function (e) {
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
                        axios.delete("{{ url('/') }}" + '/home/subscriptions/' + id)
                            .then(function (response) {
                                // console.log(response);
                                showMessage(response.data);
                                $('#table_subscription').DataTable().ajax.reload();
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
            $('body').on('click', '#editSubscription', function () {
                $('#editDataFloor')[0].reset();
                let id = $(this).data('id');
                let edit = "{{ url('/') }}" + '/home/subscriptions/' + id + '/edit';
                axios.get(edit)
                    .then(function (res) {
                        // console.log(res.data)
                        $('#subscription_id').val(res.data.id)
                        $('#subscription_owner_id').val(res.data.owner.id)
                        $('#subscription_type').val(res.data.type)
                        $('#subscription_number').val(res.data.subscription_number)

                    })
            })
            //edit
            $("#editSubscriptionForm").on('submit', function (e) {
                e.preventDefault();
                var formData = new FormData($('#editSubscriptionForm')[0]);
                axios({
                    method: 'post',
                    url: "{{ route('subscriptions.update_data') }}",
                    data: formData
                })
                    .then(function (response) {
                        $('#table_subscription').DataTable().ajax.reload();
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
            // ======================================
            $('body').on('click', '#del_license_pdf', function (e) {
                e.preventDefault();
                // alert(4444)
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
                        axios.delete("{{ url('/') }}" + '/home/subscriptions/' + id)
                            .then(function (response) {
                                // console.log(response);--}}
                            showMessage(response.data);
                                $('#table_subscription').DataTable().ajax.reload();
                            }).catch(function (error) {
                            // console.log(error);--}}
                            showMessage(error.response.data);
                        })
                    }
                });

                {{--function showMessage(data) {--}}
                {{--    Swal.fire({--}}
                {{--        position: 'top-end',--}}
                {{--        icon: data.icon,--}}
                {{--        title: data.title,--}}
                {{--        showConfirmButton: false,--}}
                {{--        timer: 1500--}}
                {{--    })--}}
                {{--}--}}
            });

            // ======================================

        });

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
    </script>
@endpush
