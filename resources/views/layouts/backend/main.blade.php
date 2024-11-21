<!doctype html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Sinar Utama Furniture</title>
    <link rel="icon" type="image/png" href="{{ asset('backend') }}/assets/images/logo-toko.png" sizes="16x16">
    <!-- remix icon font css  -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/remixicon.css">
    <!-- BootStrap css -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/lib/bootstrap.min.css">

    @yield('css')

    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/style.css">
</head>
<body>

    <main class="dashboard-main">
        @include('layouts.backend.topbar')
            
        @include('layouts.backend.sidebar')

            <div class="dashboard-main-body">
                @yield('content')
            </div>

        <footer class="d-footer">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto">
                    <p class="mb-0">© 2024 Sinar Utama Furniture. All Rights Reserved.</p>
                </div>
                <div class="col-auto">
                    <p class="mb-0">Made by <span class="text-primary-600">Kelompok KP 47</span></p>
                </div>
            </div>
        </footer>
    </main>

    <!-- jQuery library js -->
    <script src="{{ asset('backend') }}/assets/js/lib/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('backend') }}/assets/js/lib/bootstrap.bundle.min.js"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('backend') }}/assets/js/lib/iconify-icon.min.js"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('backend') }}/assets/js/lib/jquery-ui.min.js"></script>

    <!-- main js -->
    <script src="{{ asset('backend') }}/assets/js/app.js"></script>

    @yield('js')
</body>
</html>