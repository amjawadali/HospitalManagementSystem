<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Otika - Admin Dashboard Template</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/css/app.min.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/components.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/bundles/prism/prism.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/img/favicon.ico') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
</head>

<body>
    <div class="loader"></div>
    @auth
        <div id="app">
            <div class="main-wrapper main-wrapper-1">
                <div class="navbar-bg"></div>
                <nav class="navbar navbar-expand-lg main-navbar sticky">
                    @include('layout.navbar')
                </nav>

                <div class="main-sidebar sidebar-style-2">
                    @include('layout.sidebar')
                </div>
                <div class="main-content">
                    @yield('content')
                    @yield('scripts')

                </div>
            </div>
        @endauth
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('admin/js/app.min.js') }}"></script>
    <!-- JS Libraries -->
    <script src="{{ asset('admin/bundles/apexcharts/apexcharts.min.js') }}"></script>
    <!-- Template JS File -->
    <script src="{{ asset('admin/js/scripts.js') }}"></script>
    <!-- Custom JS File -->
    <script src="{{ asset('admin/js/custom.js') }}"></script>

    <script src="{{ asset('admin/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('admin/js/page/datatables.js') }}"></script>
    <script src="{{ asset('admin/bundles/prism/prism.js') }}"></script>


</body>

</html>
