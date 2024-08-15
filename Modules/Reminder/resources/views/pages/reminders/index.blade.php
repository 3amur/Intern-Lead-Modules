@extends('dashboard.layouts.app')
@section('title')
    {{ __('Reminder Page') }}
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
    {{-- Begin breadcrumb --}}
    <x-reminder::breadcrumb>
        <x-reminder::breadcrumb-item>
            <a href="{{ route('reminders.home') }}">{{ __('Home') }}</a>
        </x-reminder::breadcrumb-item>

        <x-reminder::breadcrumb-item>
            {{ __('Reminders') }}
        </x-reminder::breadcrumb-item>
    </x-reminder::breadcrumb>
    {{-- End breadcrumb --}}
    @include('dashboard.layouts.alerts')


    <h4>{{ __('Reminders') }}</h4>
    <div class="d-flex justify-content-end">

        @if (app\Helpers\Helpers::perUser('reminders.create'))

        <x-reminder::modal-create-button title=" Reminder" data_bs_target="#createReminder" />

    @endif
    </div>
    <div>
        {{ $dataTable->table(['class' => 'useDataTable responsive table fs--1 mb-0 bg-white my-3 rounded-2 shadow', 'width' => '100%']) }}

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
                        name='description' placeholder='Write description Here ....' id="description" />
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
                    <div class="modal-footer">
                        <button class="btn btn-success btn" type="submit">{{ __('Create') }}</button>
                        <button class="btn btn-outline-secondary" type="button"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    <!-- modal for export-->
    <div class="modal fade " id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title " id="exampleModalLabel">Export All Data</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportModalForm"  method="POST" action="{{ route('reminders.export') }}">
                    @csrf
                    <div class="modal-body export-modal row justify-content-around">
                        <!-- Hidden input fields for additional data -->
                        <input type="hidden" id="exportFormatInput" name="exportFormat">
                        <input type="hidden" id="selectedColumnsInput" name="selectedColumns">
                        <input type="hidden" id="SelectedRows" name="SelectedRows">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" data-bs-dismiss="modal"
                            id="sendRequestBtn">Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end modal -->


    <!-- start modal for filter Search-->

    <div class="modal fade " id="filterModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title " id="exampleModalLabel">Filter Data</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body filter-modal row justify-content-around">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal for filter Search-->

@endsection
@section('js')

<script>
    $(document).ready(function() {

        $(document).on('click', '.delete-this-reminder', function(e) {
            e.preventDefault();
            let el = $(this);
            let url = el.attr('data-url');
            let id = el.attr('data-id');
            swalWithBootstrapButtons.fire({
                title: "Are you sure you really want to delete this REminder?",
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
                            window.location.href = "{{ route('reminders.index') }}";
                        }
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === swalWithBootstrapButtons.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Reminder is safe :)",
                        icon: "error"
                    });
                }
            });
        });
    });
</script>

<script>
    var columnTitleArr = window.columnTitleArr = [];

    window.createExportModalElements = function() {
        const exportModal = document.querySelector('.export-modal');

        columnTitleArr.forEach(element => {
            const div = document.createElement('div');
            div.classList.add('form-check');
            div.classList.add('col-5');

            const input = document.createElement('input');
            input.classList.add('form-check-input');
            input.type = 'checkbox';
            input.id = element;
            input.value = element;

            const label = document.createElement('label');
            label.classList.add('form-check-label');
            label.setAttribute('for', element);
            label.textContent = element;

            div.appendChild(input);
            div.appendChild(label);

            exportModal.appendChild(div);
        });
    }

    function getCheckedCheckboxes() {
            const exportModal = document.querySelector('.export-modal');
            const checkboxes = exportModal.querySelectorAll('.form-check-input');
            const checkedCheckboxes = [];
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    checkedCheckboxes.push(checkbox.value);
                }
            });
            return checkedCheckboxes;
        }

    $('#reminders-table').on('page.dt', function() {
        $('.selected-item').text(window.LaravelDataTables['reminders-table'].rows({
            selected: true
        }).count());
        $('.selected-badge').text(window.LaravelDataTables['reminders-table'].rows({
            selected: true
        }).count());
    });

    var arrOfFilterBtn = [];
    var searchValues = [];


    // Select all th elements inside the thead of the table and skip the first two
    $('.useDataTable thead tr th').slice(1, -1).each(function(index) {
        var id = 'checkbox_' + index;
        // Get the inner text of the th element and push it to thTextArray
        arrOfFilterBtn.push({
            text: () => {
                return `<div class="d-flex align-items-center"> <input class="me-2" id="${id}" type="checkbox">
   <label for=""${id}"">  ${$(this).text()}  <label>

   </div>`
            },
            action: function(e, dt, node, config, cb) {
                var buttonElement = $(this.node());
                $('#' + id).prop('checked', function(_, oldProp) {
                    if (oldProp) {
                        window.LaravelDataTables['reminders-table'].columns(index + 1).search(
                            "").draw();
                        searchValues = searchValues.filter(item => item.Column_No !==
                            index + 1);
                    }
                    return !oldProp;
                });
            }
        });
    });


    let exportFormat;
        $(document).on("click", "#excelModalBtn", function() {
            exportFormat = $(this).data("exportformat");
            this.exportFormat = exportFormat

        });
        $(document).on("click", "#pdfModalBtn", function() {
            exportFormat = $(this).data("exportformat");
            this.exportFormat = exportFormat
        });
        $(document).on("click", "#csvModalBtn", function() {
            exportFormat = $(this).data("exportformat");
            this.exportFormat = exportFormat
        });


        $(document).on('click','.exportSelected',function() {
            let SelectedRows = JSON.parse(localStorage.getItem('reminders_checkBoxIdsArray'));
            $("#SelectedRows").val(SelectedRows);
        });
        $(document).on("click", "#sendRequestBtn", function() {
            let selectedColumns = getCheckedCheckboxes();
            $("#exportFormatInput").val(exportFormat);
            $("#selectedColumnsInput").val(selectedColumns);
            $("#exportModalForm").submit();
        });
</script>



{!! str_replace(
'"DataTable.render.select()"',
'DataTable.render.select()',
$dataTable->scripts(attributes: ['type' => 'module']),
) !!}


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
                                        <x-reminder::form-multi-select name='contact_id[]' label='Contact' id="contact_id">
                            @foreach ($contacts as $contact)
                                {{-- Check if the current $contact is in $reminderContacts --}}
                                @if (in_array($contact->id, $contacts->pluck('id')->toArray()))
                                    <option value="{{ $contact->id }}" >{{ $contact->name . ' ' }} -
                                        {{ implode('- ', $contact->phones->pluck('phone')->toArray()) }}</option>
                                @else
                                    <option value="{{ $contact->id }}">{{ $contact->name . ' ' }} -
                                        {{ implode('- ', $contact->phones->pluck('phone')->toArray()) }}</option>
                                @endif
                            @endforeach
                        </x-reminder::form-multi-select>
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
                                <div class="form-group mb-1 col-8"
                                    <x-reminder::form-input type="text" value="" label="Contact Phone"
                                    name='phone[]' placeholder='01xxxxxxxxxx' id="phoneInput"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g, '')" maxlength="20" required  />
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
@endsection
