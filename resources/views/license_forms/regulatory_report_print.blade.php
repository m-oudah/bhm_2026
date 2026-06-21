<!DOCTYPE html>

<html lang="en" class="light-style" dir="rtl" data-theme="theme-default" data-assets-path="../../assets/"
    data-template="horizontal-menu-template-no-customizer">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>بلدية بيت حانون</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500&display=swap" rel="stylesheet">


    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/fonts/tabler-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/css/rtl/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/css/rtl/theme-default.css') }}" />
    <link rel="stylesheet" href="{{ asset('dash/assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/typeahead-js/typeahead.css') }}" />

    <!-- Page CSS -->

    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/css/pages/app-invoice-print.css') }}" />
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

        .invoice-print.p-5 {
            width: 800px;
            margin: auto;
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
        <hr />
        <div class="card-header d-flex justify-content-between pb-0">
                                    <h6 class="card-title">الإسم /  {{ $regulatory_report->owner->FullName }}</h6>
                                    <div class="dropdown chart-dropdown">
                                      هوية رقم ({{ $regulatory_report->owner->id_card}}) 
                                    </div>
                                </div>
                                <hr />
        <div class="row d-flex justify-content-between mb-4">
            <div class="col-12 mb-3 mt-2">
                <div>
                    <h3 style=" text-align: center; text-decoration: underline; ">تقرير كشف تنظيمي</h3>
                    <p>بالكشف التنظيمي عن أرض القسيمة رقم : <span> ....{{ $regulatory_report->parcel_number }}....
                        </span> قطعة رقم : <span> ....{{ $regulatory_report->block_number }}.... </span>
                        من أراضي محلة : <span> ....{{ $regulatory_report->region }}.... </span> تبين مايلي :- <br />
                        1. مساحة القسمية الإجمالية : <span>
                            ....{{ $regulatory_report->report->total_coupon_space }}....م2 والمستدعي : <span>
                                ....{{ $regulatory_report->report->Property }}.... </span><br>
                            2. القسيمة : ....{{ $regulatory_report->report->Sorted }}....<br>
                            3. طبقا للمخطط الهيكلي العام - التفصيلي تعتبر االمنطقة :
                            ....{{ $regulatory_report->report->RegionReport }}....<br>
                            4. حالة الموقع وقت تقديم الطلب :
                            <span>....{{ $regulatory_report->report->Location }}....</span><br>
                        </span>
                    </p>
                </div>

                <div>
                    <p><strong>وصف البناء قائم أو المراد قامته وهدف استعماله</strong><br>
                        مساحة البناء : <span>............ {{ $regulatory_report->report->building_area }}
                            ............</span><br>
                        الارتدادات : <span>............{{ $regulatory_report->report->rebounds_front }} امامي -
                            {{ $regulatory_report->report->rebounds_back }} خلفي -
                            {{ $regulatory_report->report->rebounds_right }} يمين -
                            {{ $regulatory_report->report->rebounds_left }} يسار............</span><br>
                        نسبة البناء : <span>............ {{ (int)$regulatory_report->report->construction_ratio }} %
                            ............</span><br>
                        هدف استعمال البناء :
                        <span>............{{ $regulatory_report->report->purpose_building_use }}............</span>

                    </p>
                </div><br>
                <div>
                    <p><strong>الموقع على شارع أو شوارع هيكلية أو تفصيلية أو تنظمية : </strong><br>
                        {{ $regulatory_report->report->site_on_structural }}
                    </p>
                    <p><strong>يمر بالموقع شارع أو شوارع هيكيلية أو تفصيلية أو مساحية : </strong><br>
                        {{ $regulatory_report->report->passes_through_site }}
                    </p>
                    <p><strong>الشروط التنظيمية للمنطقة : </strong><br>
                        {{ $regulatory_report->report->territory_regulatory_requirement }}
                    </p>

                    <!-- <p><strong>ملاحظات دائرة التنظيم : </strong><br>
                        {{ $regulatory_report->report->department_notes }}
                    </p> -->
                    <div style=" text-align: end; ">
                        <p>مراقب الأبنية/ قاسم الكفارنة</p>
                        <p>اخر تحديث : {{$regulatory_report->report->updated_at->format('d-m-Y')}}<p>

                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- / Content -->
    <script>
        window.print()
    </script>
</body>

</html>
