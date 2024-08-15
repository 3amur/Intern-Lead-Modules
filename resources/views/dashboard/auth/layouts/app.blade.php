<!DOCTYPE html>
<html lang="en-US" dir="ltr">


<!-- Mirrored from prium.github.io/phoenix/v1.6.0/pages/dashboardentication/simple/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Dec 2022 09:37:38 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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
  <link rel="preconnect" href="https://fonts.googleapis.com/">
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
  <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
  <link href="{{ asset('dashboard') }}/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
  <link href="{{ asset('dashboard') }}/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
</head>

  <body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    @yield('content')
    <!-- ===============================================-->
    <!--    End of Main Content-->

    <!-- ===============================================-->
      <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="{{ asset('dashboard') }}/vendors/jquery-3.7.1.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/jquery.validate.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/popper/popper.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/fontawesome/all.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/lodash/lodash.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/feather-icons/feather.min.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/phoenix.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/main.js"></script>
@yield('js')
  </body>


<!-- Mirrored from prium.github.io/phoenix/v1.6.0/pages/dashboardentication/simple/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Dec 2022 09:37:38 GMT -->
</html>
