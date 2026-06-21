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
                <span>{{ $regulatory_report->created_at->format('d-m-Y') }}</span>
            </div>
            <div>
                <span class="text-muted">رقم الطلب: </span>
                <span>{{ \Carbon\Carbon::now()->format('Y') }} / {{ $regulatory_report->index }}</span>
            </div>
        </div>
    </div>
    <hr/>
    <div class="card-header d-flex justify-content-between pb-0">
                                    <h6 class="card-title">الإسم /  {{ $regulatory_report->owner->FullName }}</h6>
                                    <div class="dropdown chart-dropdown">
                                      هوية رقم ({{ $regulatory_report->owner->id_card}}) 
                                    </div>
                                </div>
                                <hr />
    <h6 style="text-align: center">تقرير اللجنة الفنية</h6>
    <hr>
        <div class="opin">
            <h6>  الرأي الفني لقسم التنظيم</h6>
            <h6>بواسطة : يوسف فخري الكفارنة   - <small>اخر تحديث ({{$regulatory_report->report->updated_at->format('Y-m-d')}})</small></h6>
            
            <!-- <small>(اخر تحديث: {{$regulatory_report->report->update_at}})</small> -->

            <textarea class="form-control" rows="5">{!!$regulatory_report->report->department_notes!!}</textarea>

        <div class="row d-flex justify-content-between mb-4">
        
        </div>
        <div class="opin">
            <h6>: رأي اللجنة الفنية</h6>
            <!-- <small>(اخر تحديث: {{$regulatory_report->report->update_at}})</small> -->

            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">التوقيعات:.........................................................................................................................................................................</p>

           
            
        </div>
        <hr>
        <div class="opin">
            <!-- <h6>: رأي اللجنة الفنية</h6> -->
            <!-- <small>(اخر تحديث: {{$regulatory_report->report->update_at}})</small> -->

            <p class="mb-0">قرار لجنة التنظيم:...............................................رقم الجلية:...................................تاريخ الانعقاد:.........................</p>
            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">...............................................................................................................................................................................</p>
            <p class="mb-0">التوقيعات:....................................................................................................................................................................</p>

           
            
        </div>
        <hr>
        <div class="opin">
            <h6>: اعضاء لجنة التنظيم</h6>
            <!-- <small>(اخر تحديث: {{$regulatory_report->report->update_at}})</small> -->
            <p class="mb-0">التوقيعات:....................................................................................................................................................................</p>

            <p class="mb-0">...................................                                   ....................................                                  ...................................</p>
            <p class="mb-0">...................................                                   ....................................                                  ...................................</p>
            <p class="mb-0">...................................                                   ....................................                                  ...................................</p>

           
            
        </div>
        <h6 style="text-align: left;">رئيس اللجنة المحلية للأبنية و التنظيم</h6>

    </div>

    </div>
    <hr/>
    <div class="card-header d-flex justify-content-between pb-0">
                                    <h6 class="card-title">الإسم /  {{ $regulatory_report->owner->FullName }}</h6>
                                    <div class="dropdown chart-dropdown">
                                      هوية رقم ({{ $regulatory_report->owner->id_card}}) 
                                    </div>
                                </div>
                                <hr />
    <h6 style="text-align: center">تقرير اللجنة الفنية</h6>
    </div>
    <hr>
        <div>
            <h6>: رأي اللجنة الفنية</h6>
            <!-- <small>(اخر تحديث: {{$regulatory_report->report->update_at}})</small> -->

            .........................................

           
            
        </div>

    </div> 

</div>


           
            
        <hr>

<!-- / Content -->
<script>
    window.print()
</script>
</body>

</html>
