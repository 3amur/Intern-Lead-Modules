@extends('dashboard.layouts.app')
@section('title')
    {{ __('Roles Page') }}
@endsection
@section('css')
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-breadcrumb>
        <x-breadcrumb-item>
            <a href="{{ route('home.index') }}">{{ __('Home') }}</a>
        </x-breadcrumb-item>
        <x-breadcrumb-item>
            {{ __('Roles') }}
        </x-breadcrumb-item>
    </x-breadcrumb>
    {{-- End breadcrumb --}}
    <h4>{{ __('Manage Roles') }}</h4>

        <div class="d-flex justify-content-end">
            @if (App\Helpers\Helpers::perUSer('roles.create'))
            <x-create-button title="Role" route="roles.create" />
            @endif
            <button type="button" class="btn btn-primary btn-sm mx-2">Save  Setting</button>
        </div>

        <!-- modal for export-->
    <div class="modal fade " id="exportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title " id="exampleModalLabel">Export All Data</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="exportModalForm"  method="POST" action="{{ route('roles.export') }}">
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

    <div>
        {{ $dataTable->table(['class' => 'useDataTable responsive table fs--1 mb-0 bg-white my-3 rounded-2 shadow', 'width' => '100%']) }}
    </div>
@endsection

@section('js')



    <script>
        $(document).ready(function() {

            $(document).on('click', '.delete-this-role', function(e) {
                e.preventDefault();
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');
                swalWithBootstrapButtons.fire({
                    title: "Are you sure you really want to delete this Role?",
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
                                window.location.href = "{{ route('roles.index') }}";
                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === swalWithBootstrapButtons.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire({
                            title: "Cancelled",
                            text: "Role is safe :)",
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
        $('#roles_table').on('page.dt', function() {
            $('.selected-item').text(window.LaravelDataTables['roles_table'].rows({
                selected: true
            }).count());
            $('.selected-badge').text(window.LaravelDataTables['roles_table'].rows({
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
                            window.LaravelDataTables['roles_table'].columns(index + 1).search(
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
        });

        $(document).on("click", "#pdfModalBtn", function() {
            exportFormat = $(this).data("exportformat");
        });

        $(document).on("click", "#csvModalBtn", function() {
            exportFormat = $(this).data("exportformat");
        });

        $(document).on('click','.exportSelected',function() {
            let SelectedRows = JSON.parse(localStorage.getItem('roles_checkBoxIdsArray'));
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
