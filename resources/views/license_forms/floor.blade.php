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
                <span>{{ $license->created_at->format('d-m-Y') }}</span>
            </div>
            <div>
                <span class="text-muted">رقم الطلب: </span>
                <span>{{ \Carbon\Carbon::now()->format('Y') }} / {{ $license->index }}</span>
            </div>
        </div>
    </div>
    <hr />
    <div class="card-header d-flex justify-content-between pb-0">
                                    <h6 class="card-title">الإسم /  {{ $license->owner->FullName }}</h6>
                                    <div class="dropdown chart-dropdown">
                                      هوية رقم ({{ $license->owner->id_card}}) 
                                    </div>
                                </div>
                                <hr />

    <div class="row">
        <h6 class="text-center py-3">رسوم الترخيص و المساهمة التطويرية</h6>
        <div class="col-12 mb-3 mt-2">
            <h6>رسوم الترخيص</h6>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">البيان</th>
                    <th scope="col">المساحة</th>
                    <th scope="col">سعر المتر</th>
                    <th scope="col">المطلوب بالشيكل</th>
                    <th scope="col">نسبة الخصم</th>
                    <th scope="col">قيمة الخصم</th>
                    <th scope="col">المدفوع بالشيكل</th>
                    <th scope="col">المتبقي بالشيكل</th>


                </tr>
                </thead>
                <tbody>
                @foreach($license->floors as $item)
                <tr>
                    <th scope="row">{{$item->FloorNum ?? 0}}</th>
                    <td>{{$item->area ?? 0}}</td>
                    <td>{{$item->lic_per_meter ?? 0}}</td>
                    <td>{{$item->lic_fees ?? 0}}</td>
                    @if($item->lic_fees != 0)
                    <td>{{(int)($item -> lic_fees_disc_val / $item->lic_fees * 100)}} %</td>
                    @else
                    <td>0 %</td>
                    @endif
                    <td>{{$item -> lic_fees_disc_val}}</td>
                    <td>{{$item -> license_fees??0}}</td>
                    <td>{{(int)($item -> lic_fees - $item -> lic_fees_disc_val - $item -> license_fees)}}</td>

                </tr>
                @endforeach
                <tr>
                    <th scope="row">الاجمالي</th>
                    <td></td>
                    <td></td>
                    <td>{{$license->floors->sum('lic_fees') ?? 0}}</td>
                    @if($license->floors->sum('lic_fees') !=0)
                    <td>{{(int)($license->floors -> sum('lic_fees_disc_val') / $license->floors->sum('lic_fees') * 100)}} %</td>
                    @else
                    <td>0%</td>
                    @endif
                    <td>{{$license->floors -> sum('lic_fees_disc_val')}}</td>
                    <td>{{$license->floors -> sum('license_fees')??0}}</td>
                    <td>{{(int)($license->floors -> sum('lic_fees') - $license->floors -> sum('lic_fees_disc_val') - $license->floors -> sum('license_fees'))}}</td>

                </tr>
                </tbody>
            </table>
        </div>
    
        <div class="col-12 mb-3 m-2">
            <h6>رسوم التطوير</h6>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">مساحة الارض</th>
                    <th scope="col">سعر المتر</th>
                    <th scope="col">المطلوب بالدولار</th>
                    <th scope="col">نسبة الخصم</th>
                    <th scope="col">قيمة الخصم</th>
                    <th scope="col">المدفوع بالدولار</th>
                    <th scope="col">المتبقي بالدولار</th>


                </tr>
                </thead>
                <tbody>
                @foreach($license->floors as $item)
                @foreach($item->devlopments as $dev)
                <tr>
                    @if($dev -> dev_price_per_meter !=0)
                    <th scope="row">{{$dev -> totle_fees/$dev -> dev_price_per_meter}}</th>
                    @else
                    <td>0</td>
                    @endif
                    <td>{{$dev -> dev_price_per_meter}}</td>
                    <td>{{$dev -> totle_fees}}</td>
                    @if($dev -> totle_fees !=0)
                    <td>{{(int)($dev -> dixcount_val / $dev -> totle_fees * 100)}} %</td>
                    @else
                    <td>0</td>
                    @endif
                    <td>{{$dev -> dixcount_val?? 0}}</td>
                    <td>{{$dev -> pay_fees??0}}</td>
                    <td>{{$dev -> totle_fees - $dev -> pay_fees - $dev -> dixcount_val}}</td>

                </tr>
                @endforeach
                @endforeach
                </tbody>
            </table>
            <div class="card">
                    <div class="card-header d-flex justify-content-between">
                      <div class="card-title mb-0">
                        <h5 class="mb-0">ملاحظات </h5>
                        <small class="text-muted"></small>
                      </div>
                    </div>
                    <div class="card-body">
                      <div id="salesLastMonth"></div>
                      @foreach($license->floors as $item)
                        <strong>{{$item->FloorNum ?? 0}} </strong>: <br>{{ $item->notes }}
                      @endforeach
                    
                      @foreach($license->floors as $item)
                        @foreach($item->devlopments as $dev)
                        <strong>{{ $dev->dev_notes }}
                        @endforeach
                        @endforeach
                    </div>
                  </div>
                  <hr>

            <br>
            <br>
            <br>
            <br>
            <h7 style="text-align:left;">توقيع محاسب التنظيم</h5>


        </div>
    </div>

</div>
<!-- / Content -->
<script>
    window.print()
</script>
</body>
</html>
