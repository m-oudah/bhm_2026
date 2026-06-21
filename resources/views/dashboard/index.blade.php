@extends('layouts.master')
@section('title', __('Home'))

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
                                        <h5 class="mb-0">{{$building_count1}}</h5>
                                        <small>إجمالي المباني</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-info me-3 p-2">
                                        <i class="ti ti-users ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$building_count2}}</h5>
                                        <small>مباني غير مرخصة</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <i class="ti ti-shopping-cart ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$building_count3}}</h5>
                                        <small>مباني مرخصة وغير مستوفية الرسوم</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-currency-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$building_count4}}</h5>
                                        <small>مباني مرخصة ومتبقي طوابق غير مرخصة</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-currency-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{$building_count4}}</h5>
                                        <small>مباني مرخصة  ومستوفية الرسوم</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics -->
        </div>
        <div class="row">
        <div class="col-xl-12 mb-4 col-lg-7 col-6">
            <div class="card">
                <h5 class="card-header">طلبات الترخيص</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>موضوع الطلب</th>
                            <th>الاسم كامل</th>
                            <th>رقم الهوية</th>
                            <th>رقم الاتصال</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @forelse($licenseForm as $item)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a href="{{route('license_forms.show', $item->id?? 0)}}">{{$item->subject}}</a> </td>
                            <td>{{$item->owner ? $item->owner->FullName : ''}}</td>
                            <td>{{$item->owner ? $item->owner->id_card : ''}}</td>
                            <td>{{$item->owner ? $item->owner->phone_number : ''}}</td>
                        </tr>
                        @empty
                            لا يوجد طلبات جديدة
                        @endforelse
                        </tbody>
                    </table>
                    {{$licenseForm -> links()}}

                </div>

            </div>
        </div>
        </div>
    </div>
@endsection
