<!DOCTYPE html>
<html lang="en-US" dir="ltr">


<!-- Mirrored from prium.github.io/phoenix/v1.6.0/apps/email/inbox.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Dec 2022 09:37:20 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
@include('dashboard.layouts.head')

<body>
    <main class="main" id="top">
        <div class="container-fluid px-0" data-layout="container">
            @include('dashboard.layouts.sidebar')
            @include('dashboard.layouts.navbar')
            <div class="content mt-3 pt-5">

                        @yield('content')
                        @include('dashboard.layouts.footer')


            </div>
        </div>
    </main>
    @include('dashboard.layouts.scripts')
</body>

</html>
