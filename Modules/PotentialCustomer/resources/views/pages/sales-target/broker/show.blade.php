@extends('dashboard.layouts.app')
@section('title')
    {{ __('Broker Details Page') }}
@endsection
@section('css')
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('lead_home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('brokers.index') }}">{{ __('Brokers') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ __($broker->name . ' Details Page') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}


    <div class="container">
        @include('dashboard.layouts.alerts')

        <div class="card my-3">
            <div class="card-header">
                <h5> {{ __($broker->name . ' Details Page') }}</h5>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
