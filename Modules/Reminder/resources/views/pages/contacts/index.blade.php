@extends('dashboard.layouts.app')
@section('title')
    {{ __('Contacts Page') }}
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
            {{ __('Contacts') }}
        </x-reminder::breadcrumb-item>
    </x-reminder::breadcrumb>
    {{-- End breadcrumb --}}
    @include('dashboard.layouts.alerts')

    <h4>{{ __('Contacts') }}</h4>
    <div class="d-flex justify-content-end">
        @if (app\Helpers\Helpers::perUser('contacts.create'))
        <x-reminder::modal-create-button title=" Contact" data_bs_target="#createContact" />
        <button id="importBtn" onclick="$('#importFile').trigger('click')" class="btn btn-success mx-3 float-end"
            style="border-radius: 0.375rem;">
            <i class="fas fa-upload me-2 " style="color: #ffffff;"></i>{{ __('Import v-card') }}
            <div id="importProgress" style="height: 25px;width: 73px;" class="progress d-none">
                <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
                    aria-valuemin="0" aria-valuemax="100">25%</div>
            </div>
        </button>
        <input type="file" class="d-none"  id="importFile" accept=".vcf,.csv,.xlsx,.xls">
    @endif
    </div>
    <div>
        {{ $dataTable->table(['class' => 'useDataTable responsive table fs--1 mb-0 bg-white my-3 rounded-2 shadow', 'width' => '100%']) }}

    </div>
    {{-- Contacts Modal --}}
    <div class="modal fade" id="createContact" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Create New Contact') }}</h5>
                    <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span
                            class="fas fa-times fs--1"></span>
                    </button>
                </div>
                <form id="contactForm" action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <x-reminder::form-input type="text" :value="old('name')" label="Contact Name" name='name'
                            placeholder='Contact Name' id="nameInput" oninput="{{ null }}" required />

                        <x-reminder::form-input type="email" :value="old('email')" label="Contact Email" name='email'
                            placeholder='contact@example.com' id="emailInput" oninput="{{ null }}"  />

                        <div id="phones">
                            <div class="row">
                                <x-reminder::form-input type="text" :value="old('phone[]')" label="Contact Phone"
                                    name='phone[]' placeholder='01xxxxxxxxxx' id="phoneInput"
                                    oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />


                            </div>
                        </div>

                                <x-reminder::form-button label='+ Mobile Number' class="add-phone"/>

                        <x-reminder::form-select name='status' id="status" label="status" required>
                            <option selected value="active"> {{ __('Active') }}</option>
                            <option value="inactive"> {{ __('Inactive') }}</option>
                            <option value="draft"> {{ __('Draft') }}</option>
                        </x-reminder::form-select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">{{ __('Create') }}</button>
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
                <form id="exportModalForm"  method="POST" action="{{ route('contacts.export') }}">
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
        $("#status").select2({
            dropdownParent: $("#contactForm")
        });
    });
</script>
    <script>
        $(document).ready(function() {

            $(document).on('click', '.delete-this-contact', function(e) {
                e.preventDefault();
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: "Are you sure you really want to delete this Contact?",
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
                                window.location.href = "{{ route('contacts.index') }}";
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === swalWithBootstrapButtons.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Contact is safe :)",
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

    $('#contacts-table').on('page.dt', function() {
        $('.selected-item').text(window.LaravelDataTables['contacts-table'].rows({
            selected: true
        }).count());
        $('.selected-badge').text(window.LaravelDataTables['contacts-table'].rows({
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
                        window.LaravelDataTables['contacts-table'].columns(index + 1).search(
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
            let SelectedRows = JSON.parse(localStorage.getItem('contacts_checkBoxIdsArray'));
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
        // Add phone row
        $(".add-phone").on("click", function() {
            var newRow = $(`<div class="row">
                            <div class="col-9">

                                <x-reminder::form-input type="text" :value="old('phone[]')" label="Contact Phone"
                            name='phone[]' placeholder='01xxxxxxxxxx' id="phoneInput"
                            oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />
                            </div>

                            <div class="form-group mb-3 col-3">
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
                    minlength:"Phone number must not be less 8 characters",

                }
            },
            errorClass: "error text-danger fs--1", // CSS class to apply to error elements
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



<script>
    $(document).on('change', '#importFile', function() {
        let el = $(this);
        let file = this.files[0];
        let fileType = file.type;
        var match = [
            /*excel*/
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
            /*csv*/
            'text/csv',
            /*vCard*/
            'text/vcard',
            'text/x-vcard'

        ];

        if (match.includes(fileType)) {
            data = new FormData();
            data.append('file', file);

            let oldTitle = $('title').text();
            $.ajax({
                type: 'POST',
                url: '{{ route('contacts.importVCard') }}',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                beforeSend: function() {
                    $("#importProgress .progress-bar").attr('aria-valuenow', 0).css({
                        "width": 0 + '%'
                    }).html(0 + '%');
                    $("#importProgress").removeClass('d-none');
                    $("#import-btn-title").addClass('d-none');
                    $("#importBtn").addClass('loading').attr('disabled', 'disabled');
                    $('title').html('0%' + ' upload file ' + ' |' + oldTitle);
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.round((evt.loaded / evt.total) *
                                100);
                            $("#importProgress .progress-bar").attr('aria-valuenow',
                                percentComplete).css({
                                "width": percentComplete + '%'
                            }).html(percentComplete + '%');
                            /*Do something with upload progress here*/
                            $('title').html(percentComplete + '%' + ' upload file ' + ' |' +
                                oldTitle);
                        }
                    }, false);
                    return xhr;
                },
                success: function(data) {
                    $("#importProgress").addClass('d-none');
                    $("#import-btn-title").removeClass('d-none');
                    $("#importBtn").removeClass('loading').removeAttr('disabled');
                    $.notify(data.message,
                        data.success == true ? "success" : "error"
                    );
                    el.val('');
                    $('title').html(data.message + ' | ' + oldTitle);
                    if (data.success && data.redirect_url) {
                        setTimeout(function() {
                            window.location.href = data.redirect_url;
                        }, 3000);
                    }
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: "error",
                        title: data.responseJSON.message,
                    });
                }
            });
        } else {
            $.notify("Please Select Valid file must be csv or excel!", 'error');
        }
    });
</script>
@endsection
