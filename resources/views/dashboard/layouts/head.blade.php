<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>@yield('title')</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('dashboard') }}/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('dashboard') }}/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('dashboard') }}/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboard') }}/assets/img/favicons/favicon.ico">
    <meta name="msapplication-TileImage" content="{{ asset('dashboard') }}/assets/img/favicons/mstile-150x150.png">
    <script src="{{ asset('dashboard') }}/assets/js/config.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->


    <link href="{{ asset('dashboard') }}/assets/css/datatable-bootstrap5.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/responsive-datatable-bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('dashboard') }}/assets/css/buttons.bootstrap5.css">
    <link href="{{ asset('dashboard') }}/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{ asset('dashboard') }}/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">


    <link href="{{ asset('dashboard/select2-4.1.0-rc.0/dist/css/select2.min.css') }}" rel="stylesheet" />

    @yield('css')
  </head>
