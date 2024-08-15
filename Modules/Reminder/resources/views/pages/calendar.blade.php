@extends('dashboard.layouts.app')
@section('title')
    {{ __('Calendar Page') }}
@endsection
@section('css')
    <link href="{{ asset('dashboard') }}/vendors/fullcalendar/main.min.css" rel="stylesheet">
    <link href="{{ asset('dashboard') }}/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
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
    <div class="row g-0 mb-4 mt-6 align-items-center">
        <div class="col-5 col-md-6">
            <h4 class="mb-0 text-1100 fw-bold fs-md-2"><span class="calendar-day d-block d-md-inline mb-1"></span><span
                    class="px-3 fw-thin text-400 d-none d-md-inline">|</span><span class="calendar-date"></span></h4>
        </div>
        <div class="col-7 col-md-6 d-flex justify-content-end"><button class="btn btn-link text-900 px-0 me-2 me-md-4"><span
                    class="fa-solid fa-sync fs--2 me-2"></span><span class="d-none d-md-inline">Sync
                    Now</span></button><button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal"
                data-bs-target="#createReminder"> <span class="fas fa-plus pe-2 fs--2"></span>Add new task </button></div>
    </div>
    <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 border-y border-200">
        <div class="row py-3 gy-3 gx-0">
            <div class="col-6 col-md-4 order-1 d-flex align-items-center"><button
                    class="btn btn-sm btn-phoenix-primary px-4" data-event="today">Today</button></div>
            <div class="col-12 col-md-4 order-md-1 d-flex align-items-center justify-content-center"><button
                    class="btn icon-item icon-item-sm shadow-none text-1100 p-0" type="button" data-event="prev"
                    title="Previous"><span class="fas fa-chevron-left"></span></button>
                <h3 class="px-3 text-1100 fw-semi-bold calendar-title mb-0"> </h3><button
                    class="btn icon-item icon-item-sm shadow-none text-1100 p-0" type="button" data-event="next"
                    title="Next"><span class="fas fa-chevron-right"></span></button>
            </div>
            <div class="col-6 col-md-4 ms-auto order-1 d-flex justify-content-end">
                <div>
                    <div class="btn-group btn-group-sm" role="group"><button class="btn btn-phoenix-secondary active-view"
                            data-fc-view="dayGridMonth">Month</button><button class="btn btn-phoenix-secondary"
                            data-fc-view="timeGridWeek">Week</button></div>
                </div>
            </div>
        </div>
    </div>


    <div class="calendar-outline mt-6 mb-9" id="appCalendar">


    </div>

    <div id="routeData" data-route="{{ route('reminders.remindersOnCalendar') }}"></div>
    <div id="updateDateRoute" data-route="{{ route('reminders.updateDateWithDragAndDrop') }}"></div>


    <div class="modal fade" id="eventDetailsModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border"></div>
        </div>
    </div>
    <div class="modal fade" id="createReminder" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border">
                <form id="reminderForm" action="{{ route('reminders.store') }}" method="POST" enctype="multipart/form-data"
                    id="addEventForm" autocomplete="off">
                    @csrf
                    <div class="modal-header px-card border-0">
                        <div class="w-100 d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-0 lh-sm text-1000">Add new</h5>

                            </div><button class="btn p-1 fs--2 text-900" type="button" data-bs-dismiss="modal"
                                aria-label="Close">DISCARD </button>
                        </div>
                    </div>

                    {{-- <div class="modal-body p-card py-0">
                        <div class="mb-1">
                            <label for="reminder_type" class="form-label">{{ __('Type') }}*</label>
                            <select class="form-select" style="width: 100%" name="reminder_type" id="reminder_type">
                                <option @if (old('reminder_type' == 'note')) selected @endif value="{{ 'note' }}">
                                    {{ __('Note') }}</option>
                                <option @if (old('reminder_type' == 'call')) selected @endif value="{{ 'call' }}">
                                    {{ __('Call') }}</option>
                                <option @if (old('reminder_type' == 'meeting')) selected @endif value="{{ 'meeting' }}">
                                    {{ __('Meeting') }}</option>
                            </select>
                        </div>

                        <div class="mb-1">
                            <label for="reminder_relation" class="form-label">{{ __('Related To') }}*</label>
                            <select class=" form-select" style="width: 100%" name="reminder_relation"
                                id="reminder_relation">
                                <option value="">{{ __('Select Relation') }}</option>
                                <option value="{{ 'leads' }}">{{ __('Leads') }}</option>
                            </select>
                        </div>
                        <div class="mb-1" id="leadSelectContainer">
                            <label for="lead_id" class="form-label">{{ __('Sub Relation') }}*</label>
                            <select class=" form-select" style="width: 100%" name="lead_id" id="lead_id">
                                <option value="{{ null }}">{{ __('Select Sub Relation') }}</option>
                                @foreach ($leadAccounts as $leadAccount)
                                    <option value="{{ $leadAccount->id }}">{{ $leadAccount->account_name }}</option>
                                @endforeach
                            </select>
                        </div>
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
                            <label for="note_reminder_start_date" class="form-label">{{ __('Start Date') }}*</label>
                            <input type="datetime-local" class="form-control form-control-sm" name="reminder_start_date"
                                id="note_reminder_start_date" min="{{ now()->format('Y-m-d\TH:i') }}">
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
                                id="bootstrap-wizard-wizard-address"></textarea>
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
                    </div> --}}

                    <div class="modal-body p-card py-0">


                        <x-reminder::form-select name="reminder_type" id="reminder_type" label='Reminder Type*'
                            required>
                            <option @if (old('reminder_type' == 'note')) selected @endif value="{{ 'note' }}">
                                {{ __('Note') }}</option>
                            <option @if (old('reminder_type' == 'call')) selected @endif value="{{ 'call' }}">
                                {{ __('Call') }}</option>
                            <option @if (old('reminder_type' == 'meeting')) selected @endif value="{{ 'meeting' }}">
                                {{ __('Meeting') }}</option>
                        </x-reminder::form-select>

                        <x-reminder::form-select name='reminder_relation' label='Related To*' id="reminder_relation">
                                <option value="">{{ __('Select Relation') }}</option>
                                <option value="{{ 'leads' }}">{{ __('Leads') }}</option>
                            </x-reminder::form-select>
                    <div  id="leadSelectContainer">
                        <x-reminder::form-select name='lead_id' label='Sub Relation*' id="lead_id"
                                required>
                                <option value="{{ null }}">{{ __('Select Sub Relation') }}</option>
                            @foreach ($leadAccounts as $leadAccount)
                                <option value="{{ $leadAccount->id }}">{{ $leadAccount->account_name }}</option>
                            @endforeach
                            </x-reminder::form-select>
                    </div>
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
                    <x-reminder::form-input type="text" value="" label="Title*" name='reminder_title'
                        placeholder='Reminder title' required id="reminder_title" oninput="{{ null }}"/>

                        <x-reminder::dateTime-input label="{{ __('Start date') }}" name="reminder_start_date"
                        value=""  id="reminder_start_date" required/>

                        <x-reminder::dateTime-input label="{{ __('End date') }}" name="reminder_end_date"
                        value=""  id="reminder_end_date" required/>

                    <x-reminder::form-description
                    value="" label="Description"
                    name='description' placeholder='Write  description Here ....' id="description" />
                    <hr>

                    <x-reminder::form-select name='status' label='status*' id="status"
                                required>
                                <option @if (old('status' == 'active')) selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (old('status' == 'inactive')) selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (old('status' == 'draft')) selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </x-reminder::form-select>
                </div>
                    <div class="modal-footer d-flex justify-content-between align-items-center border-0">
                        <button class="btn btn-primary px-4" type="submit">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('dashboard') }}/vendors/fullcalendar/main.min.js"></script>
    {{-- <script src="{{ asset('dashboard') }}/assets/js/calendar.js"></script> --}}
    <script>
        $(document).ready(function() {

            $(document).on('click', '.delete-this-reminder', function(e) {
                e.preventDefault();
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');

                swalWithBootstrapButtons.fire({
                    title: "Are you sure you really want to delete this Reminder?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
                    reverseButtons: true
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
                                    "{{ route('reminders.calendar') }}";
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === swalWithBootstrapButtons.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Reminder  is safe :)",
                            icon: "error"
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
                                <div class="form-group mb-1 col-8">
                                    <label for="phoneInput" class="form-label">{{ __('Contact Phone') }}*</label>
                                    <input type="text" class="form-control" name="phone[]" id="phoneInput" oninput="this.value = this.value.replace(/[^0-9+]/g, '')" placeholder="+2 01xxxxxxxxxx" max="20">
                                </div>
                                <div class="form-group mb-1 col-4">
                                    <x-reminder::remove-button class="remove-phone"  id="removeContactForm" />
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

            $.validator.addMethod("greaterThanNow", function(value, element) {
                var selectedDate = new Date(value);
                var now = new Date();
                return selectedDate > now;
            }, "Please select a date and time after the current moment.");




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



    {{-- calendar script --}}
    <script src="{{ asset('dashboard/assets/js/dayjs.min.js') }}"></script>

    <script>
        (function(factory) {
            typeof define === "function" && define.amd ? define(factory) : factory();
        })(function() {
            "use strict";

            const camelize = (e) => {
                const t = e.replace(/[-_\s.]+(.)?/g, (e, t) =>
                    t ? t.toUpperCase() : ""
                );
                return `${t.substr(0, 1).toLowerCase()}${t.substr(1)}`;
            };
            const getData = (e, t) => {
                try {
                    return JSON.parse(e.dataset[camelize(t)]);
                } catch (o) {
                    return e.dataset[camelize(t)];
                }
            };

            const renderCalendar = (e, t) => {
                const {
                    merge: r
                } = window._,
                    a = r({
                            initialView: "dayGridMonth",
                            editable: !0,
                            direction: document
                                .querySelector("html")
                                .getAttribute("dir"),
                            headerToolbar: {
                                left: "prev,next today",
                                center: "title",
                                right: "dayGridMonth,timeGridWeek,timeGridDay",
                            },
                            buttonText: {
                                month: "Month",
                                week: "Week",
                                day: "Day"
                            },
                            events: events,
                        },
                        t
                    ),
                    n = new window.FullCalendar.Calendar(e, a);
                return (
                    n.render(),
                    document
                    .querySelector(".navbar-vertical-toggle")
                    ?.addEventListener("navbar.vertical.toggle", () =>
                        n.updateSize()
                    ),
                    n
                );
            };
            const fullCalendarInit = () => {
                const {
                    getData: e
                } = window.phoenix.utils;
                document.querySelectorAll("[data-calendar]").forEach((t) => {
                    const r = e(t, "calendar");
                    renderCalendar(t, r);
                });
            };
            const fullCalendar = {
                renderCalendar: renderCalendar,
                fullCalendarInit: fullCalendarInit,
            };

            const {
                dayjs: dayjs
            } = window,
            currentDay = dayjs && dayjs().format("DD"),
                currentMonth = dayjs && dayjs().format("MM"),
                currentYear = dayjs && dayjs().format("YYYY");
            let events = [];

            const getTemplate = (n) =>
                `\n<div  class="modal-header ps-card border-bottom">\n  <div>\n    <h4 class="modal-title text-1000 mb-0">${n.title
        }</h4>\n    ${n.extendedProps.organizer
            ? `<p class="mb-0 fs--1 mt-1">\n        by <a href="#!">${n.extendedProps.organizer}</a>\n      </p>`
            : ""
        }\n  </div>\n  <button type="button" class="btn p-1 fw-bolder" data-bs-dismiss="modal" aria-label="Close">\n    <span class='fas fa-times fs-0'></span>\n  </button>\n\n</div>\n\n<div class="modal-body px-card pb-card pt-1 fs--1">\n  ${n.extendedProps.description
            ? `\n      <div class="mt-3 border-bottom pb-3">\n        <h5 class='mb-0 text-800'>Description</h5>\n        <p class="mb-0 mt-2">\n          ${n.extendedProps.description
                    .split(" ")
                    .slice(0, 30)
                    .join(" ")}\n        </p>\n      </div>\n    `
            : ""
        } \n  <div class="mt-4 ${n.extendedProps.location ? "border-bottom pb-3" : ""
        }">\n    <h5 class='mb-0 text-800'>Date and Time</h5>\n
         <p class="mb-1 mt-2">\n    ${window.dayjs &&
        window.dayjs(n.start).format("dddd, MMMM D, YYYY, h:mm A")
        } \n    ${n.end
            ? `– ${window.dayjs &&
                window
                    .dayjs(n.end)
                    .subtract(1, "day")
                    .format("dddd, MMMM D, YYYY, h:mm A")
                }`
            : ""
        }\n  </p>\n\n  </div>\n  ${n.extendedProps.location
            ? `\n        <div class="mt-4 ">\n          <h5 class='mb-0 text-800'>Location</h5>\n          <p class="mb-0 mt-2">${n.extendedProps.location}</p>\n        </div>\n      `
            : ""
        }\n  ${n.schedules
            ? `\n      <div class="mt-3">\n        <h5 class='mb-0 text-800'>Schedule</h5>\n        <ul class="list-unstyled timeline mt-2 mb-0">\n          ${n.schedules
                    .map((n) => `<li>${n.title}</li>`)
                    .join("")}\n        </ul>\n      </div>\n      `
            : ""
        }\n  </div>\n</div>\n\n<div class="modal-footer d-flex justify-content-end px-card pt-0 border-top-0">\n  <a href=" {{ url('reminders/edit_reminders_on_calendar') }}`+'/'+n._def.publicId+`"  class="btn btn-phoenix-secondary btn-sm">\n    <span class="fas fa-pencil-alt fs--2 mr-2"></span> Edit\n  </a>\n <a href="#" class="btn btn-phoenix-danger btn-sm delete-this-reminder" data-id="${n._def.publicId}" data-url="{{ url('reminders/reminders') }}`+'/'+n._def.publicId+`">\n    <span class="fa-solid fa-trash fs--1 mr-2" data-fa-transform="shrink-2"></span> Delete\n</a>\n  <a href=" {{ url('reminders/reminders') }}`+'/'+n._def.publicId+`" class="btn btn-primary btn-sm">\n    See more details\n    <span class="fas fa-angle-right fs--2 ml-1"></span>\n  </a>\n</div>\n`;
            const appCalendarInit = () => {
                const e = "#addEventForm",
                    t = "#createReminder",
                    a = "#appCalendar",
                    r = ".calendar-title",
                    n = ".calendar-day",
                    o = ".calendar-date",
                    d = "[data-fc-view]",
                    l = "data-event",
                    c = "#eventDetailsModal",
                    i = "#eventDetailsModal .modal-content",
                    u = '#createReminder [name="reminder_start_Date"]',
                    s = '[name="title"]',
                    m = "shown.bs.modal",
                    v = "submit",
                    g = "event",
                    y = "fc-view",
                    p = events.reduce(
                        (e, t) =>
                        t.schedules ? e.concat(t.schedules.concat(t)) : e.concat(t),
                        []
                    );
                (() => {
                    const e = new Date(),
                        t = e.toLocaleString("en-US", {
                            month: "short"
                        }),
                        a = e.getDate(),
                        r = e.getDay(),
                        d = `${a}  ${t},  ${e.getFullYear()}`;
                    document.querySelector(n) &&
                        (document.querySelector(n).textContent = ((e) => [
                            "Sunday",
                            "Monday",
                            "Tuesday",
                            "Wednesday",
                            "Thursday",
                            "Friday",
                            "Saturday",
                        ][e])(r)),
                        document.querySelector(o) &&
                        (document.querySelector(o).textContent = d);
                })();
                const h = (e) => {
                        const {
                            currentViewType: t
                        } = e;
                        if ("timeGridWeek" === t) {
                            const t = e.dateProfile.currentRange.start,
                                a = t.toLocaleString("en-US", {
                                    month: "short"
                                }),
                                n = t.getDate(),
                                o = e.dateProfile.currentRange.end,
                                d = o.toLocaleString("en-US", {
                                    month: "short"
                                }),
                                l = o.getDate();
                            document.querySelector(
                                r
                            ).textContent = `${a} ${n} - ${d} ${l}`;
                        } else document.querySelector(r).textContent = e.viewTitle;
                    },
                    w = document.querySelector(a),
                    f = document.querySelector(e),
                    D = document.querySelector(t),
                    S = document.querySelector(c);
                if (w) {
                    const e = fullCalendar.renderCalendar(w, {
                        headerToolbar: !1,
                        dayMaxEvents: 3,
                        height: 800,
                        stickyHeaderDates: !1,
                        views: {
                            week: {
                                eventLimit: 3
                            }
                        },
                        eventTimeFormat: {
                            hour: "numeric",
                            minute: "2-digit",
                            omitZeroMinute: !0,
                            meridiem: !0,
                        },
                        events: p,
        eventDrop:(info)=>{
            console.log(info.event);
            var start_date =info.event.startStr;
            var end_date =info.event.endStr;
            var reminderId = info.event.id;
            var routeUrl = document.getElementById('updateDateRoute').getAttribute('data-route');

            $.ajax({
                method: "PUT",
                url: routeUrl,
                data: {
                    start_date:start_date,
                    end_date:end_date,
                    reminderId:reminderId,
                },
                headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                success: function (response) {
                    console.log('date Updated');
                }
            });
        },
                        eventClick: (e) => {
                            if (e.event.url){
                                window.open(e.event.url, "_blank"),
                                e.jsEvent.preventDefault();
                            }else {
                                const t = getTemplate(e.event);

                                document.querySelector(i).innerHTML = t;
                                new window.bootstrap.Modal(S).show();
                            }
                            //console.log(e.event._def.publicId);
                        },
                        dateClick(e) {
                            new window.bootstrap.Modal(D).show();
                            document.querySelector(u)._flatpickr.setDate([e.dateStr]);
                        },
                    });
                    h(e.currentData),
                        document.addEventListener("click", (t) => {
                            if (
                                t.target.hasAttribute(l) ||
                                t.target.parentNode.hasAttribute(l)
                            ) {
                                const a = t.target.hasAttribute(l) ?
                                    t.target :
                                    t.target.parentNode;
                                switch (getData(a, g)) {
                                    case "prev":
                                        e.prev(), h(e.currentData);
                                        break;
                                    case "next":
                                        e.next(), h(e.currentData);
                                        break;
                                    default:
                                        e.today(), h(e.currentData);
                                }
                            }
                            if (t.target.hasAttribute("data-fc-view")) {
                                const a = t.target;
                                e.changeView(getData(a, y)),
                                    h(e.currentData),
                                    document.querySelectorAll(d).forEach((e) => {
                                        e === t.target ?
                                            e.classList.add("active-view") :
                                            e.classList.remove("active-view");
                                    });
                            }
                        }),
                        f &&
                        f.addEventListener(v, (t) => {
                            t.preventDefault();
                            const {
                                title: a,
                                startDate: r,
                                endDate: n,
                                label: o,
                                description: d,
                                allDay: l,
                            } = t.target;
                            e.addEvent({
                                    title: a.value,
                                    start: r.value,
                                    end: n.value ? n.value : null,
                                    allDay: l.checked,
                                    className: `text-${o.value}`,
                                    description: d.value,
                                }),
                                t.target.reset(),
                                window.bootstrap.Modal.getInstance(D).hide();
                        }),
                        D &&
                        D.addEventListener(m, ({
                            currentTarget: e
                        }) => {
                            e.querySelector(s)?.focus();
                        });

                    // AJAX request to fetch events
                    var routeUrl = document.getElementById('routeData').getAttribute('data-route');
                    $.ajax({
                        url: routeUrl,
                        method: 'GET',
                        success: function(response) {
                            // Assuming `data` is an array of event objects
                            var eventsData = response.data;
                            eventsData.forEach(function(eventData) {
                                // Add each event using the `addEvent` function
                                e.addEvent({
                                    id: eventData.id,
                                    title: eventData.reminder_title,
                                    start: eventData.reminder_start_date,
                                    end: eventData.reminder_end_date,
                                    description: eventData.description,
                                    className: 'text-danger',
                                });
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            };

            const {
                docReady: docReady
            } = window.phoenix.utils;
            docReady(appCalendarInit);


        });

        //# sourceMappingURL=calendar.js.map
    </script>
@endsection
