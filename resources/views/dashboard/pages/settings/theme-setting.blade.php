@extends('dashboard.layouts.app')
@section('title')
    {{ __('Theme Setting Page') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="content ">
        <!-- add your content here -->
        <div class="container px-2 px-md-5">
            <div class="align-items-start border-bottom flex-column">
                <div class="pt-1 w-100 mb-6 d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="mb-2 me-2 lh-sm"><span class="fas fa-palette me-2 fs-0"></span>{{ __('Theme Customizer') }}
                        </h5>
                        <p class="mb-0 fs--1">{{ __('Explore different styles according to your preferences') }}</p>
                    </div>
                </div>
            </div>
            <div class="offcanvas-body scrollbar px-card pt-2 w-100 w-lg-75 " id="themeController">
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">{{ __('Color Scheme') }}</h5>
                    <div class="row gx-2">
                        <div class="col-6"><input class="btn-check" id="themeSwitcherLight" name="theme-color"
                                type="radio" value="light" data-theme-control="phoenixTheme" /><label
                                class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherLight"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/default-light.png"
                                        alt="" /></span><span class="label-text">{{ __('Light') }}</span></label>
                        </div>
                        <div class="col-6"><input class="btn-check" id="themeSwitcherDark" name="theme-color"
                                type="radio" value="dark" data-theme-control="phoenixTheme" /><label
                                class="btn d-inline-block btn-navbar-style fs--1" for="themeSwitcherDark"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/default-dark.png"
                                        alt="" /></span><span class="label-text"> {{ __('Dark') }}</span></label>
                        </div>
                    </div>
                </div>
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">{{ __('Navigation Type') }}</h5>
                    <div class="row gx-2">
                        <div class="col-6"><input class="btn-check" id="navbarPositionVertical" name="navigation-type"
                                type="radio" value="vertical" data-theme-control="phoenixNavbarPosition" /><label
                                class="btn d-inline-block btn-navbar-style fs--1" for="navbarPositionVertical"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none"
                                        src="{{ asset('dashboard') }}/assets/img/generic/default-light.png"
                                        alt="" /><img class="img-fluid img-prototype d-light-none"
                                        src="{{ asset('dashboard') }}/assets/img/generic/default-dark.png"
                                        alt="" /></span><span
                                    class="label-text">{{ __('Vertical') }}</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbarPositionHorizontal" name="navigation-type"
                                type="radio" value="horizontal" data-theme-control="phoenixNavbarPosition" /><label
                                class="btn d-inline-block btn-navbar-style fs--1" for="navbarPositionHorizontal"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-default.png"
                                        alt="" /><img class="img-fluid img-prototype d-light-none"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-default-dark.png"
                                        alt="" /></span><span class="label-text">
                                    {{ __('Horizontal') }}</span></label></div>
                    </div>
                </div>
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">{{ __('Vertical Navbar Appearance') }}</h5>
                    <div class="row gx-2">
                        <div class="col-6"><input class="btn-check" id="navbar-style-default" type="radio"
                                name="config.name" value="default" data-theme-control="phoenixNavbarVerticalStyle" /><label
                                class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-default"> <img
                                    class="img-fluid img-prototype d-dark-none"
                                    src="{{ asset('dashboard') }}/assets/img/generic/default-light.png" alt="" />
                                <br> <img class="img-fluid img-prototype d-light-none"
                                    src="{{ asset('dashboard') }}/assets/img/generic/default-dark.png" alt="" />
                                <br> <span class="label-text d-dark-none"> {{ __('Default') }}</span><span
                                    class="label-text d-light-none">{{ __('Default') }}</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbar-style-dark" type="radio"
                                name="config.name" value="darker"
                                data-theme-control="phoenixNavbarVerticalStyle" /><label
                                class="btn d-block w-100 btn-navbar-style fs--1" for="navbar-style-dark"> <img
                                    class="img-fluid img-prototype d-dark-none"
                                    src="{{ asset('dashboard') }}/assets/img/generic/vertical-darker.png"
                                    alt="" /> <br> <img class="img-fluid img-prototype d-light-none"
                                    src="{{ asset('dashboard') }}/assets/img/generic/vertical-lighter.png"
                                    alt="" /> <br> <span class="label-text d-dark-none">
                                    {{ __('Darker') }}</span><span
                                    class="label-text d-light-none">{{ __('Lighter') }}</span></label></div>
                    </div>
                </div>
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">{{ __('Horizontal Navbar Shape') }}</h5>
                    <div class="row gx-2">
                        <div class="col-6"><input class="btn-check" id="navbarShapeDefault" name="navbar-shape"
                                type="radio" value="default" data-theme-control="phoenixNavbarTopShape" /><label
                                class="btn d-inline-block btn-navbar-style fs--1" for="navbarShapeDefault"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-default.png"
                                        alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-default-dark.png"
                                        alt="" /></span><span
                                    class="label-text">{{ __('Default') }}</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbarShapeSlim" name="navbar-shape"
                                type="radio" value="slim" data-theme-control="phoenixNavbarTopShape" /><label
                                class="btn d-inline-block btn-navbar-style fs--1" for="navbarShapeSlim"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-slim.png"
                                        alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-slim-dark.png"
                                        alt="" /></span><span class="label-text">
                                    {{ __('Slim') }}</span></label></div>
                    </div>
                </div>
                <div class="setting-panel-item">
                    <h5 class="setting-panel-item-title">{{ __('Horizontal Navbar Appearance') }}</h5>
                    <div class="row gx-2">
                        <div class="col-6"><input class="btn-check" id="navbarTopDefault" name="navbar-top-style"
                                type="radio" value="default" data-theme-control="phoenixNavbarTopStyle" /><label
                                class="btn d-inline-block btn-navbar-style fs--1" for="navbarTopDefault"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-default.png"
                                        alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-style-darker.png"
                                        alt="" /></span><span
                                    class="label-text">{{ __('Default') }}</span></label></div>
                        <div class="col-6"><input class="btn-check" id="navbarTopDarker" name="navbar-top-style"
                                type="radio" value="darker" data-theme-control="phoenixNavbarTopStyle" /><label
                                class="btn d-inline-block btn-navbar-style fs--1" for="navbarTopDarker"> <span
                                    class="mb-2 rounded d-block"><img class="img-fluid img-prototype d-dark-none mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/navbar-top-style-light.png"
                                        alt="" /><img class="img-fluid img-prototype d-light-none mb-0"
                                        src="{{ asset('dashboard') }}/assets/img/generic/top-style-lighter.png"
                                        alt="" /></span><span
                                    class="label-text d-dark-none">{{ __('Darker') }}</span><span
                                    class="label-text d-light-none">{{ __('Lighter') }}</span></label></div>
                    </div>
                </div>
                <button class="btn btn-primary  my-5  w-100" data-theme-control="reset"><span
                        class="fas fa-arrows-rotate me-2 fs--2"></span>{{ __('Reset to default') }}</button>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
