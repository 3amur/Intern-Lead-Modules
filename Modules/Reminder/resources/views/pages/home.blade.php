@extends('dashboard.layouts.app')
@section('title')
    {{ __('Home Page') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="container mt-4">
        @if (app\Helpers\Helpers::perUser('reminders'))
            <div class="row">


                @if (app\Helpers\Helpers::perUser('reminders.index'))
                    <div class="col-lg-4">
                        <x-potentialcustomer::tap-card href="{{ route('reminders.index') }}" title="{{ __('Reminders') }}"
                            description="Answer the most frequently asked
        questions about your products &amp; services here">
                            <i class="fa-solid fa-user fa-xl"></i>
                        </x-potentialcustomer::tap-card>
                    </div>
                @endif
                @if (app\Helpers\Helpers::perUser('contacts.index'))
                    <div class="col-lg-4">
                        <x-potentialcustomer::tap-card href="{{ route('contacts.index') }}" title="{{ __('Contacts') }}"
                            description="Answer the most frequently asked
    questions about your products &amp; services here">
                            <i class="fa-solid fa-person-circle-plus fa-xl"></i>
                        </x-potentialcustomer::tap-card>
                    </div>
                @endif


                @if (app\Helpers\Helpers::perUser('reminders.calendar'))
                    <div class="col-lg-4">
                        <x-potentialcustomer::tap-card href="{{ route('reminders.calendar') }}" title="{{ __('Calendar') }}"
                            description="Answer the most frequently asked
questions about your products &amp; services here">
                            <i class="fa-solid fa-bullseye fa-xl"></i></x-potentialcustomer::tap-card>
                    </div>
                @endif

            </div>
        @endif
    </div>
@endsection
