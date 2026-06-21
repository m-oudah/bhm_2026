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
    </style>

</head>

<body>
    <!-- Content -->

    <div class="invoice-print p-5">
        <div class="d-flex justify-content-between flex-row">
            <div class="mb-4">
                <p class="mb-1">دولة فلسطين</p>
                <p class="mb-1">وزارة الحكم المحلي</p>
                <p class="mb-0">دائرة الحرف و الصناعات</p>
            </div>
            <div class="text-center">
                <img src="{{ asset('dash/logo.png') }}" width="55px"><br>
                <h4 class="app-brand-text fw-bold"> بلدية بيت حانون </h4>
            </div>
            <div>
                <h4 class="fw-bold"> طلب ترخيص حرفة جديدة</h4>
                <div class="mb-2">
                    <span class="text-muted">تاريخ الطلب: </span>
                    <span>{{\Carbon\Carbon::now()->format('d-m-Y') }}</span>
                </div>
                <div>
                    <span class="text-muted">رقم الطلب: </span>
                    <span>0</span>
                </div>
            </div>
        </div>
        <hr />

        <div class="row d-flex justify-content-between mb-4">
            
            <div class="col-sm-12 col-lg-12 my-3">
                <h6>بيانات الطلب:
                </h6>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="pe-3">اسم صاحب الحرفة:</td>
                            <td>{{$request -> name}}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">رقم الهوية:</td>
                            <td>{{$request -> id_card}}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">رقم الاتصال:</td>
                            <td>{{$request -> mobile}}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">العنوان:</td>
                            <td>{{$request -> address}}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">اسم صاحب المبنى:</td>
                            <td>{{$request -> owner_name}}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">رقم هوية صاحب المبنى:</td>
                            <td>{{$request -> owner_id_card}}</td>
                        </tr>
                        <tr>
                            <td class="pe-3">ملكية المكان:</td>
                            <td>{{$request -> type_property}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          
        </div>
        <h4 style=" text-align: end; margin-top: 100px; font-weight: 500; font-size: 16px; ">توقيع مقدم الطلب</h4>
        <br>
        <hr>
        <div class="card">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="mb-0">ملاحظات مفتش الحرف</h5>
                        <small class="text-muted"></small>
                      </div>
                    </div>
                    <div class="card-body">
                      <div id="salesLastMonth"></div>
                      <br>
                      <br>
                      <br>
                      <br>
                    </div>
        </div>
    <!-- / Content -->
    <script>
        window.print()
    </script>
</body>

</html>
