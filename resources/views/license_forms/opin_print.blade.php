<!DOCTYPE html>

<html lang="en" class="light-style" dir="rtl" data-theme="theme-default" data-assets-path="../../assets/"
      data-template="horizontal-menu-template-no-customizer">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>بلدية بيت حانون</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico"/>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500&display=swap" rel="stylesheet">


    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/fonts/fontawesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/fonts/tabler-icons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/fonts/flag-icons.css') }}"/>

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/css/rtl/core.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/css/rtl/theme-default.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dash/assets/css/demo.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/node-waves/node-waves.css') }}"/>
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/typeahead-js/typeahead.css') }}"/>

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/css/pages/app-invoice-print.css') }}"/>
    <!-- Helpers -->
    <script src="{{ asset('dash/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('dash/assets/js/config.js') }}"></script>
    <style>
        body {
            font-family: Tajawal;
        }

        @page {
            size: auto;
            margin: 0;
        }
        .opin {
            margin: 10px 0;
        }
        .opin h4 {
            font-weight: 500;
            font-size: 16px;
        }
    </style>

</head>

<body>
<!-- Content -->

<div class="invoice-print p-5">
    <div class="d-flex justify-content-between flex-row">
        <div class="mb-4">
        <p class="mb-1">دولة فلسطين</p>
                <p class="mb-1">وزارة الحكم المحلي</p>
                <p class="mb-0">دائرة الهندسة و التنظيم</p>
        </div>
        <div class="text-center">
            <img src="{{ asset('dash/logo.png') }}" width="55px"><br>
            <h4 class="app-brand-text fw-bold"> بلدية بيت حانون </h4>
        </div>
        <div>
            <h4 class="fw-bold"> طلب ترخيص</h4>
            <div class="mb-2">
                <span class="text-muted">تاريخ الطلب: </span>
                <span>{{ $license->created_at->format('d-m-Y') }}</span>
            </div>
            <div>
                <span class="text-muted">رقم الطلب: </span>
                <span>{{ \Carbon\Carbon::now()->format('Y') }} / {{ $license->index }}</span>
            </div>
        </div>
    </div>
    <hr/>
    <div class="card-header d-flex justify-content-between pb-0">
                                    <h6 class="card-title">الإسم /  {{ $license->owner->FullName }}</h6>
                                    <div class="dropdown chart-dropdown">
                                      هوية رقم ({{ $license->owner->id_card}}) 
                                    </div>
                                </div>
                                <hr />
    <h6 style="text-align: center">آراء الأقسام</h6>
    <div class="row d-flex justify-content-between mb-4">
    @if($license->legal_opin)
        <div class="opin">
            <h4>الرأي القانوني - 
            @if($license->legal_opin->status == 0)
            <div class="ms-3 badge bg-label-danger">غير معتمد</div>
            @else
            <div class="ms-3 badge bg-label-success">معتمد</div>
            @endif
            <small>(اخر تحديث: {{$license->legal_opin->updated_at}}) - (بواسطة: {{$license->legal_opin->user->name}})</small>

        </h4>
           
            
            <span>{{ $license->legal_opin->reply ?? '' }}</span>
        </div><hr>
        @endif
        <div class="opin">
            <h4>رأي قسم المساحة
            @if($license->area_opin->status == 0)
            <div class="ms-3 badge bg-label-danger">غير معتمد</div>
            @else
            <div class="ms-3 badge bg-label-success">معتمد</div>
            @endif
            <small>((اخر تحديث: {{$license->area_opin->updated_at}})  - (بواسطة: {{$license->area_opin->user->name}})</small>
   
        </h4>
           
            
            <span>{{ $license->area_opin->reply ?? '' }}</span>
        </div><hr>
        @if($license->plan_opin)
        <div class="opin">
            <h4>رأي قسم التخطيط الحضري
            @if($license->plan_opin->status == 0)
            <div class="ms-3 badge bg-label-danger">غير معتمد</div>
            @else
            <div class="ms-3 badge bg-label-success">معتمد</div>
            @endif
            <small>(اخر تحديث: {{$license->plan_opin->updated_at}}) - (بواسطة: {{$license->plan_opin->user->name}})</small>

            </h4>
           
            
            <span>{{ $license->plan_opin->reply ?? '' }}</span>
        </div><hr>
        @endif
        <div class="opin">
            <h4>رأي قسم المياه
            @if($license->water_opin->status == 0)
            <div class="ms-3 badge bg-label-danger">غير معتمد</div>
            @else
            <div class="ms-3 badge bg-label-success">معتمد</div>
            @endif
            <small>(اخر تحديث: {{$license->water_opin->updated_at}}) - (بواسطة: {{$license->water_opin->user->name}})</small>

            </h4>
           
            
            <span>{{ $license->water_opin->reply ?? '' }}</span>
        </div><hr>
        <div class="opin">
            <h4>رأي قسم الصرف الصحي
            @if($license->sewer_opin->status == 0)
            <div class="ms-3 badge bg-label-danger">غير معتمد</div>
            @else
            <div class="ms-3 badge bg-label-success">معتمد</div>
            @endif
            <small>(اخر تحديث: {{$license->sewer_opin->updated_at}}) - (بواسطة: {{$license->sewer_opin->user->name}})</small>

            </h4>
           
            

            <span>{{ $license->sewer_opin->reply ?? '' }}</span>
        </div><hr>
        <div class="opin">
            <h4>رأي قسم الجباية
            @if($license->collection_opin)

            @if($license->collection_opin->status == 0)
            <div class="ms-3 badge bg-label-danger">غير معتمد</div>
            @else
            <div class="ms-3 badge bg-label-success">معتمد</div>
            @endif
            <small>(اخر تحديث: {{$license->collection_opin->updated_at}}) - (بواسطة: {{$license->collection_opin->user->name}})</small>

            </h4>
            @endif

            

            <span>{{ $license->collection_opin->reply ?? '' }}</span>
        </div><hr>
        @if($license->gis_opin )
        <div class="opin">
            <h4>رأي قسم GIS
            @if($license->gis_opin->status == 0)
            <div class="ms-3 badge bg-label-danger">غير معتمد</div>
            @else
            <div class="ms-3 badge bg-label-success">معتمد</div>
            @endif
            <small>(اخر تحديث: {{$license->gis_opin->updated_at}}) - (بواسطة: {{$license->gis_opin->user->name}})</small>

            </h4>
           
            

            <span>{{ $license->gis_opin->reply ?? '' }}</span>
            @endif
        </div><hr>
    </div>
</div>
<!-- / Content -->
<script>
    window.print()
</script>
</body>

</html>
