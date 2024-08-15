@extends('dashboard.layouts.app')
@section('title')
    {{ __('Edit Contact') }}
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
            <a href="{{ route('home.index') }}">{{ __('Home') }}</a>
        </x-reminder::breadcrumb-item>

        <x-reminder::breadcrumb-item>
            <a href="{{ route('contacts.index') }}">{{ __('Contacts') }}</a>
        </x-reminder::breadcrumb-item>

        <x-reminder::breadcrumb-item>
            {{ __('Edit :type', ['type' => $contact->name]) }}
        </x-reminder::breadcrumb-item>
    </x-reminder::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        @include('dashboard.layouts.alerts')
        <div class="card my-3">
            <div class="card-header">
                <h5>{{ __('Edit :type', ['type' => $contact->name]) }}</h5>
            </div>
            <form action="{{ route('contacts.update', ['contact' => $contact]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf @method ('PUT')
                <div class="card-body">

                    <x-reminder::form-input type="text" :value="$contact->name" label="Contact Name" name='name'
                        placeholder='contact name' id="nameInput" oninput="{{ null }}" required />

                    <x-reminder::form-input type="text" :value="$contact->email" label="Contact Email" name='email'
                        placeholder="contact@example.com" id="emailInput" oninput="{{ null }}"  />

                    <div id="phones">
                        @foreach ($contact->phones as $key=>$phone)
                            <div class="row">

                                <div class="col-10">
                                    <x-reminder::form-input type="text" :value="$phone->phone" label="Contact Phone"
                                        name='phone[]' placeholder="01xxxxxxxxxx" id="phoneInput"
                                        oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />
                                </div>


                                <div class="col-2">
                                    @if ($key == 0)
                                    <x-reminder::remove-button class="remove-phone" hidden/>
                                    @else
                                    <x-reminder::remove-button class="remove-phone"/>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button"
                        class="btn btn-primary btn-sm mb-3 add-phone">{{ __('Add Mobile Number') }}</button>

                        <x-reminder::form-select name='status' id="status" label="status" required>
                            <option @if (isset($contact) && $contact->status == 'active') selected @endif value="active">
                                {{ __('Active') }}</option>
                            <option @if (isset($contact) && $contact->status == 'inactive') selected @endif value="inactive">
                                {{ __('Inactive') }}</option>
                            <option @if (isset($contact) && $contact->status == 'draft') selected @endif value="draft">
                                {{ __('Draft') }}</option>
                        </x-reminder::form-select>


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
            // Add phone row
            $(".add-phone").on("click", function() {
                var newRow = $(`<div class="row">

                    <div class="col-10">
                        <x-reminder::form-input type="text" :value="old('phone[]')" label="Contact Phone"
                                        name='phone[]' placeholder="01xxxxxxxxxx" id="phoneInput"
                                        oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />
                                </div>
                                <div class="col-2">
                                    <x-reminder::remove-button class="remove-phone"  id="removeContactForm" />
                                </div>
                            </div>`);
                newRow.find("input").val(""); // Clear input value in the new row
                $("#phones").append(newRow);
            });

            // Remove phone row
            $("#phones").on("click", ".remove-phone", function() {
                $(this).closest(".row").remove();
            });

            // Validate the form using jQuery Validation Plugin
            $("#contactForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 100
                    },
                    email: {
                        email: true,
                        maxlength: 100
                    },
                    'phone[]': {
                        required: true,
                        maxlength: 20,
                        minlength:8,
                        regex: /^\+\d{1,3}\s?\d{9,}$/
                    }
                },
                messages: {
                    name: {
                        required: "Please enter the contact name",
                        maxlength: "Name must not exceed 100 characters"
                    },
                    email: {
                        email: "Please enter a valid email address",
                        maxlength: "Email must not exceed 100 characters"
                    },
                    'phone[]': {
                        required: "Please enter a valid phone number",
                        maxlength: "Phone number must not exceed 20 characters",
                        minlength: "Phone number must not less than 8 characters",

                        regex: "Please enter a valid phone number format"
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
        });
    </script>
@endsection
