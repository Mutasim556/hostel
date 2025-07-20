<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="tivo admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Tivo admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('public/admin/assets/images/favicon/favicon.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('public/admin/assets/images/favicon/favicon.png" type="image/x-icon')}}">
    <title>{{ env('APP_BACKEND_NAME') }} -@stack('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/vendors/font-awesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/vendors/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/vendors/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/vendors/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/vendors/feather-icon.css')}}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/vendors/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{ asset('public/admin/assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/assets/css/responsive.css')}}">
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/custom.css') }}">
</head>

<body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"> </div>
        <div class="dot"></div>
    </div>
    <!-- Loader ends-->
    <!-- login page start-->
    <div class="container-fluid p-0">
        @yield('content')
        <!-- latest jquery-->
        <script src="{{ asset('public/admin/assets/js/jquery-3.6.0.min.js')}}"></script>
        <!-- Bootstrap js-->
        <script src="{{ asset('public/admin/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
        <!-- feather icon js-->
        <script src="{{ asset('public/admin/assets/js/icons/feather-icon/feather.min.js')}}"></script>
        <script src="{{ asset('public/admin/assets/js/icons/feather-icon/feather-icon.js')}}"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="{{ asset('public/admin/assets/js/config.js')}}"></script>
        <!-- Template js-->
        <script src="{{ asset('public/admin/assets/js/script.js')}}"></script>
        @stack('js')
        <!-- login js-->
    </div>
</body>

</html>
