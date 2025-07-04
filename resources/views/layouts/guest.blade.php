<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/admin-lte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/admin-lte/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin-lte/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/admin-lte/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/admin-lte/plugins/summernote/summernote-bs4.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="container-fluid min-vh-100">
        <div class="row min-vh-100">
            <!-- Left Side -->
            <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center force-bg text-white p-5">
                <img class="mb-4" src="{{ asset('logo_light.png') }}" style="max-width: 25%; height: auto;" alt="Logo">
                <h1 class="display-4 fw-bold text-center">Welcome to Force</h1>
                <p class="lead text-center mt-3">Empowering Leadership. Inspiring Change.</p>
            </div>
            <!-- Right Side -->
            <div class="col-md-6 d-flex flex-column justify-content-center align-items-center bg-secondary p-5 shadow-sm">
                <div class="w-100" style="max-width: 400px;">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
    @livewireScripts
</body>

</html>
