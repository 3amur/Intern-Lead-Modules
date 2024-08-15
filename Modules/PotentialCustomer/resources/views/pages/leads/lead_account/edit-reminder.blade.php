@extends('dashboard.layouts.app')
@section('title')
    {{ __('Edit Reminder') }}
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
            <a href="{{ route('lead_account.index') }}">{{ __('Lead Accounts') }}</a>
        </x-potentialcustomer::breadcrumb-item>
        <x-potentialcustomer::breadcrumb-item>
            <a
                href="{{ route('lead_account.show', ['lead_account' => $leadAccount]) }}">{{ __($leadAccount->account_name) }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ __('Edit :type', ['type' => $reminder->reminder_title]) }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

    <div class="container">
        @include('dashboard.layouts.alerts')
        <div class="card my-3">
            <div class="card-header">
                <h5>{{ __('Edit :type', ['type' => $reminder->reminder_title]) }}</h5>
            </div>
            <form
                action="{{ route('lead_account.updateCustomerReminder', ['reminder' => $reminder, 'lead_account' => $leadAccount->id]) }}"
                method="POST" enctype="multipart/form-data" id="reminderForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <x-reminder::form-input type="text" :value="isset($reminder) ? Str::ucfirst($reminder->reminder_type) : old('reminder_type')" label="Reminder Type" name='reminder_type'
                        placeholder='Reminder Type' required id="reminder_type" oninput="{{ null }}" readonly />
                    <input type="text" name="reminder_relation" value="leads" hidden>
                    <input type="text" name="lead_id" value="{{ $leadAccount->id }}" hidden>
                    <hr>
                    @if ($reminder->reminder_type == 'call')
                        <div class="form-title">
                            <h6>{{ __('Call Reminder') }}</h6>
                            <button type="button" id="addContactBtn" class="btn btn-primary btn-sm mb-2 float-end">+
                                {{ __('Add contact') }}</button>
                        </div>
                        <x-potentialcustomer::form-multi-select name='contact_id[]' label='Contact' id="contact_id"
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
                        </x-potentialcustomer::form-multi-select>
                    @endif
                    <div class="mb-4" id="formContainer">

                    </div>
                    <hr>
                    <x-potentialcustomer::form-input type="text" :value="isset($reminder) ? $reminder->reminder_title : old('reminder_title')" label="Reminder Title"
                        name='reminder_title' placeholder='Reminder Title' required id="reminder_title"
                        oninput="{{ null }}" />
                    <div class="mb-1">
                        <label for="reminder_date" class="form-label">{{ __('Date of Reminder') }}*</label>
                        <input type="datetime-local" class="form-control form-control-sm" name="reminder_date"
                            id="reminder_date" min="{{ now()->format('Y-m-d\TH:i') }}"
                            value="{{ $reminder->reminder_date }}">
                    </div>
                    <x-potentialcustomer::form-description
                        value="{{ isset($reminder) ? $reminder->description : old('description') }}" label="Description"
                        name='description' placeholder='Reminder Description ....' id="description" />
                    <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                        <option @if (isset($reminder) && $reminder->status == 'active') selected @endif value="active">
                            {{ __('Active') }}</option>
                        <option @if (isset($reminder) && $reminder->status == 'inactive') selected @endif value="inactive">
                            {{ __('Inactive') }}</option>
                        <option @if (isset($reminder) && $reminder->status == 'draft') selected @endif value="draft">
                            {{ __('Draft') }}</option>
                    </x-potentialcustomer::form-select>
                </div>
                <div class="card-footer  mb-3 mx-2">
                    <button class="btn btn-success float-end mb-3 mx-2" type="submit">{{ __('Edit') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

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
                    reminder_date: {
                        required: true,
                        greaterThanNow: true
                    },
                    description: {
                        maxlength: 2000
                    },
                    status: {
                        required: true,
                    },
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
                    reminder_date: {
                        required: "The reminder date is required.",
                        greaterThanNow: "Please select a date and time after the current moment."
                    },
                    description: {
                        maxlength: "The description must not exceed 2000 characters."
                    },
                    status: {
                        required: "The status is required.",
                    },
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

            // Handle click event on "Add contact" button
            $('#addContactBtn').on('click', function() {
                $('#formContainer').append(`
                <div id="contactForm">
                    <hr>

                    <div class="row">
                        <div class="form-title mb-3 col-10">
                            <h6>{{ __('Contact Form') }}</h6>
                        </div>
                        <div class="col-2 m-0">
                            <x-potentialcustomer::remove-button id="removeContactForm" />
                        </div>
                    </div>
                    <x-potentialcustomer::form-input type="text"  label="Contact Name" name='name[]'
                    placeholder='Contact Name' required id="nameInput" oninput="{{ null }}" />

                    <x-potentialcustomer::form-input type="text"  label="Contact Email" name='email[]'
                    placeholder='contact@example.com' required id="emailInput" oninput="{{ null }}" />

                    <x-potentialcustomer::form-input type="text"  label="Contact Phone" name='phone[]'
                    placeholder='+2 01xxxxxxxxxx' required id="phoneInput" oninput="this.value = this.value.replace(/[^0-9+]/g, '')" />

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

        });
    </script>
@endsection
