@extends('errors.layouts')
@section('title')
{{ __('403 Page') }}
@endsection
@section('content')
<main class="main" id="top">
    <div class="px-3">
        <div class="row min-vh-100 flex-center p-5">
            <div class="col-12 col-xl-10 col-xxl-8">
                <div class="row justify-content-center align-items-center g-5">
                    <div class="col-12 col-lg-6 text-center order-lg-1"><img class="img-fluid w-lg-100 d-dark-none"
                            src="{{asset('dashboard')}}/assets/img/spot-illustrations/403-illustration.png" alt=""
                            width="400"><img class="img-fluid w-md-50 w-lg-100 d-light-none"
                            src="{{asset('dashboard')}}/assets/img/spot-illustrations/dark_403-illustration.png" alt=""
                            width="540"></div>
                    <div class="col-12 col-lg-6 text-center text-lg-start"><img
                            class="img-fluid mb-6 w-50 w-lg-75 d-dark-none"
                            src="{{asset('dashboard')}}/assets/img/spot-illustrations/403.png" alt=""><img
                            class="img-fluid mb-6 w-50 w-lg-75 d-light-none"
                            src="{{asset('dashboard')}}/assets/img/spot-illustrations/dark_403.png" alt="">
                        <h2 class="text-800 fw-bolder mb-3">Access Forbidden!</h2>
                        <a class="btn btn-lg btn-primary"
                            href="{{ route('home.index') }}">Go Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
