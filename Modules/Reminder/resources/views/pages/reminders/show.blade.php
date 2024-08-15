@extends('dashboard.layouts.app')
@section('title')
    {{ __(ucfirst($reminder->reminder_title) . ' Page') }}
@endsection
@section('css')
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-reminder::breadcrumb>
        <x-reminder::breadcrumb-item>
            <a href="{{ route('reminders.home') }}">{{ __('Home') }}</a>
        </x-reminder::breadcrumb-item>

        <x-reminder::breadcrumb-item>
            <a href="{{ route('reminders.index') }}">{{ __('Reminders') }}</a>
        </x-reminder::breadcrumb-item>

        <x-reminder::breadcrumb-item>
            {{ __(ucfirst($reminder->reminder_title)) }}
        </x-reminder::breadcrumb-item>
    </x-reminder::breadcrumb>
    {{-- End breadcrumb --}}


    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="catd-title">
                    <span
                        class="fs-2">{{ __($reminder->reminder_title) }}</span>
                        @if ($reminder->reminder_type == 'note')
                        <span class="badge badge-phoenix badge-phoenix-primary mx-2">
                            <i class="fa-solid fa-note-sticky fa-sm mx-1"></i>{{ $reminder->reminder_type }}
                        </span>
                    @elseif ($reminder->reminder_type == 'call')
                        <span class="badge badge-phoenix badge-phoenix-warning mx-2">
                            <i class="fa-solid fa-phone fa-sm mx-1"></i>{{ $reminder->reminder_type }}
                        </span>
                    @elseif ($reminder->reminder_type == 'meeting')
                        <span class="badge badge-phoenix badge-phoenix-danger mx-2">
                            <i class="fa-solid fa-handshake fa-sm mx-1"></i>{{ $reminder->reminder_type }}
                        </span>
                    @endif
                </div>
                @if ($reminder->reminder_relation != null)
                <div>
                    <small>{{ __('Relationship : ') }}</small>
                    <span class="badge badge-phoenix badge-phoenix-success mx-2">
                        {{ $reminder->reminder_relation }}
                    </span>
                    <small>{{ __('Related To : ') }}</small>
                    <span class="badge badge-phoenix badge-phoenix-success mx-2">
                        {{ $reminder->leadAccount->account_name }}
                    </span>
                    <span class="badge badge-phoenix badge-phoenix-success mx-2">
                        {{ $reminder->leadAccount->condition == 'lead'  ? $reminder->leadAccount->condition .' account' : $reminder->leadAccount->condition .' customer'  }}
                    </span>
                </div>
                @endif
                <div>
                    <span
                        class="me-3">{{ __($reminder->reminder_date) }}</span>
                </div>
                <div class="my-6">
                    <p>{{ __($reminder->description) }}</p>
                </div>
                @if ($reminder->reminder_type == 'call')
                <div class="mb-3">
                    <small>{{ __('contacts : ') }}</small>
                    @foreach ($reminder->contacts as $contact)
                    <p>
                        {{ $contact->name }}
                        @foreach ($contact->phones as $phone)
                        <span class="mx-2">
                            {{ $phone->phone }}
                        </span>
                        @endforeach
                    </p>
                    @endforeach
                </div>
                @endif
                <div class="mb-0">
                    <small class="me-3 float-end">{{ __('created by : '. $reminder->user->name) }}</small>
                    <small class="me-3 float-end">{{ __('created at : '. $reminder->created_at) }}</small>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
