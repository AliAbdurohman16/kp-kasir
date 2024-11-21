<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title') | Sinar Utama Furniture</title>
        <link rel="icon" type="image/png" href="{{ asset('backend') }}/assets/images/favicon.png" sizes="16x16">
        <!-- remix icon font css  -->
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/remixicon.css">
        <!-- BootStrap css -->
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/lib/bootstrap.min.css">

        <!-- main css -->
        <link rel="stylesheet" href="{{ asset('backend') }}/assets/css/style.css">
</head>
<body>

    @yield('content')

    <!-- jQuery library js -->
    <script src="{{ asset('backend') }}/assets/js/lib/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('backend') }}/assets/js/lib/bootstrap.bundle.min.js"></script>
    <!-- Iconify Font js -->
    <script src="{{ asset('backend') }}/assets/js/lib/iconify-icon.min.js"></script>
    <!-- jQuery UI js -->
    <script src="{{ asset('backend') }}/assets/js/lib/jquery-ui.min.js"></script>

    @yield('js')
</body>
</html>