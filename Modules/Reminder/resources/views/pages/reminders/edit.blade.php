@extends('dashboard.layouts.app')
@section('title')
    {{ __('Edit Reminder') }}
@endsection
@section('css')
    <style>
        .custom-avatar {
            display: inline-block;
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
        }

        .custom-avatar img {
            border-radius: 50%;
            width: 100%;
            height: 100%;
            transition: opacity 0.25s;
            display: block;
        }

        .custom-avatar .overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.25s;
        }

        .custom-avatar:hover img,
        .custom-avatar:hover .overlay {
            opacity: 1;
        }

        .custom-avatar .icon {
            color: #ffffff;
            font-size: 32px;
        }
    </style>
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
            {{ __('Edit :type', ['type' => $reminder->reminder_title]) }}
        </x-reminder::breadcrumb-item>
    </x-reminder::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        @include('dashboard.layouts.alerts')
        <div class="card my-3">
            <div class="card-header">
                <h5>{{ __('Edit :type', ['type' => $reminder->reminder_title]) }}</h5>
            </div>
            <form action="{{ route('reminders.update', ['reminder' => $reminder]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <x-reminder::form-input type="text" :value="isset($reminder) ? Str::ucfirst($reminder->reminder_type) : old('reminder_type')" label="Type" name='reminder_type'
                        placeholder='Reminder Type' required id="reminder_type" oninput="{{ null }}" readonly />


                    <x-reminder::form-select name='reminder_relation' id="reminder_relation" label='Relation'>
                        <option value="{{ null }}">{{ __('Select Reminder Relation') }}</option>
                        <option @if ($reminder->reminder_relation == 'leads') selected @endif value="{{ 'leads' }}">
                            {{ __('Leads') }}</option>
                    </x-reminder::form-select>
                    @if ($reminder->reminder_relation == 'leads')
                        <div id="leadSelect">
                            <x-reminder::form-select name='lead_id' id="lead_id" label='Sub Relation'>
                                @foreach ($leadAccounts as $leadAccount)
                                    <option @if ($reminder->lead_id == $leadAccount->id) selected @endif
                                        value="{{ $leadAccount->id }}">{{ $leadAccount->account_name }}</option>
                                @endforeach
                            </x-reminder::form-select>
                        </div>
                    @else
                        <div id="leadSelectContainer">
                            <x-reminder::form-select name='lead_id' id="lead_id" label='Sub Relation'>
                                @foreach ($leadAccounts as $leadAccount)
                                    <option value="{{ $leadAccount->id }}">{{ $leadAccount->account_name }}</option>
                                @endforeach
                            </x-reminder::form-select>
                        </div>
                    @endif
                    @if($reminder->reminder_type == 'call')
                    <hr>

                    <div class="form-title">
                        <h6>{{ __('Call Reminder') }}</h6>


                            <x-reminder::form-button label='+ Contact'  id="addContactBtn" class="float-end mb-3"  />

                    </div>
                    <div class="mb-1">
                        <x-reminder::form-multi-select name='contact_id[]' label='Contact' id="contact_id"
                            required>
                            @foreach ($contacts as $contact)
                                {{-- Check if the current $contact is in $reminderContacts --}}
                                @if (in_array($contact->id, $reminderContacts->pluck('id')->toArray()))
                                    <option value="{{ $contact->id }}" selected>{{ $contact->name . ' ' }} -
                                        {{ implode('- ', $contact->phones->pluck('phone')->toArray()) }}</option>
                                @else
                                    <option value="{{ $contact->id }}">{{ $contact->name . ' ' }} -
                                        {{ implode('- ', $contact->phones->pluck('phone')->toArray()) }}</option>
                                @endif
                            @endforeach
                        </x-reminder::form-multi-select>

                    </div>
                    @endif
                    <div id="formContainer">

                    </div>
                    <hr>
                    <x-reminder::form-input type="text" :value="isset($reminder) ? $reminder->reminder_title : old('reminder_title')" label="Title"
                        name='reminder_title' placeholder='Reminder Title' required id="reminder_title"
                        oninput="{{ null }}" />
                    <div class="mb-1">
                        <label for="note_start_reminder_date" class="form-label">{{ __('Start Date') }}*</label>
                        <input type="datetime-local" class="form-control form-control-sm" name="reminder_start_date"
                            id="note_start_reminder_date" min="{{ now()->format('Y-m-d\TH:i') }}"
                            value="{{ $reminder->reminder_start_date }}">
                    </div>
                    <div class="mb-1">
                        <label for="note_end_reminder_date" class="form-label">{{ __('End Date') }}*</label>
                        <input type="datetime-local" class="form-control form-control-sm" name="reminder_end_date"
                            id="note_end_reminder_date" min="{{ now()->format('Y-m-d\TH:i') }}"
                            value="{{ $reminder->reminder_end_date }}">
                    </div>
                    <x-reminder::form-description
                        value="{{ isset($reminder) ? $reminder->description : old('description') }}" label="Description"
                        name='description' placeholder='Reminder Description ....' id="description"/>
                    <div class="mb-3">
                        <label for="reminder_type_id" class="form-label">{{ __('Status') }}*</label>
                        <select class="form-select form-select-sm" name="status" id="status">
                            <option @if (isset($model) && $model->status == 'active') selected @endif value="active">
                                {{ __('Active') }}</option>
                            <option @if (isset($model) && $model->status == 'inactive') selected @endif value="inactive">
                                {{ __('Inactive') }}</option>
                            <option @if (isset($model) && $model->status == 'draft') selected @endif value="draft">
                                {{ __('Draft') }}</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    <x-reminder::form-submit-button id="submitBtn"  label='Confirm'/>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#leadSelectContainer').hide();


            $('#reminder_relation').change(function() {
                if ($(this).val() == '') {
                    $('#leadSelectContainer').hide();
                    $('#leadSelect').hide();

                } else {
                    $('#leadSelectContainer').show();
                    $('#leadSelect').show();

                }
            });
            $('#reminderForm').validate({
                rules: {
                    reminder_type: {
                        required: true,
                    },
                    reminder_relation: {
                        required: true,
                    },
                    lead_id: {
                        required: true,
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
                    }
                },
                messages: {
                    reminder_type: {
                        required: "The reminder type is required.",
                    },
                    reminder_relation: {
                        required: "The reminder relation is required.",
                    },
                    lead_id: {
                        required: "The lead ID is required.",
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
                var startDate = $('#note_reminder_start_date').val();
                console.log(value,startDate);
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
            $('#addContactBtn').on('click',  function() {
                $('#formContainer').append(`
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
                                <div class="form-group mb-1 col-10">
                                    <x-reminder::form-input type="text" :value="old('phone[]')" label="Contact Phone"
                                    name='phone[]' placeholder='01xxxxxxxxxx' id="phoneInput"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />
                                    </div>
                                <div class="form-group mb-1 col-2">
                                    <x-reminder::remove-button class="remove-phone"  id="removeContactForm" />
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>`);
            });
            // Handle click event on "Remove contact" button
            $('#formContainer').on('click', '#removeContactForm', function() {
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
@endsection
