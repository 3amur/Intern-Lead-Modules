<!DOCTYPE html>
<html lang="en-US" dir="ltr">


<!-- Mirrored from prium.github.io/phoenix/v1.6.0/pages/errors/404.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Dec 2022 09:37:35 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

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
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('dashboard')}}/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('dashboard')}}/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('dashboard')}}/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('dashboard')}}/assets/img/favicons/favicon.ico">
    <link rel="manifest" href="{{asset('dashboard')}}/assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="{{asset('dashboard')}}/vendors/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="{{asset('dashboard')}}/vendors/simplebar/simplebar.min.js"></script>
    <script src="{{asset('dashboard')}}/assets/js/config.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="{{asset('dashboard')}}/vendors/simplebar/simplebar.min.css" rel="stylesheet">
    <link rel="stylesheet" href="unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="{{asset('dashboard')}}/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{asset('dashboard')}}/assets/css/user.min.css" type="text/css" rel="stylesheet" id="user-style-default">
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    @yield('content')

    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->

    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script>
        var navbarTopShape = localStorage.getItem('phoenixNavbarTopShape');
        var navbarPosition = localStorage.getItem('phoenixNavbarPosition');
        var body = document.querySelector('body');
        var navbarDefault = document.querySelector('#navbarDefault');
        var navbarTopNew = document.querySelector('#navbarTopNew');
        var navbarSlim = document.querySelector('#navbarSlim');
        var navbarTopSlimNew = document.querySelector('#navbarTopSlimNew');

        var documentElement = document.documentElement;
        var navbarVertical = document.querySelector('.navbar-vertical');

        if (navbarTopShape === 'slim' && navbarPosition === 'vertical') {
            navbarDefault.remove();
            navbarTopNew.remove();
            navbarTopSlimNew.remove();
            navbarSlim.style.display = 'block';
            navbarVertical.style.display = 'inline-block';
            body.classList.add('nav-slim');
        } else if (navbarTopShape === 'slim' && navbarPosition === 'horizontal') {
            navbarDefault.remove();
            navbarVertical.remove();
            navbarTopNew.remove();
            navbarSlim.remove();
            navbarTopSlimNew.removeAttribute('style');
            body.classList.add('nav-slim');
        } else if (navbarTopShape === 'default' && navbarPosition === 'horizontal') {
            navbarDefault.remove();
            navbarSlim.remove();
            navbarVertical.remove();
            navbarTopSlimNew.remove();
            navbarTopNew.removeAttribute('style');
            documentElement.classList.add('navbar-horizontal')

        } else {
            body.classList.remove('nav-slim');
            navbarSlim.remove();
            navbarTopNew.remove();
            navbarTopSlimNew.remove();
            navbarDefault.removeAttribute('style');
            navbarVertical.removeAttribute('style');
        }

        var navbarTopStyle = localStorage.getItem('phoenixNavbarTopStyle');
        var navbarTop = document.querySelector('.navbar-top');
        if (navbarTopStyle === 'darker') {
            navbarTop.classList.add('navbar-darker');
        }

        var navbarVerticalStyle = localStorage.getItem('phoenixNavbarVerticalStyle');
        var navbarVertical = document.querySelector('.navbar-vertical');
        if (navbarVerticalStyle === 'darker') {
            navbarVertical.classList.add('navbar-darker');
        }
    </script>
    <script src="{{asset('dashboard')}}/vendors/popper/popper.min.js"></script>
    <script src="{{asset('dashboard')}}/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{asset('dashboard')}}/vendors/anchorjs/anchor.min.js"></script>
    <script src="{{asset('dashboard')}}/vendors/is/is.min.js"></script>
    <script src="{{asset('dashboard')}}/vendors/fontawesome/all.min.js"></script>
    <script src="{{asset('dashboard')}}/vendors/lodash/lodash.min.js"></script>
    <script src="{{asset('dashboard')}}/assets/polyfill.io/v3/polyfill.min58be.js?features=window.scroll"></script>
    <script src="{{asset('dashboard')}}/vendors/list.js/list.min.js"></script>
    <script src="{{asset('dashboard')}}/vendors/feather-icons/feather.min.js"></script>
    <script src="{{asset('dashboard')}}/vendors/dayjs/dayjs.min.js"></script>
    <script src="{{asset('dashboard')}}/assets/js/phoenix.js"></script>
</body>


<!-- Mirrored from prium.github.io/phoenix/v1.6.0/pages/errors/404.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Dec 2022 09:37:36 GMT -->

</html>
