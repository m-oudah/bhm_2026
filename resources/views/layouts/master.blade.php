<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}"
    data-theme="theme-default" data-template="horizontal-menu-template-no-customizer-starter">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title') | {{ __('Municipality of Beit Hanoun') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../dash/assets/img/favicon/favicon.ico" />

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

    <link rel="stylesheet" href="{{ asset('dash/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />

    {{-- <link rel="stylesheet" href="{{asset('dash/assets/vendor/css/rtl/core-dark.css')}}" class="template-customizer-core-css" />
   <link rel="stylesheet" href="{{asset('dash/assets/vendor/css/rtl/theme-default-dark.css')}}" class="template-customizer-theme-css" /> --}}

    <!-- Helpers -->
    <script src="{{ asset('dash/assets/vendor/js/helpers.js') }}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('dash/assets/js/config.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css"
        integrity="sha512-6S2HWzVFxruDlZxI3sXOZZ4/eJ8AcxkQH1+JjSe/ONCEqR9L4Ysq5JdT5ipqtzU7WHalNwzwBv+iE51gNHJNqQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css"
        integrity="sha512-y4S4cBeErz9ykN3iwUC4kmP/Ca+zd8n8FDzlVbq5Nr73gn1VBXZhpriQ7avR+8fQLpyq4izWm0b8s6q4Vedb9w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: 'Tajawal' !important;
        }

        .swal2-container.swal2-top-end.swal2-backdrop-show {
            z-index: 9999;
        }

        th.sorting.sorting_disabled,
        th.sorting_disabled.sorting_desc,
        th.sorting_disabled {
            text-align: start !important;
        }

        .select2-container .select2-selection--single {
            height: 36px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 36px;
        }

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
    </style>
    @yield('stylesheet')
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
        <div class="layout-container">
            <!-- Navbar -->

            @include('layouts._navbar')
            <!-- / Navbar -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Menu -->
                    @include('layouts._menu')
                    <!-- / Menu -->

                    <!-- Content -->

                    @yield('content')

                    <!--/ Content -->

                    <!-- Footer -->
                    @include('layouts._footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!--/ Content wrapper -->
            </div>

            <!--/ Layout container -->
        </div>
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>

    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    <div class="drag-target"></div>

    <!--/ Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js dash/assets/vendor/js/core.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"
        integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script> {{-- <script src="{{ asset('dash/assets/vendor/libs/jquery/jquery.js') }}"></script> --}}
    <script src="{{ asset('dash/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('dash/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('dash/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('dash/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('dash/assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('dash/assets/vendor/js/menu.js') }}"></script>
    <!-- endbuild -->
    <!-- Main JS -->
    <script src="{{ asset('dash/assets/js/main.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>


    <!-- Page JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.3.2/axios.min.js"
        integrity="sha512-NCiXRSV460cHD9ClGDrTbTaw0muWUBf/zB/yLzJavRsPNUl9ODkUVmUHsZtKu17XknhsGlmyVoJxLg/ZQQEeGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"
        integrity="sha512-lbwH47l/tPXJYG9AcFNoJaTMhGvYWhVM9YI43CT+uteTRRaiLCui8snIgyAN8XWgNjNhCqlAUdzZptso6OCoFQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.all.min.js"
        integrity="sha512-KMOKthdp8z/ltLlRyTUh++7dcXfkEkP2Pha9VmYZtX5x6yDaM6zw88cz6wI/yTzRqOAYlEcw4V9Ut1wwKj4j0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(function() {
            $("#add_new").click(function() {
                $("#createFormData").fadeIn("fast");
            });

            $("#close").click(function() {
                $("#createFormData").fadeOut("fast");
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
