@extends('dashboard.layouts.app')
@section('title')
    {{ __('Home Page') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="container mt-4">
        @if (app\Helpers\Helpers::perUser('leads'))
            <div class="row">


                @if (app\Helpers\Helpers::perUser('lead_account.index'))
                    <div class="col-lg-3">
                        <x-potentialcustomer::tap-card href="{{ route('lead_account.index') }}" title="{{ __('Lead Account') }}"
                            description="Answer the most frequently asked
        questions about your products &amp; services here">
                            <i class="fa-solid fa-user fa-xl"></i>
                        </x-potentialcustomer::tap-card>
                    </div>
                @endif
                @if (app\Helpers\Helpers::perUser('potential_account.index'))
                    <div class="col-lg-3">
                        <x-potentialcustomer::tap-card href="{{ route('potential_account.index') }}" title="{{ __('Potential Customer') }}"
                            description="Answer the most frequently asked
    questions about your products &amp; services here">
                            <i class="fa-solid fa-person-circle-plus fa-xl"></i>
                        </x-potentialcustomer::tap-card>
                    </div>
                @endif
                {{-- @if (app\Helpers\Helpers::perUser('family_members.index'))
                    <div class="col-lg-3">
                        <x-potentialcustomer::tap-card href="{{ route('family_members.index') }}" title="{{ __('Family Members') }}"
                            description="Answer the most frequently asked
questions about your products &amp; services here">
                            <i class="fa-solid fa-users fa-xl"></i> </x-potentialcustomer::tap-card>
                    </div>
                @endif --}}

                @if (app\Helpers\Helpers::perUser('sales_targets.index'))
                    <div class="col-lg-3">
                        <x-potentialcustomer::tap-card href="{{ route('sales_targets.index') }}" title="{{ __('Sales Targets') }}"
                            description="Answer the most frequently asked
questions about your products &amp; services here">
                            <i class="fa-solid fa-bullseye fa-xl"></i></x-potentialcustomer::tap-card>
                    </div>
                @endif
                @if (app\Helpers\Helpers::perUser('sales_agents.index'))
                    <div class="col-lg-3">
                        <x-potentialcustomer::tap-card href="{{ route('sales_agents.index') }}" title="{{ __('Sales Agents') }}"
                            description="Answer the most frequently asked
questions about your products &amp; services here">
                            <i class="fa-solid fa-arrows-down-to-people fa-xl"></i></x-potentialcustomer::tap-card>
                    </div>
                @endif
            </div>
            <hr>

            <div class="row">
                @if (app\Helpers\Helpers::perUser('lead_source.index'))
                <div class="col-lg-3">
                    <x-potentialcustomer::tap-card href="{{ route('lead_source.index') }}" title="{{ __('Lead Source') }}"
                        description="Answer the most frequently asked
                questions about your products &amp; services here">
                        <i class="fa-brands fa-sourcetree fa-xl"></i>
                    </x-potentialcustomer::tap-card>
                </div>
            @endif
            @if (app\Helpers\Helpers::perUser('lead_status.index'))
                <div class="col-lg-3">
                    <x-potentialcustomer::tap-card href="{{ route('lead_status.index') }}" title="{{ __('Lead Status') }}"
                        description="Answer the most frequently asked
            questions about your products &amp; services here">
                        <i class="fa-solid fa-temperature-half fa-xl"></i>
                    </x-potentialcustomer::tap-card>
                </div>
            @endif
            @if (app\Helpers\Helpers::perUser('lead_value.index'))
                <div class="col-lg-3">
                    <x-potentialcustomer::tap-card href="{{ route('lead_value.index') }}" title="{{ __('Lead Value') }}"
                        description="Answer the most frequently asked
        questions about your products &amp; services here">
                        <i class="fa-solid fa-circle-dollar-to-slot fa-xl"></i>
                    </x-potentialcustomer::tap-card>
                </div>
            @endif
            </div>
            <div class="row">
                @if (app\Helpers\Helpers::perUser('target_types.index'))
                <div class="col-lg-3">
                    <x-potentialcustomer::tap-card href="{{ route('target_types.index') }}" title="{{ __('Target Types') }}"
                        description="Answer the most frequently asked
questions about your products &amp; services here">
                        <i class="fa-solid fa-bullseye fa-xl"></i> </x-potentialcustomer::tap-card>
                </div>
            @endif
            </div>
            @if (app\Helpers\Helpers::perUser('settings'))

                <div class="row">
                    @if (app\Helpers\Helpers::perUser('leadSettings.countrySettings'))
                        @if (app\Helpers\Helpers::perUser('countries.index'))
                            <div class="col-lg-4">
                                <x-potentialcustomer::tap-card href="{{ route('countries.index') }}" title="{{ __('Countries') }}"
                                    description="Answer the most frequently asked
    questions about your products &amp; services here">
                                    <i class="fa-solid fa-earth-americas fa-xl"></i>
                                </x-potentialcustomer::tap-card>
                            </div>
                        @endif
                        @if (app\Helpers\Helpers::perUser('states.index'))
                            <div class="col-lg-4">
                                <x-potentialcustomer::tap-card href="{{ route('states.index') }}" title="{{ __('States') }}"
                                    description="Answer the most frequently asked
    questions about your products &amp; services here">
                                    <i class="fa-solid fa-map-location-dot fa-xl"></i> </x-potentialcustomer::tap-card>
                            </div>
                        @endif
                        @if (app\Helpers\Helpers::perUser('cities.index'))
                            <div class="col-lg-4">
                                <x-potentialcustomer::tap-card href="{{ route('cities.index') }}" title="{{ __('Cities') }}"
                                    description="Answer the most frequently asked
    questions about your products &amp; services here">
                                    <i class="fa-solid fa-tree-city fa-xl"></i> </x-potentialcustomer::tap-card>
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        @endif
    </div>
@endsection
