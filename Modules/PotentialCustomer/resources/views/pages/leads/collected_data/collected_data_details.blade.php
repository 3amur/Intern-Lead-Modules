@extends('dashboard.layouts.app')
@section('title')
    {{ __('Collected Data of Potential Account') }}
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
            <a href="{{ route('potential_account.index') }}">{{ __('Potential Account') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ __('Collected Data of Potential Account') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

    <div class="card shadow-none border border-300 my-4" data-component-card="data-component-card">
        <div class="card-header p-4 border-bottom border-300">
            <div class="row g-3 justify-content-between align-items-end">
                <div class="col-12 col-md">
                    <h4 class="text-900 mb-0" data-anchor="data-anchor">{{ __('Collected Data of Family Members') }}
                    </h4>
                    @if (app\Helpers\Helpers::perUser('imported_customer_data.import'))
                        <x-potentialcustomer::import-button />
                    @endif
                    @if (app\Helpers\Helpers::perUser('collected_customer_data.chartPage') &&
                            (!empty($headMembers->toArray()) || !empty($importedCustomerData->toArray())))
                        <a class="btn btn-success mx-3 float-end"
                            href="{{ route('collected_customer_data.chartPage', ['potential_account' => $potentialAccount->id]) }}"
                            style="border-radius: 0.375rem;">
                            <i class="fa-solid fa-chart-pie me-2"></i>{{ __('Charts') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="px-2">
                <h5 class=" card-title mx-3 my-4">{{ __('Potential Account Data') }}</h5>
                <hr>
            </div>
            <div class="row mx-2">
                <div class="col-6">
                    <table class="table table-striped table-sm">
                        <tbody>
                            <tr>
                                <th>{{ 'Account Name : ' }}</th>
                                <td>{{ $potentialAccount->account_name }}</td>
                            </tr>
                            <tr>
                                <th>{{ 'Mobile  : ' }}</th>
                                <td>{{ $potentialAccount->mobile }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (!empty($headMembers->toArray()))

                        <span class="h5">{{ __('Collected Customer Data from Link') }}</span>
                        @if (app\Helpers\Helpers::perUser('collected_customer_data.export'))
                            <a href="{{ route('collected_customer_data.exportCollectedData', ['potential_account_id' => $potentialAccount->id]) }}"
                                class="btn btn-primary float-end"><i
                                    class="fa-solid fa-download me-2"></i>{{ __('Export all Members') }}</a>

                            <div class="form-group float-end mx-2">
                                <button class="btn btn-primary float-end" id="exportSelectedBtn"><i
                                        class="fa-solid fa-download me-2"></i>{{ __('Export Selected Members') }}</button>
                            </div>
                        @endif
                        <h6>{{ __('Head Members Details') }}</h6>
                        <table id="headMembersTable" class="table  fs--1 mb-0 bg-white my-3 rounded-2 shadow'">
                            <thead>
                                <th class="text-center">
                                    <input class="form-check-input" id="selectAllCheckbox" type="checkbox" value=""
                                        name="headMember_checkbox" />
                                </th>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Name') }}</th>
                                <th class="text-center">{{ __('Relationship') }}</th>
                                <th class="text-center">{{ __('Link') }}</th>
                                <th class="text-center">{{ __('Date of Birth') }}</th>
                                <th class="text-center">{{ __('National ID') }} </th>
                                <th class="text-center">{{ __('Phone') }}</th>
                                <th class="text-center">{{ __('Action') }}</th>

                            </thead>
                            <tbody class="list" id="lead-details-table-body">
                                @foreach ($headMembers as $headMember)
                                    <tr>
                                        <td class="text-center">
                                            <input class="form-check-input headMember_checkbox" id="flexCheckDefault"
                                                type="checkbox" name="headMember_checkbox" value="{{ $headMember->id }}" />
                                        </td>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center"><a
                                                href="{{ route('collected_customer_data.showHeadMemberDetails', ['head_member' => $headMember->id]) }}">{{ $headMember->head_name }}</a>
                                        </td>
                                        <td class="text-center">{{ 'Head Member' }}</td>
                                        <td class="text-center"><a href="{{ optional($headMember->link)->url }}"
                                                target="_blank">{{ optional($headMember->link)->subject }}</a></td>
                                        <td class="text-center">{{ $headMember->head_birth_date }}</td>
                                        <td class="text-center">{{ $headMember->head_national_id }}</td>
                                        <td class="text-center">{{ $headMember->head_phone }}</td>
                                        <td class="text-center"><a class="btn - btn-primary btn-sm"
                                                href="{{ route('collected_customer_data.showHeadMemberDetails', ['head_member' => $headMember->id]) }}"><i
                                                    class="fa-solid fa-eye fa-xs"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
            @endif
            @if (!empty($importedCustomerData->toArray()))
                <hr>
                    <span class="h5">{{ __('Collected Customer Data From Import') }}</span>

                    @if (app\Helpers\Helpers::perUser('imported_customer_data.exportImportedData'))
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('imported_customer_data.exportImportedData', ['potential_account_id' => $potentialAccount->id]) }}"
                            class="btn btn-primary "><i
                                class="fa-solid fa-download me-2"></i>{{ __('Export to Excel') }}</a>
                    </div>
                    @endif


                    <div>
                        {{ $dataTable->table(['class' => 'useDataTable responsive table fs--1 mb-0 bg-white my-3 rounded-2 shadow', 'width' => '100%']) }}

                    </div>


            @endif
            <!-- modal for export-->
    <div class="modal fade " id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title " id="exampleModalLabel">Export All Data</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportModalForm"  method="POST" action="{{ route('imported_customer_data.export',['potential_account_id'=>$potentialAccount->id]) }}">
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
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

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
            var potentialAccountId = '{{ $potentialAccount->id }}';

            if (match.includes(fileType)) {
                data = new FormData();
                data.append('file', file);
                data.append('potentialAccountId', potentialAccountId); // Include potentialAccountId in FormData

                let oldTitle = $('title').text();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('imported_customer_data.import') }}',
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
    <script>
        $(function() {
            $("#headMembersTable").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#headMembersTable_wrapper .col-md-6:eq(0)').addClass('mx-2');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var $selectAllCheckbox = $('#selectAllCheckbox');
            var $headMemberCheckboxes = $('.headMember_checkbox');
            var selectedCheckboxes = [];

            $selectAllCheckbox.change(function() {
                $headMemberCheckboxes.prop('checked', $selectAllCheckbox.prop('checked'));
                logSelectedCheckboxes();
            });

            $headMemberCheckboxes.change(logSelectedCheckboxes);

            function logSelectedCheckboxes() {
                selectedCheckboxes = $headMemberCheckboxes.filter(':checked').map(function() {
                    return $(this).val();
                }).get();
            }

            $('#exportSelectedBtn').click(function(e) {
                e.preventDefault();

                $.ajax({
                    type: 'GET',
                    url: "{{ route('collected_customer_data.exportSelectedMembers', ['potential_account_id' => $potentialAccount->id]) }}",
                    data: {
                        selectedCheckboxes: selectedCheckboxes
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Please select at leat one member",
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
        console.log(checkedCheckboxes);

        return checkedCheckboxes;
    }
    $('#collected_customer_date_from_import-table').on('page.dt', function() {
        $('.selected-item').text(window.LaravelDataTables['collected_customer_date_from_import-table'].rows({
            selected: true
        }).count());
        $('.selected-badge').text(window.LaravelDataTables['collected_customer_date_from_import-table'].rows({
            selected: true
        }).count());
    });

    var arrOfFilterBtn = [];
    var searchValues = [];


    // Select all th elements inside the thead of the table and skip the first two
    $('.useDataTable thead tr th').slice(2, -1).each(function(index) {
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
                        window.LaravelDataTables['collected_customer_date_from_import-table'].columns(index + 2).search(
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
            let SelectedRows = JSON.parse(localStorage.getItem('importedData_checkBoxIdsArray'));
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
@endsection
