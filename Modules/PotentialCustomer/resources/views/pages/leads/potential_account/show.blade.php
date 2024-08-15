@extends('dashboard.layouts.app')
@section('title')
    {{ __('Potential Customer Page') }}
@endsection
@section('css')
    <style>
        .error {
            color: red;
            font-size: 0.8em;

        }

        label.error {
            color: red;
            font-size: 0.6em;
            margin-top: 5px;
        }
    </style>
@endsection
@section('content')
    <div class="pb-9">
        <div class="row">
            <div class="col-12">
                <div class="row align-items-center justify-content-between g-3 mb-3">
                    <div class="col-12 col-md-auto">
                        {{-- Begin breadcrumb --}}
                        <x-potentialcustomer::breadcrumb>
                            <x-potentialcustomer::breadcrumb-item>
                                <a href="{{ route('lead_home.index') }}">{{ __('Home') }}</a>
                            </x-potentialcustomer::breadcrumb-item>

                            <x-potentialcustomer::breadcrumb-item>
                                <a href="{{ route('potential_account.index') }}">{{ __('Potential Customer') }}</a>
                            </x-potentialcustomer::breadcrumb-item>

                            <x-potentialcustomer::breadcrumb-item>
                                {{ isset($potentialAccount) ? __('Show Details of :type', ['type' => $potentialAccount->account_name]) : __('Show New Potential Customer') }}
                            </x-potentialcustomer::breadcrumb-item>
                        </x-potentialcustomer::breadcrumb>
                        {{-- End breadcrumb --}}
                        @include('dashboard.layouts.alerts')
                        <h4 class="mb-0">{{ __('Potential Customer details') }}</h4>

                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="d-flex">
                            <div class="flex-1 d-md-none"><button class="btn px-3 btn-phoenix-secondary text-700 me-2"
                                    data-phoenix-toggle="offcanvas" data-phoenix-target="#productFilterColumn">
                                    <span class="fa-solid fa-bars"></span>
                                </button>
                            </div>
                            {{-- <button class="btn btn-primary me-2"><span
                                    class="fa-solid fa-envelope me-2"></span>{{ __('Send an email') }}</button>

                            <button class="btn btn-phoenix-secondary px-3 px-sm-5 me-2">
                                <span class="fa-solid fa-thumbtack me-sm-2"></span>{{ __('Shortlist') }}
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0 g-md-4 g-xl-6">
            <div class="col-md-5 col-lg-5 col-xl-4">
                <div class="sticky-leads-sidebar">
                    <div class="d-flex justify-content-between align-items-center mb-2 d-md-none">
                        <h5 class="mb-0">{{ __('Potential Customer Details') }}</h5><button class="btn p-0"
                            data-phoenix-dismiss="offcanvas"><span class="uil uil-times fs-1"></span></button>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center g-3 text-center text-xxl-start">
                                <div class="col-12 col-xxl-auto">
                                    <div class="avatar avatar-5xl"><img class="rounded-circle"
                                            src="@if (isset($potentialAccount->image)) {{ asset('storage') . '/' . $potentialAccount->image }}@else{{ asset('dashboard') }}\assets\img\team\avatar.png @endif"
                                            alt=""></div>
                                </div>
                                <div class="col-12 col-sm-auto flex-1">
                                    <h5 class="fw-bolder mb-2">{{ $potentialAccount->account_name }}</h5>
                                    <p class="mb-0">{{ $potentialAccount->lead_account_title }}</p><a class="fw-bold"
                                        href="#!">Company Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5 ">
                                <h4>{{ __('About ' . $potentialAccount->account_name) }}</h4>
                                <a class="btn btn-link"
                                    href="{{ route('potential_account.edit', $potentialAccount->id) }}">{{ __('Edit') }}</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-envelope-alt">
                                    </span>
                                    <h5 class="text-1000 mb-0">{{ __('Email') }}</h5>
                                </div><a href="mailto:shatinon@jeemail.com:">{{ $potentialAccount->email }}</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-envelope-alt">
                                    </span>
                                    <h5 class="text-1000 mb-0">{{ __('Contact name') }}</h5>
                                </div><a
                                    href="mailto:shatinon@jeemail.com:">{{ $potentialAccount->account_contact_name }}</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-phone"> </span>
                                    <h5 class="text-1000 mb-0">{{ 'Personal Number' }}</h5>
                                </div><a href="tel:+1234567890">{{ $potentialAccount->personal_number }}</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-phone"> </span>
                                    <h5 class="text-1000 mb-0">{{ __('mobile') }}</h5>
                                </div><a href="tel:+1234567890">{{ $potentialAccount->mobile }}</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-phone"> </span>
                                    <h5 class="text-1000 mb-0">{{ __('Phone') }}</h5>
                                </div><a href="tel:+1234567890">{{ $potentialAccount->phone }}</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-globe"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Website') }}</h5>
                                </div><a href="#!">{{ $potentialAccount->website }}</a>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-clock"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Notes') }}</h5>
                                </div>
                                <p class="mb-0 text-800">
                                    {{ $potentialAccount->notes ? $potentialAccount->notes : 'Empty..' }}</p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-clock"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Created By') }}</h5>
                                </div>
                                <p class="mb-0 text-800"><span
                                        class="badge badge-phoenix badge-phoenix-success">{{ $potentialAccount->user->name }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span
                                        class="me-2 uil uil-file-check-alt"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Lead source') }}</h5>
                                </div>
                                <p class="mb-0 text-800">
                                    <span
                                        class="badge badge-phoenix badge-phoenix-primary">{{ $potentialAccount->leadSource ? $potentialAccount->leadSource->title : 'N/A' }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span
                                        class="me-2 uil uil-file-check-alt"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Lead value') }}</h5>
                                </div>
                                <p class="mb-0 text-800">
                                    <span
                                        class="badge badge-phoenix badge-phoenix-primary">{{ $potentialAccount->leadValue ? $potentialAccount->leadValue->title : 'N/A' }}</span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-check-circle"></span>
                                    <h5 class="text-1000 mb-0">{{ 'Lead status' }}</h5>
                                </div><span
                                    class="badge badge-phoenix badge-phoenix-primary">{{ $potentialAccount->leadStatus ? $potentialAccount->leadStatus->title : 'N\A' }}</span>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span
                                        class="me-2 uil uil-check-circle"></span>
                                    <h5 class="text-1000 mb-0">{{ 'Lead type' }}</h5>
                                </div><span
                                    class="badge badge-phoenix badge-phoenix-primary">{{ $potentialAccount->leadType ? $potentialAccount->leadType->title : 'N\A' }}</span>
                            </div>

                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5">
                                <h3>{{ __('Address') }}</h3>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-estate"></span>
                                    <h5 class="mb-0">{{ __('Address') }}</h5>
                                </div>
                                <p class="mb-0 text-800">
                                    {{ $potentialAccount->address ? $potentialAccount->address : 'Empty..' }}</p>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-1"><span
                                                class="me-2 uil uil-map-pin-alt"></span>
                                            <h5 class="mb-0 text-1000">{{ __('Zip code') }}</h5>
                                        </div>
                                        <p class="mb-0 text-800">
                                            {{ $potentialAccount->zip_code ? $potentialAccount->zip_code : 'Empty..' }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-map"></span>
                                            <h5 class="mb-0 text-1000">{{ __('City') }}</h5>
                                        </div>
                                        <p class="mb-0 text-800">{{ $potentialAccount->city->name }}</p>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-map"></span>
                                            <h5 class="mb-0 text-1000">{{ __('State') }}</h5>
                                        </div>
                                        <p class="mb-0 text-800">{{ $potentialAccount->city->state->name }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div>
                                        <div class="d-flex align-items-center mb-1"><span
                                                class="me-2 uil uil-windsock"></span>
                                            <h5 class="mb-0 text-1000">{{ __('Country') }}</h5>
                                        </div>
                                        <p class="mb-0 text-800">{{ $potentialAccount->city->state->country->name }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="phoenix-offcanvas-backdrop d-lg-none top-0" data-phoenix-backdrop="data-phoenix-backdrop">
                </div>
            </div>
            <div class="col-md-7 col-lg-7 col-xl-8">
                <div class="lead-details-container my-3">
                    <div class="card">
                        <div class="card-header">
                            <strong>{{ __('Sales Details') }}</strong>
                            <div class="float-end">
                                @if (app\Helpers\Helpers::perUser('potential_account_details.edit'))
                                    <x-potentialcustomer::form-button data_bs_target="editPotentialCustomerModal"
                                        label="Edit" />
                                @endif
                                @if (app\Helpers\Helpers::perUser('potential_account_details.destroy'))
                                    <div class="float-end">
                                        <form
                                            action="{{ route('potential_account_details.destroy', ['potential_account' => $potentialAccount, 'potential_account_detail' => $potentialAccountDetails]) }}"
                                            method="POST">
                                            @csrf @method('DELETE')

                                            <button class="btn btn-danger btn-sm mx-2"><i class="fa-solid fa-trash fa-sm"
                                                    style="color: #ffffff;"></i></button>
                                        </form>
                                    </div>
                                @endIf
                            </div>

                            <!-- Potential Customer Details modal -->
                            <div class="modal fade" id="editPotentialCustomerModal" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title fs-1" id="editPotentialCustomerLabel">
                                                {{ __('Edit Potenial Customer Details') }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form
                                            action="{{ route('potential_account_details.update', ['potential_account' => $potentialAccount, 'potential_account_detail' => $potentialAccountDetails]) }}"
                                            method="POST" id="potentialAccountDetailsForm">
                                            @csrf @method('PUT')
                                            <div class="modal-body">

                                                <div class="row">
                                                    <div class="col">
                                                        <x-potentialcustomer::form-select name='current_insurer'
                                                            id="current_insurer" label="Current insurer" >
                                                            <option   value="">
                                                                {{ __('Select :type', ['type' => __('Current insurer')]) }}
                                                            </option>
                                                            <option @if ($potentialAccountDetails->current_insurer === 'yes') selected @endif
                                                                value= 'yes'>{{ __('Yes') }}
                                                            </option>
                                                            <option @if ($potentialAccountDetails->current_insurer === 'no') selected @endif
                                                                value='no'>{{ __('No') }}
                                                            </option>
                                                        </x-potentialcustomer::form-select>
                                                    </div>
                                                    <div class="col">
                                                        <x-potentialcustomer::form-select name='utilization'
                                                            id="utilization" label="Utilization" >
                                                            <option  value="">
                                                                {{ __('Select :type', ['type' => __('Utilization')]) }}
                                                            </option>
                                                            <option @if ($potentialAccountDetails->utilization === 'yes') selected @endif value="yes">{{ __('Yes') }}
                                                            </option>
                                                            <option @if ($potentialAccountDetails->utilization === 'no') selected @endif value="no">{{ __('No') }}
                                                            </option>
                                                        </x-potentialcustomer::form-select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <x-potentialcustomer::date-input label="{{ __('Starting Date') }}"
                                                            name="starting_date"  value="{{ isset($potentialAccountDetails) ? $potentialAccountDetails->starting_date  : old('starting_date') }}" id="starting_date" required/>
                                                    </div>
                                                    <div class="col-6">
                                                        <x-potentialcustomer::percentage-input label="Chance of Sale"
                                                            name="chance_of_sale" id="chance_of_sale"  value="{{ isset($potentialAccountDetails) ? $potentialAccountDetails->chance_of_sale : old('chance_of_sale')  }}"/>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-4">
                                                        <x-potentialcustomer::currency-input
                                                        value="{{ (isset($potentialAccountDetails) && $potentialAccountDetails->potential_premium > 0) ? number_format($potentialAccountDetails->potential_premium, 2, '.', ',') : old('potential_premium') }}"
                                                        label="Potential Premium" id="potential_premium"
                                                            name='potential_premium' placeholder="1,000,000 L.E"
                                                             />
                                                    </div>
                                                    <div class="col-4">
                                                        <x-potentialcustomer::currency-input
                                                        value="{{ (isset($potentialAccountDetails) && $potentialAccountDetails->price_range_min > 0) ? number_format($potentialAccountDetails->price_range_min, 2, '.', ',') : old('price_range_min') }}"
                                                            label="Min Price Range" id="price_range_min"
                                                            name='price_range_min' placeholder="1,000,000 L.E"  />
                                                    </div>
                                                    <div class="col-4">
                                                        <x-potentialcustomer::currency-input
                                                        value="{{ (isset($potentialAccountDetails) && $potentialAccountDetails->price_range_max > 0) ? number_format($potentialAccountDetails->price_range_max, 2, '.', ',') : old('price_range_max') }}"
                                                            label="Max Price Range" id="price_range_max"
                                                            name='price_range_max' placeholder="1,000,000 L.E"  />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <x-potentialcustomer::form-description
                                                            value="{{ isset($potentialAccountDetails) ? $potentialAccountDetails->reason : old('reason') }}"
                                                            label="Reason" name='reason' placeholder='Reasons ...'
                                                            id="reason" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary btn-sm">Confirm</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-4 mb-3">
                                    <strong>{{ __('Start Date') . ': ' }}</strong>{{ empty($potentialAccountDetails->starting_date) ? __('N/A') : $potentialAccountDetails->starting_date }}
                                </div>
                                <div class="col-4 mb-3">
                                    <strong>{{ __('Current insurer') . ': ' }}</strong>{{ empty($potentialAccountDetails->current_insurer) ? __('N/A') : Str::ucfirst($potentialAccountDetails->current_insurer)  }}
                                </div>
                                <div class="col-4 mb-3">
                                    <strong>{{ __('Utilization') . ': ' }}</strong>{{ empty($potentialAccountDetails->utilization) ? __('N/A') : Str::ucfirst($potentialAccountDetails->utilization)  }}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 mb-3">
                                    <strong>{{ __('Potential Premium') . ': ' }}</strong>{{ empty($potentialAccountDetails->potential_premium) ? __('N/A') : $potentialAccountDetails->potential_premium }}
                                </div>
                                <div class="col-4 mb-3">
                                    <strong>{{ __('Chance of sale') . ': ' }}</strong>{{ empty($potentialAccountDetails->chance_of_sale) ? __('N/A') : $potentialAccountDetails->chance_of_sale }}
                                </div>
                                <div class="col-4 mb-3">
                                    <strong>{{ __('Price range') . ': ' }}</strong>
                                    {{ empty($potentialAccountDetails->price_range_min) ? __('N/A') : $potentialAccountDetails->price_range_min }}
                                    :
                                    {{ empty($potentialAccountDetails->price_range_max) ? __('N/A') : $potentialAccountDetails->price_range_max }}
                                </div>
                            </div>
                            <div class="row ">
                                <div class="mb-3">
                                    <strong>{{ __('Reasons') . ': ' }}</strong>
                                    <p>
                                        {{ empty($potentialAccountDetails->reason) ? __('No Reasons added ..') : $potentialAccountDetails->reason }}
                                    </p>
                                </div>
                            </div>


                        </div>


                    </div>
                    <div class="card my-3">
                        <div class="card-header">
                            @include('dashboard.layouts.alerts')
                            <ul class="nav nav-underline" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="main-tab" data-bs-toggle="tab" href="#tab-main"
                                        role="tab" aria-controls="tab-main"
                                        aria-selected="true">{{ __('Main') }}</a>
                                </li>
                                <li class="nav-item"><a class="nav-link " id="reminder-tab" data-bs-toggle="tab"
                                        href="#tab-reminder" role="tab" aria-controls="tab-reminder"
                                        aria-selected="false">Reminder</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="todoList-tab" data-bs-toggle="tab"
                                        href="#tab-todoList" role="tab" aria-controls="tab-todoList"
                                        aria-selected="false">Todo List</a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab-main" role="tabpanel"
                                    aria-labelledby="main-tab">
                                    <h4>{{ __('Main') }}</h4>
                                </div>
                                <div class="tab-pane fade " id="tab-reminder" role="tabpanel"
                                    aria-labelledby="reminder-tab">
                                    <h4>{{ __('Reminders') }}</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            @if (app\Helpers\Helpers::perUser('lead_source.create'))
                                                <button class="btn btn-success float-end mb-3" type="button"
                                                    data-bs-toggle="modal" data-bs-target="#createReminder">
                                                    <i class="fa-solid fa-plus me-2"
                                                        style="color: #ffffff;"></i>{{ __('Create New Reminder') }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                    @foreach ($reminders as $reminder)
                                        <div class="card">
                                            <div class="card-header row pt-1">
                                                <div class="col-6 py-2">{{ __(ucfirst($reminder->reminder_title)) }}
                                                    @if ($reminder->reminder_type == 'note')
                                                        <span class="badge badge-phoenix badge-phoenix-primary mx-2">
                                                            <i
                                                                class="fa-solid fa-note-sticky fa-sm mx-1"></i>{{ $reminder->reminder_type }}
                                                        </span>
                                                    @elseif ($reminder->reminder_type == 'call')
                                                        <span class="badge badge-phoenix badge-phoenix-warning mx-2">
                                                            <i
                                                                class="fa-solid fa-phone fa-sm mx-1"></i>{{ $reminder->reminder_type }}
                                                        </span>
                                                    @elseif ($reminder->reminder_type == 'meeting')
                                                        <span class="badge badge-phoenix badge-phoenix-danger mx-2">
                                                            <i
                                                                class="fa-solid fa-handshake fa-sm mx-1"></i>{{ $reminder->reminder_type }}
                                                        </span>
                                                    @endif
                                                </div>



                                                <div
                                                    class="font-sans-serif btn-reveal-trigger position-static col-6  d-flex justify-content-end pe-0">
                                                    <button
                                                        class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2 ms-auto"
                                                        type="button" data-bs-toggle="dropdown" data-boundary="window"
                                                        aria-haspopup="true" aria-expanded="false"
                                                        data-bs-reference="parent">
                                                        <i class="fa-solid fa-ellipsis-vertical fa-xl"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end py-2">
                                                        @if (app\Helpers\Helpers::perUser('reminders.edit'))
                                                            <a href="{{ route('potential_accounts.editReminderPage', ['reminder' => $reminder, 'potential_account' => $potentialAccount->id]) }}"
                                                                class="dropdown-item">{{ __('Edit') }}</a>
                                                        @endif
                                                        @if (app\Helpers\Helpers::perUser('reminders.destroy'))
                                                            <div class="dropdown-divider"></div>
                                                            <a href="#"
                                                                class="dropdown-item text-danger delete-this-reminder"
                                                                data-id="{{ $reminder->id }}"
                                                                data-url="{{ route('reminders.destroy', ['reminder' => $reminder]) }}">
                                                                {{ __('Delete') }}
                                                            </a>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div>
                                                    <i class="fa-solid fa-calendar-days fa-sm me-2"></i>
                                                    <small class="me-3">{{ __($reminder->reminder_date) }}</small>
                                                </div>

                                            </div>
                                            <div class="card-body">


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

                                            </div>
                                            <div class="mb-1 mx-1">
                                                <small
                                                    class="me-3 float-end">{{ __('created by : ' . $reminder->user->name) }}</small>
                                                <small
                                                    class="me-3 float-end">{{ __('created at : ' . $reminder->created_at) }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                    {{ $reminders->links() }}
                                </div>
                            </div>
                            {{-- Reminder Modal --}}
                     <div class="modal fade" id="createReminder" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                {{ __('Create New Reminder') }}</h5>
                                            <button class="btn p-1" type="button" data-bs-dismiss="modal"
                                                aria-label="Close"><span class="fas fa-times fs--1"></span>
                                            </button>
                                        </div>
                                        <form id="reminderForm" action="{{ route('reminders.store') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-1">
                                                    <label for="reminder_type"
                                                        class="form-label">{{ __('Reminder Type') }}*</label>
                                                    <select class="form-select" style="width: 100%" name="reminder_type"
                                                        id="reminder_type">
                                                        <option @if (old('reminder_type' == 'note')) selected @endif
                                                            value="{{ 'note' }}">
                                                            {{ __('Note') }}</option>
                                                        <option @if (old('reminder_type' == 'call')) selected @endif
                                                            value="{{ 'call' }}">
                                                            {{ __('Call') }}</option>
                                                        <option @if (old('reminder_type' == 'meeting')) selected @endif
                                                            value="{{ 'meeting' }}">
                                                            {{ __('Meeting') }}</option>
                                                    </select>
                                                </div>
                                                <input type="text" name="reminder_relation" value="leads" hidden>
                                                <input type="text" name="lead_id" value="{{ $potentialAccount->id }}"
                                                    hidden>
                                                <div id="formsContainer">
                                                    <div id="noteForm">
                                                        <hr>
                                                        <div class="form-title">
                                                            <h6>{{ __('Note Reminder') }}</h6>
                                                        </div>
                                                    </div>
                                                    <div id="contactForm">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="note_reminder_title">{{ __('Title') }}*</label>
                                                    <input class="form-control form-control-sm" type="text"
                                                        name="reminder_title" placeholder="Reminder Title"
                                                        id="note_reminder_title" />
                                                </div>
                                                <div class="mb-1">
                                                    <label for="reminder_start_date"
                                                        class="form-label">{{ __('Start Date') }}*</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="reminder_start_date" id="reminder_start_date"
                                                        min="{{ now()->format('Y-m-d\TH:i') }}">
                                                </div>
                                                <div class="mb-1">
                                                    <label for="note_reminder_end_date"
                                                        class="form-label">{{ __('End Date') }}*</label>
                                                    <input type="datetime-local" class="form-control form-control-sm"
                                                        name="reminder_end_date" id="note_reminder_end_date"
                                                        min="{{ now()->format('Y-m-d\TH:i') }}">
                                                </div>
                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="bootstrap-wizard-wizard-address">{{ __('Description') }}</label>
                                                    <textarea class="form-control form-control-sm" rows="4" name="description"
                                                        id="bootstrap-wizard-wizard-address" placeholder="Reminder Description"></textarea>
                                                </div>
                                                <hr>
                                                <div class="mb-1">
                                                    <label for="reminder_type_id"
                                                        class="form-label">{{ __('Status') }}*</label>
                                                    <select class="form-select" style="width: 100%" name="status"
                                                        id="status">
                                                        <option @if (old('status' == 'active')) selected @endif
                                                            value="active">
                                                            {{ __('Active') }}</option>
                                                        <option @if (old('status' == 'inactive')) selected @endif
                                                            value="inactive">
                                                            {{ __('Inactive') }}</option>
                                                        <option @if (old('status' == 'draft')) selected @endif
                                                            value="draft">
                                                            {{ __('Draft') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-success btn"
                                                    type="submit">{{ __('Create') }}</button>
                                                <button class="btn btn-outline-secondary" type="button"
                                                    data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="tab-todoList" role="tabpanel" aria-labelledby="todoList-tab">
                                <h4>{{ __('Todo List') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lead-details-container my-3">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-underline" id="myTab" role="tablist">
                                <li class="nav-item " role="presentation"><a class="nav-link active" id="link-tab"
                                        data-bs-toggle="tab" href="#tab-link" role="tab" aria-controls="tab-link"
                                        aria-selected="false" tabindex="-1">{{ __('Links') }}</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" id="familyMember-tab"
                                        data-bs-toggle="tab" href="#tab-familyMember" role="tab"
                                        aria-controls="tab-familyMember" aria-selected="false"
                                        tabindex="-1">{{ __('Family Members') }}</a></li>
                                <li class="nav-item" role="presentation"><a class="nav-link" id="collectedData-tab"
                                        data-bs-toggle="tab" href="#tab-collectedData" role="tab"
                                        aria-controls="tab-collectedData" aria-selected="false"
                                        tabindex="-1">{{ __('Collected Customer Data') }}</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab-link" role="tabpanel"
                                    aria-labelledby="link-tab">
                                    <h4 class="mb-3" id="scrollspyLinks">{{ __('Links') }}</h4>
                                    @include('dashboard.layouts.alerts')
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Link</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Exp Date</th>
                                                <th scope="col">Created at</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($links as $link)
                                                <tr>
                                                    <td scope="row">{{ $loop->iteration }}</td>
                                                    <td class="small text-center"><a
                                                            href="{{ $link->url }}">{{ $link->subject }}</a></td>
                                                    <td class="small text-center">

                                                        @if ($link->status == 'active')
                                                            <i
                                                                class="fas fa-circle fa-sm mx-2 text-success"></i>{{ ucfirst($link->status) }}
                                                        @elseif ($link->status == 'inactive')
                                                            <i
                                                                class="fas fa-circle fa-sm mx-2 text-secondary"></i>{{ ucfirst($link->status) }}
                                                        @endif
                                                    </td>
                                                    <td class="small text-center">{{ $link->expired_at }}</td>
                                                    <td class="small text-center">{{ $link->created_at }}</td>
                                                    <td>
                                                        <a class="btn btn-phoenix-secondary btn-sm btn-sm text-center fs--2 text-danger delete-this-link"
                                                            data-id={{ $link->id }}
                                                            data-url="{{ route('links.destroy', ['link' => $link->id]) }}">
                                                            <span class="fas fa-trash"></span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="mt-8">
                                        <a class="fw-bold fs--1 mt-4" href="#" data-bs-toggle="modal"
                                            data-bs-target="#generateLinkModal">
                                            <span class="fas fa-plus me-1"></span>{{ __('Generate new Link') }}
                                        </a>
                                        <!-- Modal -->
                                        <div class="modal fade" id="generateLinkModal" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-1" id="staticBackdropLabel">
                                                            {{ __('Generate a Link For Potential Customer') }}
                                                        </h1>
                                                        <button type="button" class="btn-close btn-sm"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('links.store') }}" method="POST"
                                                        id="familyMembersForm">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <input type="hidden" id="dataIdInput"
                                                                name='potential_account_id'
                                                                value="{{ $potentialAccount->id }}">
                                                            <div class="mb-3">
                                                                <label for="inputText"
                                                                    class="form-label">{{ __('Subject') }}:</label>
                                                                <input type="text" class="form-control" name="subject"
                                                                    required minlength="3" maxlength="100"
                                                                    placeholder="Link Subject">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="inputText"
                                                                    class="form-label">{{ __('Expiration Date') }}:</label>
                                                                <input type="datetime-local" class="form-control"
                                                                    name="expired_at" required
                                                                    min="{{ now()->format('Y-m-d\TH:i') }}">
                                                            </div>

                                                            <div class="form-group mb-3">
                                                                <div class="form-check form-switch ">
                                                                    <input class="form-check-input" id="has_family"
                                                                        type="checkbox" name="has_family" />
                                                                    <label class="form-check-label"
                                                                        for="has_family">{{ __('With Family data') }}</label>
                                                                </div>
                                                            </div>



                                                            <div id="family_data"></div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary btn-sm"
                                                                data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                            <button type="submit" class="btn btn-primary btn-sm"><i
                                                                    class="fa-solid fa-arrows-rotate  me-2"></i>{{ __('Generate URL Link') }}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-familyMember" role="tabpanel"
                                    aria-labelledby="familyMember-tab">
                                    <h4 id="v-pills-profile">{{ __('Family Members') }}</h4>

                                    <div class="table-responsive scrollbar mx-n1 px-1">
                                        <table class="table fs--1 mb-0">
                                            <thead>
                                                <th class="text-center">#</th>
                                                <th class="text-center">{{ __('Name') }}</th>
                                                <th class="text-center">{{ __('Relationship') }}</th>
                                                <th class="text-center">{{ __('Link') }}</th>
                                                <th class="text-center">{{ __('Date of Birth') }}</th>
                                                <th class="text-center">{{ __('National ID') }} </th>
                                                <th class="text-center">{{ __('Phone') }}</th>
                                                <th class="text-center">{{ __('Personal Image') }}</th>
                                                <th class="text-center">{{ __('Id Card') }}</th>

                                            </thead>
                                            <tbody class="list" id="lead-details-table-body">
                                                @foreach ($headMembers as $headMember)
                                                    <tr style="background-color:yellow ">
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-center">{{ $headMember->head_name }}</td>
                                                        <td class="text-center">{{ 'head' }}</td>
                                                        <td class="text-center">
                                                            {{ optional($headMember->link)->subject }}</td>
                                                        <td class="text-center">{{ $headMember->head_birth_date }}</td>
                                                        <td class="text-center">{{ $headMember->head_national_id }}</td>
                                                        <td class="text-center">{{ $headMember->head_phone }}</td>
                                                        @php
                                                            $head_files = $headMember->headFiles->whereNull(
                                                                'family_member_id',
                                                            );
                                                            $personalImage = $head_files
                                                                ->whereNotNull('personal_image')
                                                                ->first();
                                                            $idCard = $head_files->whereNull('personal_image');
                                                        @endphp
                                                        <td class="text-center">
                                                            <a href="#" class="open-modal2 mx-2"
                                                                data-bs-toggle="modal" data-bs-target="#imageModal2"
                                                                data-data="{{ asset('storage/' . $personalImage->personal_image) }}">
                                                                <img src="{{ asset('storage/' . $personalImage->personal_image) }}"
                                                                    width="50px" height="50px" alt="">
                                                            </a>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="row">
                                                                @foreach ($idCard as $card)
                                                                    <div class="col-sm-6">
                                                                        <a href="#" class="open-modal2 mx-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#imageModal2"
                                                                            data-data="{{ asset('storage/' . $card->national_id_card) }}">
                                                                            <img src="{{ asset('storage/' . $card->national_id_card) }}"
                                                                                width="50px" height="50px"
                                                                                alt="" class="mx-1">
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>

                                                        </td>
                                                    </tr>
                                                    @foreach ($headMember->familyMembers as $familyMember)
                                                        <tr>
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-center">{{ $familyMember->name }}</td>
                                                            <td class="text-center">
                                                                {{ $familyMember->relationship }}</td>
                                                            <td class="text-center">
                                                                {{ optional($headMember->link)->subject }}</td>
                                                            <td class="text-center">{{ $familyMember->birth_date }}</td>
                                                            <td class="text-center">{{ $familyMember->national_id }}</td>
                                                            <td class="text-center">{{ $familyMember->phone }}</td>
                                                            @php
                                                                $member_files = $familyMember->familyMemberFiles;
                                                                $memberPersonalImage = $member_files
                                                                    ->whereNotNull('personal_image')
                                                                    ->first();
                                                                $memberIdCard = $member_files->whereNotNull(
                                                                    'national_id_card',
                                                                );
                                                            @endphp
                                                            <td class="text-center">
                                                                <a href="#" class="open-modal2 mx-2"
                                                                    data-bs-toggle="modal" data-bs-target="#imageModal2"
                                                                    data-data="{{ asset('storage/' . $memberPersonalImage->personal_image) }}">
                                                                    <img src="{{ asset('storage/' . $memberPersonalImage->personal_image) }}"
                                                                        width="50px" height="50px" alt="">
                                                                </a>
                                                            </td>
                                                            <td class="text-center">
                                                                <div class="row">
                                                                    @foreach ($memberIdCard as $card)
                                                                        <div class="col-sm-6">
                                                                            <a href="#" class="open-modal2 mx-2"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#imageModal2"
                                                                                data-data="{{ asset('storage/' . $card->national_id_card) }}">
                                                                                <img src="{{ asset('storage/' . $card->national_id_card) }}"
                                                                                    width="50px" height="50px"
                                                                                    class="mx-1" alt="">
                                                                            </a>
                                                                        </div>
                                                                    @endforeach
                                                                </div>

                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                        {{-- <div class="mt-8">
                                            <a class="fw-bold fs--1 mt-4" href="#"><span
                                                    class="fa-solid fa-plus me-2"></span>{{ __('Add Family Member') }}
                                            </a>
                                        </div> --}}
                </div>
            </div>

            <div class="tab-pane fade" id="tab-collectedData" role="tabpanel" aria-labelledby="collectedData-tab">
                <h4 id="v-pills-profile">{{ __('Collected Customer Data') }}</h4>
                <div class="table-responsive">
                    <table class="table table-striped table-xs fs--1 mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Policy Holder') }}</th>
                                <th class="text-center">{{ __('Member Name') }}</th>
                                <th class="text-center">{{ __('Employee Code') }}</th>
                                <th class="text-center">{{ __('Medical Code') }}</th>
                                <th class="text-center">{{ __('Gender') }}</th>
                                <th class="text-center">{{ __('Date Of Birth') }}</th>
                                <th class="text-center">{{ __('Marital Status') }}</th>
                                <th class="text-center">{{ __('Start Date') }}</th>
                                <th class="text-center">{{ __('End Date') }}</th>

                                <th class="text-center">{{ __('Insurance Category') }}</th>
                                <th class="text-center">{{ __('Room Type') }}</th>
                                <th class="text-center">{{ __('Optical') }}</th>
                                <th class="text-center">{{ __('Dental') }}</th>
                                <th class="text-center">{{ __('Medication') }}</th>
                                <th class="text-center">{{ __('maternity') }}</th>
                                <th class="text-center">{{ __('Hof Id') }}</th>
                                <th class="text-center">{{ __('Labs And Radiology') }}</th>
                                <th class="text-center">{{ __('Notes') }}</th>
                                <th class="text-center">{{ __('Potential Account') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($collectedData as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $data->policy_holder }}</td>
                                    <td class="text-center ">{{ $data->member_name }}</td>
                                    <td class="text-center ">{{ $data->employee_code }}</td>
                                    <td class="text-center ">{{ $data->medical_code }}</td>
                                    <td class="text-center ">{{ $data->gender }}</td>
                                    <td class="text-center ">{{ $data->date_of_birth }}</td>
                                    <td class="text-center ">{{ $data->marital_status }}</td>
                                    <td class="text-center ">{{ $data->start_date }}</td>
                                    <td class="text-center ">{{ $data->end_date }}</td>
                                    <td class="text-center ">{{ $data->insurance_category }}</td>
                                    <td class="text-center ">{{ $data->room_type }}</td>
                                    <td class="text-center ">{{ $data->optical }}</td>
                                    <td class="text-center ">{{ $data->dental }}</td>
                                    <td class="text-center ">{{ $data->medication }}</td>
                                    <td class="text-center ">{{ $data->maternity }}</td>
                                    <td class="text-center ">{{ $data->hof_id }}</td>
                                    <td class="text-center ">{{ $data->labs_and_radiology }}</td>
                                    <td class="text-center ">{{ $data->notes }}</td>
                                    <td class="text-center ">
                                        {{ $data->potentialAccount->account_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive scrollbar mx-n1 px-1">

                </div>

                <div class=" d-flex justify-content-center">
                    <div class="">{{ $collectedData->links() }}</div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    </div>
    </div>
    </div>
    <!-- Image Modal -->
    <div class="modal fade" id="imageModal2" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content bg-transparent">
                <div class="modal-body">
                    <!-- Image -->
                    <img id="modalImage2" class="img-fluid" alt="User Image">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        $('#imageModal2').on('show.bs.modal', function(event) {
            var triggerElement = $(event.relatedTarget);
            var imageUrl = triggerElement.data('data');
            $('#modalImage2').attr('src', imageUrl);
        });

        $(document).ready(function() {
            $("#current_insurer,#utilization").select2({
                dropdownParent: $("#editPotentialCustomerModal")
            });
        });
    </script>

    <script>
        $(document).ready(function() {

            $(document).on('click', '.delete-this-link', function(e) {
                e.preventDefault();
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');
                Swal.fire({
                    title: '{{ __('Do you really want to delete this Link ?') }}',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('Yes') }}',
                    cancelButtonText: '{{ __('No') }}',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "DELETE",
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            success: function(msg) {
                                window.location.href =
                                    "{{ route('potential_account.show', ['potential_account' => "$potentialAccount->id"]) }}";
                                Swal.fire(msg.message, '', msg.success ? 'success' :
                                    'error');
                            }
                        });

                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $(document).on('click', '.delete-this-reminder', function(e) {
                e.preventDefault();
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');
                Swal.fire({
                    title: '{{ __('Do you really want to delete this Reminder ?') }}',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('Yes') }}',
                    cancelButtonText: '{{ __('No') }}',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "DELETE",
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            success: function(msg) {
                                window.location.href =
                                    "{{ route('potential_account.show', ['potential_account' => "$potentialAccount->id"]) }}";
                                Swal.fire(msg.message, '', msg.success ? 'success' :
                                    'error');
                            }
                        });

                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#reminder_type,#reminder_relation,#lead_id,#status,#contact_id,#contact_id").select2({
                dropdownParent: $("#createReminder")
            });
        });
    </script>
    {{--  <script>
        $(document).ready(function() {
            $('#leadSelectContainer').hide();

            $('#reminder_relation').change(function() {
                if ($(this).val() == '') {
                    $('#leadSelectContainer').hide();
                } else {
                    $('#leadSelectContainer').show();
                }
            });


            $('#reminder_type').change(function() {
                // Remove existing forms
                $('#formsContainer').children().remove();

                // Check the selected reminder type and show the corresponding form
                if ($(this).val() === 'call') {
                    $(`
                        <div id="callForm">
                            <hr>
                            <div class="form-title">
                                <h6>{{ __('Call Reminder') }}</h6>
                                <button type="button" id="addContactBtn" class="btn btn-primary btn-sm mb-2 float-end">+ {{ __('Add contact') }}</button>
                            </div>
                                    <div class="mb-1">
                                        <label for="contact_id" class="form-label">{{ __('Contact') }}*</label>
                                        <select class="form-select js-example-basic-multiple fs-xs form-select-sm" style="width: 100%"
                                        data-options='{"removeItemButton":true,"placeholder":true}'
                                        data-placeholder="{{ __('Select :type', ['type' => __('Contact')]) }}"
                                        required multiple="multiple" name="contact_id[]" id="contact_id">
                                            @foreach ($contacts as $contact)
                                            <option value="{{ $contact->id }}">{{ $contact->name . ' ' }} - {{ implode('- ', $contact->phones->pluck('phone')->toArray()) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                        </div>`).appendTo('#formsContainer');

                    $("#contact_id").select2({
                        dropdownParent: $("#createReminder")
                    });
                } else if ($(this).val() === 'meeting') {
                    $(`
                                <div id="meetingForm">
                                    <hr>
                                    <div class="form-title">
                                        <h6>{{ __('Meeting Reminder') }}</h6>
                                    </div>
                                </div>`).appendTo('#formsContainer');
                }
            });

            $('#reminderForm').validate({
                rules: {
                    reminder_type: {
                        required: true,
                    },
                    lead_id: {
                        required: function(element) {
                            return $('#reminder_relation').val() === 'leads';
                        }
                    },
                    reminder_title: {
                        required: true,
                        maxlength: 100
                    },
                    reminder_start_date: {
                        required: true,
                        date: true,
                        min: todayFormatted(),
                    },
                    reminder_end_date: {
                        required: true,
                        date: true,
                        min: todayFormatted(),
                        greaterThanStartDate: true,
                    },
                    description: {
                        maxlength: 2000
                    },
                    status: {
                        required: true,
                    },
                    contact_id: {
                        required: true,
                    }
                },
                messages: {
                    reminder_type: {
                        required: "The reminder type is required.",
                    },
                    lead_id: {
                        required: "The lead  is required.",
                    },
                    reminder_title: {
                        required: "The reminder title is required.",
                        maxlength: "The reminder title must not exceed 100 characters."
                    },
                    reminder_start_date: {
                        required: "Start Date is required",
                        date: "Invalid Start Date format",
                        min: "Start Date cannot be in the past",
                    },
                    reminder_end_date: {
                        required: "End Date is required",
                        date: "Invalid End Date format",
                        min: "End Date cannot be in the past",
                        greaterThanStartDate: "End Date must be after Start Date",
                    },
                    description: {
                        maxlength: "The description must not exceed 2000 characters."
                    },
                    status: {
                        required: "The status is required.",
                    },
                    contact_id: {
                        required: "The contact  is required.",

                    }
                },
                errorClass: "error", // CSS class to apply to error elements
                errorElement: "span", // Wrapping element for error messages
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                    $(element.form).find("label[for=" + element.id + "]").addClass(errorClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                    $(element.form).find("label[for=" + element.id + "]").removeClass(errorClass);
                }
            });




            $.validator.addMethod("greaterThanStartDate", function(value, element) {
                var startDate = $('#reminder_start_date').val();
                console.log(value, startDate);
                return Date.parse(value) > Date.parse(startDate);
            }, "End Date must be after Start Date");

            function todayFormatted() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var yyyy = today.getFullYear();
                return yyyy + '-' + mm + '-' + dd;
            }




            // Handle click event on "Add contact" button
            $('#formsContainer').on('click', '#addContactBtn', function() {
                $('#formsContainer').append(`
                <div id="contactForm">
                    <hr>
                    <div class="form-title mb-3">
                        <h6>{{ __('Contact Form') }}</h6>
                    </div>
                    <div class="row">
                        <div class="form-group mb-1 col-6">
                            <label for="nameInput" class="form-label">{{ __('Contact Name') }}*</label>
                            <input type="text" class="form-control" name="name[]" id="nameInput" placeholder="Contact Name" required>
                        </div>
                        <div class="form-group mb-1 col-6">
                            <label for="emailInput" class="form-label">{{ __('Contact Email') }}*</label>
                            <input type="email" class="form-control" name="email[]" id="emailInput" placeholder="contact@example.com">
                        </div>
                        </div>

                        <div id="phones">
                            <div class="row">
                                <div class="form-group mb-1 col-8">
                                    <label for="phoneInput" class="form-label">{{ __('Contact Phone') }}*</label>
                                    <input type="text" class="form-control" name="phone[]" id="phoneInput" oninput="this.value = this.value.replace(/[^0-9+]/g, '')" placeholder="+2 01xxxxxxxxxx">
                                </div>
                                <div class="form-group mb-1 col-4">
                                    <button type="button" id="removeContactForm"  class="btn btn-sm btn-danger w-50  mt-4"><i class="fa-solid fa-trash fa-sm" style="color: #ffffff;"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>`);
            });
            // Handle click event on "Remove contact" button
            $('#formsContainer').on('click', '#removeContactForm', function() {
                // Remove the corresponding contact form
                $(this).closest('#contactForm').remove();
            });

            $("#contactForm").validate({
                rules: {
                    'name[]': {
                        required: true,
                        maxlength: 100
                    },
                    'email[]': {
                        email: true,
                        maxlength: 100
                    },
                    'phone[]': {
                        required: true,
                        maxlength: 20,
                        minlength: 8,
                    }
                },
                messages: {
                    'name[]': {
                        required: "Please enter the contact name",
                        maxlength: "Name must not exceed 100 characters"
                    },
                    'email[]': {
                        email: "Please enter a valid email address",
                        maxlength: "Email must not exceed 100 characters"
                    },
                    'phone[]': {
                        required: "Please enter a valid phone number",
                        maxlength: "Phone number must not exceed 20 characters",
                        minlength: "Phone number must be at least 8 characters"
                    }
                },
                errorElement: "span",
                errorClass: "text-danger fs--1"
            });
        });
    </script> --}}


    {{-- Generating Link Request --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '.generateLink', function(e) {
                var dataId = $(this).data("id");
                $("#dataIdInput").val(dataId);
            })
        })
    </script>

    {{-- Family data config script  --}}
    <script>
        $(document).ready(function() {
            $('#has_family').change(function() {
                $('#family_data').empty();
                if ($(this).prop('checked')) {
                    $('#family_data').empty();
                    $('#family_data').append(`
                    <div class="row">

                        <div class="form-group mb-3 col-4">
                            <div class="form-check form-switch ">
                                <input class="form-check-input" id="wife_husband" type="checkbox" name="wife_husband" />
                                <label class="form-check-label" for="wife_husband">{{ __('Wife/Husband') }}</label>
                            </div>
                        </div>

                        <div class="form-group mb-0 col-4">
                            <div class="form-check form-switch ">
                                <input class="form-check-input" id="has_parent" type="checkbox" name="has_parent" />
                                <label class="form-check-label" for="has_parent">{{ __('Parent') }}</label>
                            </div>
                        </div>

                        <div class="form-group col-4">
                            <div class="form-check form-switch ">
                                <input class="form-check-input" id="has_children" type="checkbox" name="has_children" />
                                <label class="form-check-label" for="has_children">{{ __('Children') }}</label>
                            </div>
                            <div  id="children_count_div"></div>
                        </div>
                    </div>
                    `);

                    $('#has_children').change(function() {
                        $('#children_count_div').empty();
                        console.log($('#has_children').val());
                        if ($(this).prop('checked')) {
                            $('#children_count_div').append(`
                        <div class="mt-2">
                            <label for="children_count" class="form-label">{{ __('Children Count Limit') }}:</label>
                            <input type="number" class="form-control form-control-sm" name="children_count" id="children_count" min="0"    placeholder="children Count">
                        </div>`)
                        }
                    });

                }

            });


        });
    </script>

    <script>
        $(document).ready(function() {
            $('#familyMembersForm').validate({
                rules: {
                    subject: {
                        required: true,
                        minlength: 3,
                        maxlength: 100
                    },
                    expired_at: {
                        required: true
                    },

                },
                messages: {
                    subject: {
                        required: "Please enter a subject.",
                        minlength: "Subject must be at least {0} characters.",
                        maxlength: "Subject must not exceed {0} characters."
                    },
                    expired_at: {
                        required: "Please enter an expiration date."
                    },
                },
                errorClass: "text-danger", // Set the error message color to red
                errorElement: "div",
            });

            $('#wife_husband').change(function() {
                $("#yourFormId").valid();
            });

            $('#has_children').change(function() {
                $("#yourFormId").valid();
            });
        });
    </script>

    <script>
        // Jquery Dependency

        $("input[data-type='currency']").on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });


        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#potentialAccountDetailsForm').validate({
                rules: {
                    starting_date: {
                        date: true
                    },
                    chance_of_sale: {
                        number: true,
                        min: 0,
                        max: 100
                    },
                    price_range_min: {
                        min: 0
                    },
                    price_range_max: {
                        min: function() {
                            return parseFloat($('#price_range_min').val()) ||
                            0;
                        }
                    },
                    reason: {
                        maxlength: 500
                    }
                },
                messages: {
                    starting_date: {
                        date: "Please enter a valid date."
                    },
                    chance_of_sale: {
                        min: "Chance of sale must be at least 0.",
                        max: "Chance of sale must be at most 100."
                    },
                    price_range_min: {
                        min: "Minimum price range must be at least 0."
                    },
                    price_range_max: {
                        min: "Maximum price range must be greater than or equal to minimum price range."
                    },
                    reason: {
                        maxlength: "Reason must not exceed 500 characters."
                    }
                },
                errorClass: "error text-danger",
                errorElement: "span",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                    $(element.form).find("label[for=" + element.id + "]").addClass(errorClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                    $(element.form).find("label[for=" + element.id + "]").removeClass(errorClass);
                },
            });

        });
    </script>
@endsection
