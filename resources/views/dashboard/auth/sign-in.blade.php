@extends('dashboard.auth.layouts.app')
@section('title')
    {{ __('Sign in Page') }}
@endsection
@section('content')
    <main class="main" id="top">
        <div class="container-fluid px-0" data-layout="container">
            <div class="container">
                <div class="row flex-center min-vh-100 py-5">
                    <div class="col-sm-10 col-md-8 col-lg-5 col-xl-5 col-xxl-3"><a
                            class="d-flex flex-center text-decoration-none mb-4" href="index.html">
                            <div class="d-flex align-items-center fw-bolder fs-5 d-inline-block"><img
                                    src="{{ asset('auth') }}/assets/img/icons/logo.png" alt="phoenix" width="58" />
                            </div>
                        </a>
                        <div class="text-center mb-7">
                            <h3 class="text-1000">{{ __('Sign in Page') }}</h3>
                            <p class="text-700">{{ __('Sign in Page') }}</p>
                        </div>
                        <form method="POST" action="{{ route('login') }}" id="signInForm">
                            @csrf
                            <div class="mb-3 text-start"><label class="form-label"
                                    for="email">{{ __('Sign in Page') }}</label>
                                <div class="form-icon-container">
                                    <input class="form-control form-icon-input" id="email" name="email"
                                        value="{{ old('email') }}" required autofocus type="email"
                                        placeholder="name@example.com" /><span
                                        class="fas fa-user text-900 fs--1 form-icon"></span>
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                                </div>
                            </div>
                            <div class="mb-3 text-start"><label class="form-label"
                                    for="password">{{ __('Sign in Page') }}</label>
                                <div class="form-icon-container">
                                    <input class="form-control form-icon-input" type="password" name="password"
                                        placeholder="Password" required />
                                    <span class="fas fa-key text-900 fs--1 form-icon"></span>
                                    @error('password')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row flex-between-center mb-7">
                                <div class="col-auto"><a class="fs--1 fw-semi-bold"
                                        href="{{ route('password.request') }}">{{ __('Forgot Password?') }}</a></div>
                            </div><button type="submit" class="btn btn-primary w-100 mb-3">{{ __('Sign In') }}</button>
                        </form>
                        {{-- <div class="text-center"><a class="fs--1 fw-bold" href="{{ route('register') }}">Create an account</a></div> --}}
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#signInForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                },

                errorClass: "error text-danger fs--1",
                errorElement: "span",

            })

        });
    </script>
@endsection
@section('js')
@endsection
