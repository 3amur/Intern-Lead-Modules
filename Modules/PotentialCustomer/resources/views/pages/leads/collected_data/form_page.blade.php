<!DOCTYPE html>
<html lang="en-US" dir="ltr">
<!-- Mirrored from prium.github.io/phoenix/v1.6.0/modules/forms/wizard.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Dec 2022 09:37:52 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title> {{ __('Family Memebers Form') }}</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('dashboard') }}/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('dashboard') }}/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('dashboard') }}/assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('dashboard') }}/assets/img/favicons/favicon.ico">
    <meta name="msapplication-TileImage" content="{{ asset('dashboard') }}/assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff">
    <script src="{{ asset('dashboard') }}/assets/js/config.js"></script>

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link href="{{ asset('dashboard') }}/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <link href="{{ asset('dashboard') }}/vendors/dropzone/dropzone.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link href="{{ asset('dashboard') }}/assets/css/theme.min.css" type="text/css" rel="stylesheet" id="style-default">
    <link href="{{ asset('dashboard') }}/assets/css/user.min.css" type="text/css" rel="stylesheet"
        id="user-style-default">

    <style>
        .error {
            color: red;
        }
    </style>


</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->

    <main class="main" id="top">
        <div class="container-fluid px-0 w-75">
            <div class="content">
                @include('dashboard.layouts.alerts')
                <div class="card  border border-300 my-8">
                    <div class="card-header p-4 border border-300 bg-soft">
                        <h4>{{ __('Collect') . ' ' . $customerName . ' ' . __('Data') }}</h4>
                    </div>
                    <form method="POST" action="{{ route('collected_customer_data.storeFamilyData') }}"
                        enctype="multipart/form-data" id='collectedDataForm'>
                        @csrf
                        <div class="card-body">
                            <h6 class="card-title">Head Member Data</h6>
                            <hr>
                            <input type="text" name="potential_account_id" value="{{ $customerId }}" hidden>
                            <input type="text" name="link_id" value="{{ $linkId }}" hidden>

                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <div class="mb-2"><label class="form-label text-900"
                                            for="head_nameInput">Name</label><input
                                            class="form-control @error('head_name') is-invalid @enderror" type="text"
                                            name="head_name" placeholder="Your full name" id="head_nameInput"
                                            value="{{ old('head_name') }}" required />
                                        @error('head_name')
                                            <span class="is-invalid-feedback text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2"><label class="form-label text-900"
                                            for="head_phoneInput">Phone</label><input
                                            class="form-control @error('head_phone') is-invalid @enderror"
                                            type="text" name="head_phone" placeholder="+201xxxxxxxxx"
                                            oninput="this.value = this.value.replace(/[^0-9+]/g, '')"
                                            id="head_phoneInput" value="{{ old('head_phone') }}" required />
                                        @error('head_phone')
                                            <span class="is-invalid-feedback text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <input class="form-check-input" id="flexRadioDefault2" type="radio"
                                        name="head_national_id_checked" checked />
                                    <label class="form-check-label"
                                        for="flexRadioDefault2">{{ __('National Id') }}</label>
                                    <input class="form-check-input" id="flexRadioDefault1" type="radio"
                                        name="head_national_id_checked" />
                                    <label class="form-check-label"
                                        for="flexRadioDefault1">{{ __('Passport Id') }}</label>
                                </div>


                            </div>
                            <div class="row g-3 mb-3">
                                <div class="head_national_id_container col-sm-6">

                                    <div class=" head_national_id_input">
                                        <div class="mb-2 mb-sm-0"><label class="form-label text-900"
                                                for="head_nationalIdInput">National Id</label>
                                            <input class="form-control @error('national_id') is-invalid @enderror"
                                                type="text" name="head_national_id" placeholder="National Id"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                maxlength="14" minlength="14" id="head_nationalIdInput"
                                                value="{{ old('head_national_id') }}" required />
                                            @error('head_national_id')
                                                <span class="is-invalid-feedback text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2"><label class="form-label" for="head_datepickerInput">Date of
                                            Birth</label>
                                        <input class="form-control  @error('head_birth_date') is-invalid @enderror"
                                            type="date" placeholder="d/m/y" name="head_birth_date"
                                            max="{{ now()->subYears(16)->format('Y-m-d') }}"
                                            value="{{ old('head_birth_date') }}" id="head_datepickerInput"
                                            required />
                                        @error('head_birth_date')
                                            <span class="is-invalid-feedback text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="fileInput">
                                        Personal Image </label>
                                    <div class="">
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                                            <span class="ms-1" data-feather="alert-octagon"
                                                style="height:12.8px;width:12.8px;"></span>
                                            <span class="badge-label">Upload your Personal Photo </span>

                                        </span>
                                    </div>
                                    <input class="form-control @error('head_personal_image') is-invalid @enderror"
                                        type="file" id="fileInput" name="head_personal_image" required>
                                    @error('head_personal_image')
                                        <span class="is-invalid-feedback text-danger" role="alert">
                                            <small>{{ $message }}</small>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-6 head_national_id_card_container">
                                    <div class="head_national_id_card_input">
                                        <label class="form-label" for="headNationalIdCardInput">National Id Card
                                        </label>
                                        <div>
                                            <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                                                <span class="ms-1" data-feather="alert-octagon"
                                                    style="height:12.8px;width:12.8px;"></span>
                                                <span class="badge-label">Upload 2 photos For Front and Back for id
                                                    card
                                                </span>

                                            </span>
                                        </div>
                                        <input
                                            class="form-control  @error('head_national_id_card[]') is-invalid @enderror"
                                            type="file" id="headNationalIdCardInput"
                                            name="head_national_id_card[]" multiple required>
                                        @error('head_national_id_card[]')
                                            <span class="is-invalid-feedback text-danger" role="alert">
                                                <small>{{ $message }}</small>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if ($hasFamily == true && ($wifeHusband == true || $hasParent == true || $hasChildren == true))
                                <div id="familyMembersDiv">
                                    <hr>

                                    <h5 class="card-title">
                                        Family Members
                                    </h5>


                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-success btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-plus"></i>{{ __(' Family Member') }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if ($wifeHusband)
                                            <li><a class="dropdown-item relationship" data-relation="wife_husband"
                                                    href="#">{{ 'Wife/Husband' }}</a></li>
                                        @endif
                                        @if ($hasParent)
                                            <li><a class="dropdown-item relationship" data-relation="father"
                                                    href="#">{{ 'Father' }}</a></li>
                                            <li><a class="dropdown-item relationship" data-relation="mother"
                                                    href="#">{{ 'Mother' }}</a></li>
                                        @endif
                                        @if ($hasChildren == true)
                                            <li><a class="dropdown-item relationship" data-relation="children"
                                                    href="#">{{ 'Children' }}</a></li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer text-muted pb-6 border border-300 bg-soft">
                            <button type="submit" class="btn btn-success btn-sm submitBtn float-end">Submit</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </main>
    <script src="{{ asset('dashboard/vendors/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize variables
            var index = 0;
            var maxHusbandWifeForms = 4;
            var maxFatherMotherForms = 1;
            var maxChildrenForms = parseInt("{{ $childrenCount }}");
            var hasChildren = '{{ $hasChildren }}';
            var childrenCount = parseInt("{{ $childrenCount }}");
            // Counter variables
            var currentHusbandWifeForms = 0;
            var currentFatherForms = 0;
            var currentMotherForms = 0;
            var currentChildrenForms = 0;

            // Event handler for relationship click
            $(".relationship").click(handleRelationshipClick);

            // Event delegation for birth date change
            $('#familyMembersDiv').on('change', 'input[name^="birth_date[]"]', handleBirthDateChange);

            // Event delegation for remove button click
            $('#familyMembersDiv').on('click', '.remove-button', handleRemoveButtonClick);

            // Function to handle relationship click
            function handleRelationshipClick(e) {
                e.preventDefault();
                var relationValue = $(this).data('relation');
                var $listItem = $(this).closest('li');

                if (canAppendForm(relationValue)) {
                    appendFamilyMember(getRelationshipTitle(relationValue), relationValue);
                    updateFormCount(relationValue);

                    if (relationValue == 'children') {
                        var dateInput = $('input[name="relationship[]"]').closest('form').find('.date-input');
                        console.log(dateInput);
                        var currentDate = new Date().toISOString().split('T')[0];

                        // Use each to iterate over each date input
                        dateInput.each(function() {
                            $(this).prop({
                                max: currentDate,
                            });
                        });
                    }
                } else {
                    disableListItem($listItem);
                }
            }

            // Function to handle birth date change
            function handleBirthDateChange() {
                var birthDate = $(this).val();
                var age = calculateAge(birthDate);
                var nationalIdCardInput = $(this).closest('.mb-3').find('input[name^="national_id_card_"]');
                var warningMessage = $(this).closest('.family-member').find('.warning-message');
                var warningMessageLess16 = $(this).closest('.family-member').find('.warning-message-less16');

                updateNationalIdCardInput(age, nationalIdCardInput, warningMessage, warningMessageLess16);
            }

            // Function to handle remove button click
            function handleRemoveButtonClick() {
                var $familyMember = $(this).closest('.family-member');
                var relationValue = $familyMember.find('input[name^="relationship"]').val();

                $familyMember.remove();
                updateFormCount(relationValue, true);

                if (relationValue === 'children') {
                    var $childrenListItem = $('.relationship[data-relation="children"]').closest('li');
                    enableListItem($childrenListItem);
                } else if (relationValue === 'wife_husband') {
                    var $wifeListItem = $('.relationship[data-relation="wife_husband"]').closest('li');
                    if (currentHusbandWifeForms < maxHusbandWifeForms) {
                        enableListItem($wifeListItem);
                    }
                } else if (relationValue === 'father') {
                    var $fatherListItem = $('.relationship[data-relation="father"]').closest('li');
                    enableListItem($fatherListItem);
                } else if (relationValue === 'mother') {
                    var $motherListItem = $('.relationship[data-relation="mother"]').closest('li');
                    enableListItem($motherListItem);
                }
            }


            // Function to enable the corresponding list item
            function enableListItem($listItem) {
                $listItem.removeClass('disabled');
                $listItem.find('a').attr('href', '#').css('pointer-events', 'auto');
            }


            // Function to check if a form can be appended based on relationship type and count condition
            function canAppendForm(relationValue) {
                if (relationValue === 'children') {
                    if (hasChildren === '1' && childrenCount === 0) {
                        return true;
                    }
                }

                return (
                    (relationValue === 'wife_husband' && currentHusbandWifeForms < maxHusbandWifeForms) ||
                    (relationValue === 'children' && currentChildrenForms < maxChildrenForms) ||
                    (relationValue === 'father' && currentFatherForms < maxFatherMotherForms) ||
                    (relationValue === 'mother' && currentMotherForms < maxFatherMotherForms)
                );
            }


            // Function to append a family member form
            function appendFamilyMember(title, relationship) {
                var familyMemberTemplate = getFamilyMemberTemplate(title, relationship);
                $('#familyMembersDiv').append(familyMemberTemplate);
                index++;
            }

            // Function to update the form count after appending or removing
            function updateFormCount(relationValue, removed = false) {
                if (removed) {
                    if (relationValue === 'wife_husband') {
                        currentHusbandWifeForms--;
                    } else if (relationValue === 'children') {
                        currentChildrenForms--;
                    } else if (relationValue === 'father') {
                        currentFatherForms--;
                    } else if (relationValue === 'mother') {
                        currentMotherForms--;
                    }
                } else {
                    if (relationValue === 'wife_husband') {
                        currentHusbandWifeForms++;
                    } else if (relationValue === 'children') {
                        currentChildrenForms++;
                    } else if (relationValue === 'father') {
                        currentFatherForms++;
                    } else if (relationValue === 'mother') {
                        currentMotherForms++;
                    }
                }
            }

            // Function to disable the corresponding list item
            function disableListItem($listItem) {
                $listItem.addClass('disabled');
                $listItem.find('a').removeAttr('href').css('pointer-events', 'none');
            }

            // Function to update the national ID card input based on age
            function updateNationalIdCardInput(age, nationalIdCardInput, warningMessage, warningMessageLess16) {
                if (age < 16) {
                    warningMessage.hide();
                    warningMessageLess16.show();
                    nationalIdCardInput.val('');
                    nationalIdCardInput.removeAttr('multiple');
                } else {
                    warningMessageLess16.hide();
                    warningMessage.show();
                    nationalIdCardInput.val('');
                    nationalIdCardInput.attr('multiple', 'multiple');
                }
            }

            // Function to get the title for the given relationship
            function getRelationshipTitle(relationship) {
                switch (relationship) {
                    case 'wife_husband':
                        return 'Wife/Husband';
                    case 'father':
                        return 'Father';
                    case 'mother':
                        return 'Mother';
                    case 'children':
                        return 'Children';
                    default:
                        return '';
                }
            }

            // Function to calculate age based on birthdate
            function calculateAge(birthdate) {
                var today = new Date();
                var birthDate = new Date(birthdate);
                var age = today.getFullYear() - birthDate.getFullYear();
                var monthDiff = today.getMonth() - birthDate.getMonth();

                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }

                return age;
            }

            // Function to generate the HTML template for a family member
            function getFamilyMemberTemplate(title, relationship) {
                return `
                        <div class="family-member ${title} mb-4">
                            <hr>
                            <h6>${title}</h6>
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label class="form-label text-900" for="nameInput">Name</label>
                                        <input class="form-control" type="text" name="name[]" minlength="4" maxlength="100"
                                            placeholder="John Smith" required/>
                                            @error('name[]')
                                                <span class="is-invalid-feedback text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label class="form-label text-900" for="phoneInput">Phone</label>
                                        <input minlength="11" maxlength="15" class="form-control" type="text" name="phone[]"
                                            placeholder="+201xxxxxxxxx" required
                                            oninput="this.value = this.value.replace(/[^0-9+]/g, '');"/>
                                            @error('phone[]')
                                                <span class="is-invalid-feedback text-danger" role="alert">
                                                    <small>{{ $message }}</small>
                                                </span>
                                            @enderror
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div>
                                    <input class="form-check-input nationalIdRadio" id="flexRadioDefault2${index}"  type="radio" name="national_id_checked${index}" checked />
                                        <label class="form-check-label" for="flexRadioDefault2${index}">{{ __('National Id') }}</label>

                                        <input class="form-check-input passportIdRadio" id="flexRadioDefault1${index}"  type="radio" name="national_id_checked${index}" />
                                        <label class="form-check-label" for="flexRadioDefault1${index}">{{ __('Passport Id') }}</label>
                                    </div>
                                </div>
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6 ">
                                    <div class="mb-2 mb-sm-0 national-id-input-group">
                                        <label class="form-label text-900" for="nationalIdInput">National Id</label>
                                        <input class="form-control national-id-input"  type="text" name="national_id[]"
                                            placeholder="National Id" minlength="14" maxlength="14" required
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-2">
                                        <label class="form-label" for="datepickerInput">Date of Birth</label>
                                        <input class="form-control date-input" type="date" name="birth_date[]" max="{{ now()->subYears(16)->format('Y-m-d') }}"  required/>
                                    </div>
                                </div>

                                <input type="text" name="relationship[]" value="${relationship}" hidden>
                            </div>
                            <div class = "row">
                                    <div class="mb-3 col-6">
                                        <label class="form-label" for="ImageInput">Upload Personal Photo</label>
                                        <div class="">
                                                        <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                                                            <span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span>

                                                            <span class="badge-label">Upload your Personal Photo </span>
                                                        </span>
                                                    </div>
                                        <input class="form-control" id="ImageInput" name="personal_image[]" type="file" required/>
                                    </div>
                                    <div class="mb-3 col-6 nationalId-card-group">
                                        <label class="form-label" for="nationalIdCardInput">Upload
                                            National Id Card </label>
                                            <div class="warning-message">
                                                        <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                                                            <span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span>

                                                            <span class="badge-label">Upload 2 photos For Front and Back for id card </span>
                                                        </span>
                                            </div>
                                            <div class="warning-message-less16" style="display:none;">
                                                <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                                                    <span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span>

                                                    <span class="badge-label">this age is less than 16 years. please Upload 1 photo of Birth certificate or passport for id number </span>
                                                </span>
                                            </div>
                                            <input class="form-control national_id_card_input" type="file" id="nationalIdCardInput"
                                            name="national_id_card_${index}[]" multiple required>
                                    </div>
                                </div>
                            <button type="button" class="btn btn-danger remove-button"><i class="fa-solid fa-trash fa-sm" style="color: #ffffff;"></i></button>
                        </div>`;
            }

            $(document).on('change', '.passportIdRadio', function() {
                var nationalIdInput = $(this).closest('.family-member').find('.national-id-input-group');
                nationalIdInput.empty();
                var nationalIdGroup = $(this).closest('.family-member').find('.national-id-input-group');
                nationalIdGroup.append(`
                <label class="form-label text-900" for="passportIdInput">Passport Id</label>

                <input class="form-control passport-id-input" type="text" name="passport_id[]"
                                   placeholder="Passport Id" minlength="7" maxlength="20" required />
                                   @error('passport_id[]')
                                    <span class="is-invalid-feedback text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                `);

                var nationalIdCardInput = $(this).closest('.family-member').find(
                    '.national_id_card_input,.warning-message');
                nationalIdCardInput.remove();
                // Append warning message and Passport Id Card input field inside nationalId-card-group
                var nationalIdCardGroup = $(this).closest('.family-member').find('.nationalId-card-group');
                var warningMessage = $(this).closest('.family-member').find('.warning-message');
                var warningMessageLess16 = $(this).closest('.family-member').find(
                    '.warning-message-less16');
                if (warningMessage || warningMessageLess16) {
                    warningMessage.hide();
                    warningMessageLess16.hide()
                }
                nationalIdCardGroup.empty();
                nationalIdCardGroup.append(`
                <label class="form-label" for="passportIdCardInput">Upload passport Id Card </label>
                    <div class="warning-message">
                        <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                            <span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span>
                            <span class="badge-label">Upload photos of Your Passport </span>
                        </span>
                    </div>
                    <input class="form-control passport_id_card_input" type="file" id="nationalIdCardInput"
                        name="national_id_card_${index}[]" required>
                `);
            });


            $(document).on('change', '.nationalIdRadio', function() {
                var passportIdInput = $(this).closest('.family-member').find('.national-id-input-group')
                passportIdInput.empty()
                var nationalIdGroup = $(this).closest('.family-member').find('.national-id-input-group');
                nationalIdGroup.append(`
                <label class="form-label text-900" for="nationalIdInput">National Id</label>

                <input class="form-control national-id-input" type="text" name="national_id[]"
                                   placeholder="National Id" minlength="14" maxlength="14" required
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"/>
                                   @error('national_id[]')
                                    <span class="is-invalid-feedback text-danger" role="alert">
                                        <small>{{ $message }}</small>
                                    </span>
                                @enderror
                `);

                var passportIdCardInput = $(this).closest('.family-member').find(
                    '.passport_id_card_input,.warning-message');
                passportIdCardInput.remove();

                $(this).closest('.nationalId-card-group').append(`
                <div class="warning-message">
                                            <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                                                <span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span>

                                                <span class="badge-label">Upload 2 photos For Front and Back for id card </span>
                                            </span>
                                        </div>
                            <input class="form-control national_id_card_input" type="file" id="nationalIdCardInput"
                                name="national_id_card_${index}[]" multiple required>
                `)





                // Append warning message and Passport Id Card input field inside nationalId-card-group
                var nationalIdCardGroup = $(this).closest('.family-member').find('.nationalId-card-group');
                var warningMessage = $(this).closest('.family-member').find('.warning-message');
                var warningMessageLess16 = $(this).closest('.family-member').find(
                    '.warning-message-less16');
                if (warningMessage || warningMessageLess16) {
                    warningMessage.hide();
                    warningMessageLess16.hide()
                }
                nationalIdCardGroup.empty();
                nationalIdCardGroup.append(`
                <label class="form-label" for="nationalIdCardInput">Upload
                                            National Id Card </label>
                <div class="warning-message">
                                            <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                                                <span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span>

                                                <span class="badge-label">Upload 2 photos For Front and Back for id card </span>
                                            </span>
                                        </div>
                            <input class="form-control national_id_card_input" type="file" id="nationalIdCardInput"
                                name="national_id_card_${index}[]" multiple required>
                `)
            });



            $(document).on('change', '.national_id_card_input', function() {
                var maxFileCount = 2;
                if (this.files.length !== maxFileCount) {
                    Swal.fire({
                        icon: "error",
                        title: 'Please select exactly 2 files.',
                    });
                    $(this).val('');
                }
            });




            $('#flexRadioDefault1').on('change', function() {
                var passportRadio = $(this).val();
                passportRadio = 'passport_id';
                $('.head_national_id_input, .head_national_id_card_input').remove();

                $('.head_national_id_container').append(`
                    <div class="head_passport_id_input">
                        <div class="mb-2 mb-sm-0">
                            <label class="form-label text-900" for="headPassportIdInput">Passport Id</label>
                            <input class="form-control @error('head_passport_id') is-invalid @enderror"
                                type="text" name="head_passport_id" placeholder="Passport Id"
                                maxlength="20" minlength="7"
                                id="headPassportIdInput" value="{{ old('head_passport_id') }}"
                                required />
                            @error('head_passport_id')
                                <span class="is-invalid-feedback text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                `);

                $('.head_national_id_card_container').append(`
                    <div class="passport_id_card_input">
                        <label class="form-label" for="headPassportIdCardInput">Passport Id Card </label>
                        <div>
                            <span class="badge badge-phoenix fs--2 badge-phoenix-warning  mb-2">
                                <span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span>
                                <span class="badge-label">Upload photos of Your Passport</span>
                            </span>
                        </div>
                        <input class="form-control @error('head_national_id_card[]') is-invalid @enderror"
                            type="file" id="headPassportIdCardInput" name="head_national_id_card[]"
                            required>
                        @error('head_national_id_card[]')
                            <span class="is-invalid-feedback text-danger" role="alert">
                                <small>{{ $message }}</small>
                            </span>
                        @enderror
                    </div>
                `);
            });

            $('#flexRadioDefault2').on('change', function() {
                var passportRadio = $(this).val();
                nationalIdRadio = 'national_id';
                $('.head_passport_id_input, .passport_id_card_input').remove();

                $('.head_national_id_container').append(`
                    <div class="head_national_id_input">
                        <div class="mb-2 mb-sm-0">
                            <label class="form-label text-900" for="head_nationalIdInput">National Id</label>
                            <input class="form-control @error('national_id') is-invalid @enderror"
                                type="text" name="head_national_id" placeholder="National Id"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" maxlength="14" minlength="14"
                                id="head_nationalIdInput" value="{{ old('head_national_id') }}"
                                required />
                            @error('head_national_id')
                                <span class="is-invalid-feedback text-danger" role="alert">
                                    <small>{{ $message }}</small>
                                </span>
                            @enderror
                        </div>
                    </div>
                `);

                $('.head_national_id_card_container').append(`
                <div class="head_national_id_card_input">
                    <label class="form-label" for="headNationalIdCardInput">National Id Card </label>
                    <div>
                        <span class="badge badge-phoenix fs--2 badge-phoenix-warning mb-2">
                            <span class="ms-1" data-feather="alert-octagon" style="height:12.8px;width:12.8px;"></span>
                            <span class="badge-label">Upload 2 photos For Front and Back for id card</span>
                        </span>
                    </div>
                    <input class="form-control  @error('head_national_id_card[]') is-invalid @enderror"
                        type="file" id="headNationalIdCardInput" name="head_national_id_card[]"
                        multiple  required>
                    @error('head_national_id_card[]')
                        <span class="is-invalid-feedback text-danger" role="alert">
                            <small>{{ $message }}</small>
                        </span>
                    @enderror
                </div>
                `);
            });

            $(document).on('change', '#headNationalIdCardInput', function() {
                var maxFileCount = 2;
                if (this.files.length !== maxFileCount) {
                    Swal.fire({
                        icon: "error",
                        title: 'Please select exactly 2 files.',
                    });
                    $(this).val('');
                }
            });


        });
    </script>

<script>
    $(document).ready(function() {
        // Add custom validation method for image MIME types
        $.validator.addMethod('accept', function(value, element, param) {
            // Split MIME types
            var typeArray = param.split(',');
            // Check if the input value matches any of the allowed MIME types
            return this.optional(element) || ($.inArray(element.files[0].type, typeArray) !== -1);
        }, $.validator.format('Please upload a valid image file (jpg, jpeg, png, gif).'));

        $('#collectedDataForm').validate({
            errorPlacement: function(error, element) {
                console.log(element);
            element.parent().addClass('has-error has-danger')
            error.addClass('help-block').insertAfter(element)
        },
        highlight: function(element) {
            $(element).parent().addClass('has-error has-danger')
        },
        unhighlight: function(element) {
            $(element).parent().removeClass('has-error has-danger');
        },
        success: function(element) {
            $(element).parent().removeClass('has-error has-danger');
        },
            rules: {
                head_name: {
                    required: true,
                    minlength: 4,
                    maxlength: 100,
                },
                head_phone: {
                    required: true,
                    minlength: 11,
                    maxlength: 15,
                },
                head_birth_date: {
                    required: true,
                    date: true,
                },
                head_passport_id: {
                    required: true,
                    minlength: 7,
                    maxlength: 20
                },
                head_national_id: {
                    required: true,
                    digits: true,
                    minlength: 14,
                    maxlength: 14
                },
                head_personal_image: {
                    required: true,
                    accept: "image/jpeg,image/png,image/gif" // Specify allowed image MIME types
                },
                'head_national_id_card[]': {
                    required: true,
                    accept: "image/jpeg,image/png,image/gif" // Specify allowed image MIME types
                },
                'name[]': {
                    required: true,
                    minlength: 4,
                    maxlength: 100,
                },
                'phone[]': {
                    required: true,
                    minlength: 11,
                    maxlength: 15,
                },
                'birth_date[]': {
                    required: true,
                    date: true,
                },
                'passport_id[]': {
                    required: true,
                    minlength: 7,
                    maxlength: 20
                },
                'national_id[]': {
                    required: true,
                    digits: true,
                    minlength: 14,
                    maxlength: 14
                },
                'personal_image[]': {
                    required: true,
                    accept: "image/jpeg,image/png,image/gif" // Specify allowed image MIME types
                },
                'national_id_card_${index}[]': {
                    required: true,
                    accept: "image/jpeg,image/png,image/gif" // Specify allowed image MIME types
                }
            },

            messages: {
                head_name: {
                    required: 'name is required',
                    minlength: 'name must be at least 4 characters long',
                    maxlength: 'name must be less than 100 characters long',
                },
                head_phone: {
                    required: 'phone is required',
                    minlength: 'phone must be at least 11 characters long',
                    maxlength: 'phone must be less than 15 characters long',
                },
                head_birth_date: {
                    required: 'Date of birth is required',
                    date: 'this field must be a date',
                },
                head_national_id: {
                    required: 'This field is required',
                    digits: 'Please enter only digits',
                    minlength: 'National ID must be at least 14 characters long',
                    maxlength: 'National ID must be less than 14 characters long'
                },
                head_passport_id: {
                    required: 'This field is required',
                    minlength: 'Passport ID must be at least 7 characters long',
                    maxlength: 'Passport ID must be less than 20 characters long'
                },
                head_personal_image: {
                    required: 'Please upload a personal image.',
                    accept: 'Please upload a valid image file (jpg, jpeg, png, gif).'
                },
                'head_national_id_card[]': {
                    required: "Please upload a national ID card.",
                    accept: 'Please upload a valid image file (jpg, jpeg, png, gif).'
                },
                'name[]': {
                    required: 'name is required',
                    minlength: 'name must be at least 4 characters long',
                    maxlength: 'name must be less than 100 characters long',
                },
                'phone[]': {
                    required: 'phone is required',
                    minlength: 'phone must be at least 11 characters long',
                    maxlength: 'phone must be less than 15 characters long',
                },
                'birth_date[]': {
                    required: 'Date of birth is required',
                    date: 'this field must be a date',
                },
                'national_id[]': {
                    required: 'This field is required',
                    digits: 'Please enter only digits',
                    minlength: 'National ID must be at least 14 characters long',
                    maxlength: 'National ID must be less than 14 characters long'
                },
                'passport_id[]': {
                    required: 'This field is required',
                    minlength: 'Passport ID must be at least 7 characters long',
                    maxlength: 'Passport ID must be less than 20 characters long'
                },
                'personal_image[]': {
                    required: "Please upload a personal image.",
                    accept: 'Please upload a valid image file (jpg, jpeg, png, gif).'
                },
                'national_id_card_${index}[]': {
                    required: "Please upload a national ID card.",
                    accept: 'Please upload a valid image file (jpg, jpeg, png, gif).'
                }

            },
            errorElement: "span",
            errorClass: "text-danger fs--1"
        });

        $('#head_phoneInput').on('input', function() {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });

        $('#head_nationalIdInput').on('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    });
    </script>


    <script src="{{ asset('dashboard') }}/vendors/popper/popper.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/fontawesome/all.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/lodash/lodash.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/feather-icons/feather.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/dropzone/dropzone.min.js"></script>
    <script src="{{ asset('dashboard') }}/vendors/bootstrap/bootstrap.min.js"></script>
    <script src="{{ asset('dashboard') }}/assets/js/phoenix.js"></script>

</body>

</html>
