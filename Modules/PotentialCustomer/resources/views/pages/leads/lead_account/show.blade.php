@extends('dashboard.layouts.app')
@section('title')
    {{ __('Lead Account Page') }}
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
                        <h2 class="mb-0">Lead details</h2>
                    </div>
                    <div class="col-12 col-md-auto">
                        <div class="d-flex">
                            <div class="flex-1 d-md-none"><button class="btn px-3 btn-phoenix-secondary text-700 me-2"
                                    data-phoenix-toggle="offcanvas" data-phoenix-target="#productFilterColumn"><svg
                                        class="svg-inline--fa fa-bars" aria-hidden="true" focusable="false"
                                        data-prefix="fas" data-icon="bars" role="img" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 448 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M0 96C0 78.33 14.33 64 32 64H416C433.7 64 448 78.33 448 96C448 113.7 433.7 128 416 128H32C14.33 128 0 113.7 0 96zM0 256C0 238.3 14.33 224 32 224H416C433.7 224 448 238.3 448 256C448 273.7 433.7 288 416 288H32C14.33 288 0 273.7 0 256zM416 448H32C14.33 448 0 433.7 0 416C0 398.3 14.33 384 32 384H416C433.7 384 448 398.3 448 416C448 433.7 433.7 448 416 448z">
                                        </path>
                                    </svg><!-- <span class="fa-solid fa-bars"></span> Font Awesome fontawesome.com --></button>
                            </div>{{-- <button class="btn btn-primary me-2"><svg class="svg-inline--fa fa-envelope me-2"
                                    aria-hidden="true" focusable="false" data-prefix="fas" data-icon="envelope"
                                    role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                                    data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M464 64C490.5 64 512 85.49 512 112C512 127.1 504.9 141.3 492.8 150.4L275.2 313.6C263.8 322.1 248.2 322.1 236.8 313.6L19.2 150.4C7.113 141.3 0 127.1 0 112C0 85.49 21.49 64 48 64H464zM217.6 339.2C240.4 356.3 271.6 356.3 294.4 339.2L512 176V384C512 419.3 483.3 448 448 448H64C28.65 448 0 419.3 0 384V176L217.6 339.2z">
                                    </path>
                                </svg><!-- <span class="fa-solid fa-envelope me-2"></span> Font Awesome fontawesome.com --><span>Send
                                    an email</span></button>

                            <button class="btn btn-phoenix-secondary px-3 px-sm-5 me-2"><svg
                                    class="svg-inline--fa fa-thumbtack me-sm-2" aria-hidden="true" focusable="false"
                                    data-prefix="fas" data-icon="thumbtack" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M32 32C32 14.33 46.33 0 64 0H320C337.7 0 352 14.33 352 32C352 49.67 337.7 64 320 64H290.5L301.9 212.2C338.6 232.1 367.5 265.4 381.4 306.9L382.4 309.9C385.6 319.6 383.1 330.4 377.1 338.7C371.9 347.1 362.3 352 352 352H32C21.71 352 12.05 347.1 6.04 338.7C.0259 330.4-1.611 319.6 1.642 309.9L2.644 306.9C16.47 265.4 45.42 232.1 82.14 212.2L93.54 64H64C46.33 64 32 49.67 32 32zM224 384V480C224 497.7 209.7 512 192 512C174.3 512 160 497.7 160 480V384H224z">
                                    </path>
                                </svg><!-- <span class="fa-solid fa-thumbtack me-sm-2"></span> Font Awesome fontawesome.com -->
                                <span class="d-none d-sm-inline">Shortlist</span>
                            </button> --}}

                            {{--  <button
                                class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="dropdown"
                                data-boundary="window" aria-haspopup="true" aria-expanded="false"
                                data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis" aria-hidden="true"
                                    focusable="false" data-prefix="fas" data-icon="ellipsis" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M120 256C120 286.9 94.93 312 64 312C33.07 312 8 286.9 8 256C8 225.1 33.07 200 64 200C94.93 200 120 225.1 120 256zM280 256C280 286.9 254.9 312 224 312C193.1 312 168 286.9 168 256C168 225.1 193.1 200 224 200C254.9 200 280 225.1 280 256zM328 256C328 225.1 353.1 200 384 200C414.9 200 440 225.1 440 256C440 286.9 414.9 312 384 312C353.1 312 328 286.9 328 256z">
                                    </path>
                                </svg><!-- <span class="fa-solid fa-ellipsis"></span> Font Awesome fontawesome.com --></button>
                            <ul class="dropdown-menu dropdown-menu-end p-0" style="z-index: 9999;">
                                <li><a class="dropdown-item" href="#!">View profile</a></li>
                                <li><a class="dropdown-item" href="#!">Report</a></li>
                                <li><a class="dropdown-item" href="#!">Manage notifications</a></li>
                                <li><a class="dropdown-item text-danger" href="#!">Delete Lead</a></li>
                            </ul> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-0 g-md-4 g-xl-6">
            <div class="col-md-5 col-lg-5 col-xl-4">
                <div class="sticky-leads-sidebar">
                    <div class="d-flex justify-content-between align-items-center mb-2 d-md-none">
                        <h3 class="mb-0">Lead Details</h3><button class="btn p-0" data-phoenix-dismiss="offcanvas"><span
                                class="uil uil-times fs-1"></span></button>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center g-3 text-center text-xxl-start">
                                <div class="col-12 col-xxl-auto">
                                    <div class="avatar avatar-5xl"><img class="rounded-circle"
                                            src="@if (isset($leadAccount->image)) {{ asset('storage') . '/' . $leadAccount->image }}@else{{ asset('dashboard') }}\assets\img\team\avatar.png @endif"
                                            alt=""></div>
                                </div>
                                <div class="col-12 col-sm-auto flex-1">
                                    <h3 class="fw-bolder mb-2">{{ $leadAccount->account_name }}</h3>
                                    <p class="mb-0">{{ $leadAccount->lead_account_title }}</p><a class="fw-bold"
                                        href="#!">Company Name</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5 ">
                                <h3>{{ __('About lead') }}</h3>
                                <a class="btn btn-link" href="{{ route('lead_account.edit', $leadAccount->id) }}">Edit</a>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-envelope-alt">
                                    </span>
                                    <h5 class="text-1000 mb-0">{{ __('Email') }}</h5>
                                </div><a href="mailto:shatinon@jeemail.com:">{{ $leadAccount->email }}</a>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-phone"> </span>
                                    <h5 class="text-1000 mb-0">{{ 'Personal Number' }}</h5>
                                </div><a href="tel:+1234567890">{{ $leadAccount->personal_number }}</a>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-phone"> </span>
                                    <h5 class="text-1000 mb-0">{{ __('mobile') }}</h5>
                                </div><a href="tel:+1234567890">{{ $leadAccount->mobile }}</a>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-phone"> </span>
                                    <h5 class="text-1000 mb-0">{{ __('Phone') }}</h5>
                                </div><a href="tel:+1234567890">{{ $leadAccount->phone }}</a>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-globe"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Website') }}</h5>
                                </div><a href="#!">{{ $leadAccount->website }}</a>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-clock"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Notes') }}</h5>
                                </div>
                                <p class="mb-0 text-800">
                                    {{ $leadAccount->notes ? $leadAccount->notes : 'Empty..' }}</p>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-clock"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Created By') }}</h5>
                                </div>
                                <p class="mb-0 text-800">{{ $leadAccount->user->name }}</p>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span
                                        class="me-2 uil uil-file-check-alt"></span>
                                    <h5 class="text-1000 mb-0">{{ __('Lead source') }}</h5>
                                </div>
                                <p class="mb-0 text-800">
                                    {{ $leadAccount->leadSource ? $leadAccount->leadSource->title : 'N\A' }}</p>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-1"><span
                                        class="me-2 uil uil-check-circle"></span>
                                    <h5 class="text-1000 mb-0">{{ 'Lead status' }}</h5>
                                </div><span
                                    class="badge badge-phoenix badge-phoenix-primary">{{ $leadAccount->leadValue ? $leadAccount->leadValue->title : 'N\A' }}</span>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-1"><span
                                        class="me-2 uil uil-check-circle"></span>
                                    <h5 class="text-1000 mb-0">{{ 'Lead status' }}</h5>
                                </div><span
                                    class="badge badge-phoenix badge-phoenix-primary">{{ $leadAccount->leadStatus ? $leadAccount->leadStatus->title : 'N\A' }}</span>
                            </div>
                            <hr>
                            <div class="d-flex align-items-center mb-5">
                                <h3>{{ __('Address') }}</h3>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-estate"></span>
                                    <h5 class="mb-0">{{ __('Address') }}</h5>
                                </div>
                                <p class="mb-0 text-800">{{ $leadAccount->address ? $leadAccount->address : 'Empty..' }}
                                </p>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-map-pin-alt"></span>
                                    <h5 class="mb-0 text-1000">{{ __('Zip code') }}</h5>
                                </div>
                                <p class="mb-0 text-800">{{ $leadAccount->zip_code ? $leadAccount->zip_code : 'Empty..' }}
                                </p>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-map"></span>
                                    <h5 class="mb-0 text-1000">{{ __('City') }}</h5>
                                </div>
                                <p class="mb-0 text-800">{{ $leadAccount->city->name }}</p>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-map"></span>
                                    <h5 class="mb-0 text-1000">{{ __('State') }}</h5>
                                </div>
                                <p class="mb-0 text-800">{{ $leadAccount->city->state->name }}</p>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-1"><span class="me-2 uil uil-windsock"></span>
                                    <h5 class="mb-0 text-1000">{{ __('Country') }}</h5>
                                </div>
                                <p class="mb-0 text-800">{{ $leadAccount->city->state->country->name }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="phoenix-offcanvas-backdrop d-lg-none top-0" data-phoenix-backdrop="data-phoenix-backdrop">
                </div>
            </div>

            <div class="col-md-7 col-lg-7 col-xl-8">
                <div class="lead-details-container">
                    <div class="card">
                        <div class="card-header">
                            @include('dashboard.layouts.alerts')
                            <ul class="nav nav-underline" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="main-tab" data-bs-toggle="tab" href="#tab-main"
                                        role="tab" aria-controls="tab-main"
                                        aria-selected="true">{{ __('Main') }}</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="reminder-tab" data-bs-toggle="tab"
                                        href="#tab-reminder" role="tab" aria-controls="tab-reminder"
                                        aria-selected="false">Reminder</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="todoList-tab" data-bs-toggle="tab"
                                        href="#tab-todoList" role="tab" aria-controls="tab-todoList"
                                        aria-selected="false">Todo List</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content mt-3" id="myTabContent">
                                <div class="tab-pane fade show active" id="tab-main" role="tabpanel"
                                    aria-labelledby="main-tab">

                                </div>
                                <div class="tab-pane fade" id="tab-reminder" role="tabpanel"
                                    aria-labelledby="reminder-tab">

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
                                                            <a href="{{ route('lead_account.editReminderPage', ['reminder' => $reminder, 'lead_account' => $leadAccount->id]) }}"
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
                                    <div class="card-footer d-flex justify-content-center">
                                        <div class="">{{ $reminders->links() }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tab-todoList" role="tabpanel" aria-labelledby="todoList-tab">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Reminder Modal --}}
    <div class="modal fade" id="createReminder" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Create New Reminder') }}</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span
                            class="fas fa-times fs--1"></span>
                    </button>
                </div>
                <form id="reminderForm" action="{{ route('reminders.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="reminder_type" class="form-label">{{ __('Reminder Type') }}*</label>
                            <select class="form-select" style="width: 100%" name="reminder_type" id="reminder_type">
                                <option @if (old('reminder_type' == 'note')) selected @endif value="{{ 'note' }}">
                                    {{ __('Note') }}</option>
                                <option @if (old('reminder_type' == 'call')) selected @endif value="{{ 'call' }}">
                                    {{ __('Call') }}</option>
                                <option @if (old('reminder_type' == 'meeting')) selected @endif value="{{ 'meeting' }}">
                                    {{ __('Meeting') }}</option>
                            </select>
                        </div>
                        <input type="text" name="reminder_relation" value="leads" hidden>
                        <input type="text" name="lead_id" value="{{ $leadAccount->id }}" hidden>
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
                            <label class="form-label" for="note_reminder_title">{{ __('Title') }}*</label>
                            <input class="form-control form-control-sm" type="text" name="reminder_title"
                                placeholder="Reminder Title" id="note_reminder_title" />
                        </div>
                        <div class="mb-1">
                            <label for="reminder_start_date" class="form-label">{{ __('Start Date') }}*</label>
                            <input type="datetime-local" class="form-control form-control-sm" name="reminder_start_date"
                                id="reminder_start_date" min="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="mb-1">
                            <label for="note_reminder_end_date" class="form-label">{{ __('End Date') }}*</label>
                            <input type="datetime-local" class="form-control form-control-sm" name="reminder_end_date"
                                id="note_reminder_end_date" min="{{ now()->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="mb-1">
                            <label class="form-label"
                                for="bootstrap-wizard-wizard-address">{{ __('Description') }}</label>
                            <textarea class="form-control form-control-sm" rows="4" name="description"
                                id="bootstrap-wizard-wizard-address"  placeholder="Reminder Description"></textarea>
                        </div>
                        <hr>
                        <div class="mb-1">
                            <label for="reminder_type_id" class="form-label">{{ __('Status') }}*</label>
                            <select class="form-select" style="width: 100%" name="status" id="status">
                                <option @if (old('status' == 'active')) selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (old('status' == 'inactive')) selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (old('status' == 'draft')) selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success btn-sm" type="submit">{{ __('Create') }}</button>
                        <button class="btn btn-outline-secondary btn-sm" type="button"
                            data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

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
                                    "{{ route('lead_account.show', ['lead_account' => "$leadAccount->id"]) }}";

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
    <script>
        $(document).ready(function() {
            $("#reminder_type,#reminder_relation,#lead_id,#status,#contact_id,#contact_id").select2({
                dropdownParent: $("#createReminder")
            });
        });
    </script>
    <script>
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
                        <x-reminder::form-input type="text" value="" label="Contact Name" name='name[]'
                            placeholder='Contact Name' id="nameInput" oninput="{{ null }}" required />

                        <x-reminder::form-input type="email" value="" label="Contact Email" name='email[]'
                            placeholder='contact@example.com' id="emailInput" oninput="{{ null }}"  />

                        </div>

                        <div id="phones">
                            <div class="row">
                                <x-reminder::form-input type="text" value="" label="Contact Phone"
                                    name='phone[]' placeholder='01xxxxxxxxxx' id="phoneInput"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />
                                <div class="form-group mb-1 col-4">
                                    <x-potentialcustomer::remove-button class="remove-phone"  id="removeContactForm" />

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
    </script>

@endsection
