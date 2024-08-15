@extends('dashboard.layouts.app')
@section('title')
    {{ __('Lead Accounts Page') }}
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
            {{ __('Lead Account') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}


    <h4>{{ __('Lead Account') }}</h4>
    <div class="row">
        <div class="col float-end">
            @if (app\Helpers\Helpers::perUser('lead_account.create'))
                <x-potentialcustomer::create-button route="{{ route('lead_account.create') }}" title="Lead Account" />
            @endif
            @if (app\Helpers\Helpers::perUser('lead_account.import'))
                <x-potentialcustomer::import-button />
            @endif

            {{-- @if (app\Helpers\Helpers::perUser('lead_account.export'))
                <x-potentialcustomer::export-button href="{{ route('lead_account.export') }}" />
            @endif --}}
            <div class="float-end mx-2">
                <x-potentialcustomer::form-button label='Change Selected' data_bs_target=changeSelected />
            </div>
        </div>
    </div>

    <div class="modal fade" id="changeSelected" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title " id="staticBackdropLabel">Modal title</h5><button class="btn p-1" type="button"
                        data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs-9 "></span></button>
                </div>
                <div class="modal-body">
                    <x-potentialcustomer::form-select name='lead_source_id' label='Lead Source' id="lead_source_id">
                        <option value="">{{ __('Select :type', ['type' => __('Lead Source')]) }}</option>
                        @foreach ($leadSources as $leadSource)
                            <option @if (request()->has('lead_source_id') && request()->query('lead_source_id') == $leadSource->id) selected="selected" @endif
                                value="{{ $leadSource->id }}">
                                {{ $leadSource->title }}</option>
                        @endforeach
                    </x-potentialcustomer::form-select>
                    <x-potentialcustomer::form-select name='lead_status_id' label='Lead Status' id="lead_status_id">
                        <option value="">{{ __('Select :type', ['type' => __('Lead Status')]) }}</option>
                        @foreach ($leadStatuses as $leadStatus)
                            <option @if (request()->has('lead_status_id') && request()->query('lead_status_id') == $leadStatus->id) selected="selected" @endif
                                value="{{ $leadStatus->id }}">
                                {{ $leadStatus->title }}</option>
                        @endforeach
                    </x-potentialcustomer::form-select>
                    <x-potentialcustomer::form-select name='lead_value_id' label='Lead Value' id="lead_value_id">
                        <option value="">{{ __('Select :type', ['type' => __('Lead Value')]) }}</option>
                        @foreach ($leadValues as $leadValue)
                            <option @if (request()->has('lead_value_id') && request()->query('lead_value_id') == $leadValue->id) selected="selected" @endif
                                value="{{ $leadValue->id }}">
                                {{ $leadValue->title }}</option>
                        @endforeach
                    </x-potentialcustomer::form-select>
                    <x-potentialcustomer::form-select name='lead_type_id' label='Lead Type' id="lead_type_id">
                        <option value="">{{ __('Select :type', ['type' => __('Lead Type')]) }}</option>
                        @foreach ($leadTypes as $leadType)
                            <option @if (request()->has('lead_type_id') && request()->query('lead_type_id') == $leadType->id) selected="selected" @endif
                                value="{{ $leadType->id }}">
                                {{ $leadType->title }}</option>
                        @endforeach
                    </x-potentialcustomer::form-select>
                    <x-potentialcustomer::form-select name='sales_agent_id' label='Sales Agent' id="sales_agent_id">
                        <option value="">{{ __('Select :type', ['type' => __('Sales Agent')]) }}</option>
                        @foreach ($salesAgents as $salesAgent)
                            <option @if (request()->has('sales_agent_id') && request()->query('sales_agent_id') == $salesAgent->id) selected="selected" @endif
                                value="{{ $salesAgent->id }}">
                                {{ $salesAgent->name }}</option>
                        @endforeach
                    </x-potentialcustomer::form-select>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btn-sm" type="button" id="changeBtn">Okay</button>
                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>


    <hr>
    <div>
        {{ $dataTable->table(['class' => 'useDataTable responsive table fs--1 mb-0 bg-white my-3 rounded-2 shadow', 'width' => '100%']) }}
    </div>



    <!-- modal for export-->
    <div class="modal fade " id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title " id="exampleModalLabel">Export All Data</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportModalForm"  method="POST" action="{{ route('lead_account.export') }}">
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
            $("#lead_source_id,#lead_status_id,#lead_value_id,#sales_agent_id,#lead_type_id").select2({
                dropdownParent: $("#changeSelected")
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete-this-leadAccount', function(e) {
                e.preventDefault();
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');

                swalWithBootstrapButtons.fire({
                    title: "Are you sure you really want to delete this Lead Account?",
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
                                    "{{ route('lead_account.index') }}";
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === swalWithBootstrapButtons.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Lead Account  is safe :)",
                            icon: "error"
                        });
                    }
                });
            });
            $(document).on('click', '.potential_transition', function(e) {
                e.preventDefault();
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: '{{ __('Do you really want to Make this Lead Account Potential Account?') }}',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('Yes') }}',
                    cancelButtonText: '{{ __('No') }}',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: "PUT",
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            success: function(msg) {
                                window.location.href =
                                    "{{ route('lead_account.index') }}";
                            }
                        });
                    }
                });
            });
            $(document).on('click', '.activate-this-leadAccount', function(e) {
                e.preventDefault();
                console.log('hhello');
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: '{{ __('Do you really want to Activate this Lead Account ?') }}',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('Yes') }}',
                    cancelButtonText: '{{ __('No') }}',
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('before ajax');
                        $.ajax({
                            method: "PUT",
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            success: function(msg) {
                                window.location.href =
                                    "{{ route('lead_account.index') }}";
                            }
                        });
                    }
                });
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            var lead_account_ids = [];
            localStorage.removeItem('leadAccount_checkBoxIdsArray');
            $(document).on('click', '#changeBtn', function(e) {
                e.preventDefault();
                lead_account_ids = JSON.parse(localStorage.getItem('leadAccount_checkBoxIdsArray'));
                console.log(lead_account_ids);
                if (lead_account_ids === null) {
                    swalWithBootstrapButtons.fire('Please Select at least one row');
                } else if (lead_account_ids.length >= 1) {
                    changeSelectedRows();
                } else {
                    swalWithBootstrapButtons.fire('Please Select at least one row');
                }
            });
            $(document).on('change', '#selectAllCheckbox', function() {
                $('table#lead-account-table tbody input[type="checkbox"]').prop('checked', $(this).is(
                    ':checked'));
                addSelectedCount();
            });

            function changeSelectedRows() {
                let lead_source_id = $('#lead_source_id').val();
                let lead_status_id = $('#lead_status_id').val();
                let lead_value_id = $('#lead_value_id').val();
                let lead_type_id = $('#lead_type_id').val();
                let sales_agent_id = $('#sales_agent_id').val();
                swalWithBootstrapButtons.fire({
                    title: '{{ __('Do you really want to make a change?') }}',
                    showCancelButton: true,
                    confirmButtonText: '{{ __('Yes') }}',
                    cancelButtonText: '{{ __('No') }}',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('lead_account.changeSelectedRows') }}",
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            data: {
                                lead_source_id,
                                lead_value_id,
                                lead_status_id,
                                lead_type_id,
                                sales_agent_id,
                                lead_account_ids,
                            },
                            success: function(msg) {
                                window.LaravelDataTables["lead-account-table"].draw();
                                $('#lead_source_id').change('');
                                $('#lead_status_id').change('');
                                $('#lead_value_id').change('');
                                $('#lead_type_id').change('');
                                $('#sales_agent_id').change('');
                                lead_account_ids = [];
                                swalWithBootstrapButtons.fire(msg.message,
                                    'Selected Data Updated Successfully', msg
                                    .success ? 'success' : 'error');
                            },
                            error: function() {
                                console.log('Error in the request');
                            }
                        });
                    }
                });
            }
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


        $('#lead-account-table').on('page.dt', function() {
            $('.selected-item').text(window.LaravelDataTables['lead-account-table'].rows({
                selected: true
            }).count());
            $('.selected-badge').text(window.LaravelDataTables['lead-account-table'].rows({
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
                            window.LaravelDataTables['lead-account-table'].columns(index +
                                2).search(
                                "").draw();
                            searchValues = searchValues.filter(item => item.Column_No !==
                                index + 2);
                        }
                        return !oldProp;
                    });
                }
            });
        });

        let exportFormat;
        $(document).on("click", "#excelModalBtn", function() {
            exportFormat = $(this).data("exportformat");
        });

        $(document).on("click", "#pdfModalBtn", function() {
            exportFormat = $(this).data("exportformat");
        });

        $(document).on("click", "#csvModalBtn", function() {
            exportFormat = $(this).data("exportformat");
        });

        $(document).on('click','.exportSelected',function() {
            let SelectedRows = JSON.parse(localStorage.getItem('leadAccount_checkBoxIdsArray'));
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
                'text/csv'
            ];

            if (match.includes(fileType)) {
                data = new FormData();
                data.append('file', file);

                let oldTitle = $('title').text();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('lead_account.import') }}',
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
                    }
                });
            } else {
                $.notify("Please Select Valid file must be csv or excel!", 'error');
            }
        });
    </script>
@endsection
