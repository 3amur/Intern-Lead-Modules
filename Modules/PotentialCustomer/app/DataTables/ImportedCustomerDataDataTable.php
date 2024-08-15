<?php

namespace Modules\PotentialCustomer\app\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Modules\PotentialCustomer\app\Models\ImportedCustomerData;

class ImportedCustomerDataDataTable extends DataTable
{

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->where('potential_account_id',request()->route('potential_account'))))
            //->addColumn('action', 'ImportedCustomerDatafromimport.action')

            ->editColumn('policy_holder', function ($model) {
                return $model->policy_holder;
            })

            ->editColumn('member_name', function ($model) {
                return $model->member_name;
            })

            ->editColumn('employee_code', function ($model) {
                return $model->employee_code;
            })

            ->editColumn('medical_code', function ($model) {
                return $model->medical_code;
            })

            ->editColumn('gender', function ($model) {
                return $model->gender;
            })

            ->editColumn('date_of_birth', function ($model) {
                return $model->date_of_birth;
            })

            ->editColumn('marital_status', function ($model) {
                return $model->marital_status;
            })

            ->editColumn('start_date', function ($model) {
                return $model->start_date;
            })

            ->editColumn('end_date', function ($model) {
                return $model->end_date;
            })

            ->editColumn('insurance_category', function ($model) {
                return $model->insurance_category;
            })

            ->editColumn('room_type', function ($model) {
                return $model->room_type;
            })
            ->editColumn('optical', function ($model) {
                return $model->optical;
            })
            ->editColumn('dental', function ($model) {
                return $model->dental;
            })
            ->editColumn('medication', function ($model) {
                return $model->medication;
            })
            ->editColumn('maternity', function ($model) {
                return $model->maternity;
            })

            ->editColumn('labs_and_radiology', function ($model) {
                return $model->labs_and_radiology;
            })
            ->editColumn('notes', function ($model) {
                return $model->notes;
            })
            ->addColumn('potential_account', function ($model) {
                return $model->potentialAccount->account_name;
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at?$model->created_at->format('Y-m-d H:i:s'):null;
            })

            ->editColumn('updated_at', function ($model) {
                return $model->updated_at?$model->updated_at->format('Y-m-d H:i:s'):null;
            })

            ->addColumn('created_by', function ($model) {
                return $model->user ? $model->user->name : null;
            })

            ->addColumn('', function ($model) {
                return;
            })

            ->rawColumns(['action', 'status','image'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ImportedCustomerData $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {


        $initCompleteFunction = "function() {

            var checkBoxIds = new Set();
            
            window.LaravelDataTables['collected_customer_date_from_import-table'].columns.adjust().draw();
            window.LaravelDataTables['collected_customer_date_from_import-table'].on('select deselect',function(){
            var count = window.LaravelDataTables['collected_customer_date_from_import-table'].rows({ selected: true }).count();
            $('.selected-item').text(count);
            $('.selected-badge').text(count);
            window.LaravelDataTables['collected_customer_date_from_import-table'].button('copy:name').enable(count > 0);
            window.LaravelDataTables['collected_customer_date_from_import-table'].button(2).enable(count > 0);
            window.LaravelDataTables['collected_customer_date_from_import-table'].button('export:name').enable(count > 0);

            checkBoxIds.clear();

            // Iterate over each selected row
            window.LaravelDataTables['collected_customer_date_from_import-table'].rows({ selected: true }).every(function(rowIdx) {
                // Get the corresponding checkbox and check it
                var checkbox = $(this.node()).find('td:eq(0) input[type=\"checkbox\"]');
                checkbox.prop('checked', true);
                var checkBoxId = checkbox.prevObject[0].getAttribute('id');
                checkBoxIds.add(checkBoxId);
            });
            window.LaravelDataTables['collected_customer_date_from_import-table'].rows({ selected: false }).every(function(rowIdx) {
                // Get the corresponding checkbox and check it
                var checkbox = $(this.node()).find('td:eq(0) input[type=\"checkbox\"]');
                checkbox.prop('checked', false);
                var checkBoxId = checkbox.prevObject[0].getAttribute('id');
                checkBoxIds.delete(checkBoxId);
            });
            var checkBoxIdsArray = Array.from(checkBoxIds); // Convert Set to array
            localStorage.setItem('importedData_checkBoxIdsArray', JSON.stringify(checkBoxIdsArray))

                })
                // Iterate over each column in the table
                this.api().columns().every(function(colIdx) {
                    if (colIdx >= 1) {
                        var column = this;
                        // Get the title of each column and push it to columnTitleArr
                        window.columnTitleArr.push($(column.header()).text());
                    }
                });
                window.createExportModalElements();
        }";


        $arrOfFilterBtn = <<<'JS'
            function(){
                var arrOfFilterBtn = [];
                var searchValues = [];
                // Select all th elements inside the thead of the table and skip the first two
                    $('.useDataTable thead tr th').slice(1, -1).each(function (index) {
                        var id = 'checkbox_' + index;
                        // Get the inner text of the th element and push it to thTextArray
                        arrOfFilterBtn.push({
                            text: () => {
                                return `<div class="d-flex align-items-center"> <input class="me-2" id="${id}" type="checkbox">
                            <label for="${id}">${$(this).text()}</label></div>`;
                            },
                            action: function (e, dt, node, config, cb) {
                                var buttonElement = $(this.node());
                                $('#' + id).prop('checked', function (_, oldProp) {
                                    if (oldProp) {
            window.LaravelDataTables['collected_customer_date_from_import-table'].columns(index + 1).search("").draw();
          searchValues = searchValues.filter(item=> item.Column_No !== index+1);
        }
                                    return !oldProp;
                                });
                            }
                        });
                    });

                // Add the button to console checked values
                arrOfFilterBtn.push({
                    text: function() {
                        return '<button class="btn btn-primary w-100 filterBtn" data-bs-toggle="modal" data-bs-target="#filterModal" >Filters</button>';
                    },
                    action: function(e, dt, node, config, cb) {
                        var checkedValues = [];
                        var columnIndex = [];
                        // Iterate over each checkbox and log its ID and checked state
                        $('.dt-bootstrap5 .row .col-md-auto.ms-auto .dt-buttons .btn-group:nth-child(2) .dropdown-menu .dt-button.dropdown-item span input[type="checkbox"]')
                            .each(function() {
                                checkedValues.push({
                                    id: $(this).attr('id'),
                                    checked: $(this).prop('checked')
                                });
                            });

                        const filterModal = document.querySelector('.filter-modal');
                        filterModal.innerHTML = '';
                        checkedValues.forEach((element, i) => {
                            if (element.checked) {
                                columnIndex.push(i + 1);
                                const div = document.createElement('div');
                                div.classList.add('filter-search');
                                div.classList.add('col-10');

                                const label = document.createElement('label');
                                label.classList.add('form-check-label', 'pt-2', 'pb-1');
                                label.setAttribute('for', columnTitleArr[i].toString().trim());
                                label.textContent = columnTitleArr[i].toString().trim();

                                const searchInput = document.createElement('input');
                                searchInput.classList.add('form-control');
                                searchInput.setAttribute('id', columnTitleArr[i].toString().trim());
                                searchInput.setAttribute('type', 'text');
                                searchInput.setAttribute('placeholder', columnTitleArr[i] + ' filter ');

                                div.appendChild(label);
                                div.appendChild(searchInput);

                                filterModal.appendChild(div);
                            } else {
                                // Handle else case if needed
                            }
                        });

                        $('.filter-modal input[type="text"]').on('input', function() {
                            // Get the column index from the input's id
                            const columnId = $(this).attr('id');
                            let filterIndex;
                            columnTitleArr.map((item, index) => {
                                if (item.toString().trim() === columnId) {
                                    filterIndex = index + 1;
                                }
                            });
                            // Get the search value from the input
                            const searchValue = $(this).val();
                            // Apply the filter to the datatable
                            window.LaravelDataTables['collected_customer_date_from_import-table'].columns(filterIndex).search(searchValue).draw();
                        });
                    }
                });

                // Return arrOfFilterBtn
                return arrOfFilterBtn;
        }
        JS;



        return $this->builder()
            ->setTableId('collected_customer_date_from_import-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1,'des')
            ->selectStyleSingle()
            /* ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]) */
            ->parameters([
                'initComplete' => $initCompleteFunction,
                "responsive" => [
                    'orderable' => false,
                    'details' => [
                        'target' => 0
                    ]
                ],
                "layout" => [
                    "top2Start" => [
                        "buttons" => [
                            [
                                "extend" => 'collection',
                                "text" => 'Export All',
                                "name" => 'exportAll',
                                "className" => 'ms-1 exportAll rounded-1 mt-2',
                                "popoverTitle" => '<h5> Export All </h5>',
                                "buttons" => [
                                    [
                                        "text" => "function() {
                                                        return '<div data-bs-toggle=\"modal\" id=\"excelModalBtn\" data-exportFormat=\"excel\" data-bs-target=\"#exportModal\"> Excel</div>'
                                                    }"
                                    ],
                                    [
                                        "text" => "function() {
                                                        return '<div data-bs-toggle=\"modal\" id=\"pdfModalBtn\" data-exportFormat=\"pdf\" data-bs-target=\"#exportModal\">PDF</div>'
                                                    }"
                                    ],
                                    [
                                        "text" => "function() {
                                                        return '<div data-bs-toggle=\"modal\" id=\"csvModalBtn\" data-exportFormat=\"csv\" data-bs-target=\"#exportModal\"> CSV</div>'
                                                    }"
                                    ]
                                ]
                            ],
                            [
                                "extend" => 'copyHtml5',
                                "name" => 'copy',
                                "enabled" => false,
                                "text" => "function() {
                                                return '<span>Copy <span style=\"background :var(--phoenix-body-bg); color: var(--phoenix-1100) !important;  \" class=\"badge badge-primary  ms-3 selected-badge\">' +
                                                    0 + '</span></span>';
                                            }",
                                "exportOptions" => [
                                    "columns" => ':nth-child(n+3):not(:last-child):visible',
                                    "modifier" => [
                                        "selected" => true
                                    ]
                                ],
                                "className" => 'ms-1  rounded-1 mt-2 '
                            ],
                            [
                                "extend" => 'print',
                                "name" => 'print',
                                "enabled" => false,
                                "text" => "function() {
                                                return '<span>Print <span style=\"background :var(--phoenix-body-bg); color: var(--phoenix-1100) !important;\"  class=\"badge badge-primary text-black ms-3 selected-badge\">' +
                                                    0 + '</span></span>';
                                            }",
                                "exportOptions" => [
                                    "columns" => ':nth-child(n+3):not(:last-child):visible',
                                    "modifier" => [
                                        "selected" => true
                                    ]
                                ],
                                "className" => 'ms-1  rounded-1 mt-2'
                            ],
                            [
                                "text" => '<i class="fa fa-refresh " aria-hidden="true"></i>',
                                "action" => "function(e, dt, node, config) {
                                                window.LaravelDataTables['lead-account-table'].rows().deselect();
                                                window.LaravelDataTables['lead-account-table'].column(1).nodes().to$().find('input[type=\"checkbox\"]').prop('checked',
                                                    false);

                                                dt.ajax.reload();
                                                window.LaravelDataTables['lead-account-table'].draw();
                                                window.location.reload();
                                            }",
                                "className" => 'ms-1  rounded-1 mt-2'
                            ],
                            [
                                "extend" => 'colvis',
                                "popoverTitle" => '<h5> Column visibility </h5>',
                                "className" => 'ms-1  rounded-1 mt-2'
                            ]
                        ]
                    ],
                    "top2End" => [
                        "buttons" => [
                            [
                                "extend" => 'collection',
                                "text" => 'Export Selected',
                                "name" => 'export',
                                "popoverTitle" => '<h5> Export Selected </h5>',
                                "className" => 'ms-1 exportSelected  rounded-1 mt-2',
                                "enabled" => false,
                                "buttons" => [
                                    [
                                        "text" => "function() {
                                                        return '<div data-bs-toggle=\"modal\" id=\"excelModalBtn\" data-exportFormat=\"excel\" data-bs-target=\"#exportModal\"> Excel</div>'
                                                    }"
                                    ],
                                    [
                                        "text" => "function() {
                                                        return '<div data-bs-toggle=\"modal\" id=\"pdfModalBtn\" data-exportFormat=\"pdf\" data-bs-target=\"#exportModal\">PDF</div>'
                                                    }"
                                    ],
                                    [
                                        "text" => "function() {
                                                        return '<div data-bs-toggle=\"modal\" id=\"csvModalBtn\" data-exportFormat=\"csv\" data-bs-target=\"#exportModal\"> CSV</div>'
                                                    }"
                                    ]
                                ]
                            ],
                            [
                                "extend" => 'collection',
                                "text" => ' Filter',
                                "popoverTitle" => '<h5> Column Filter </h5>',
                                "className" => 'ms-1  rounded-1 mt-2  d-block ',
                                "buttons" => $arrOfFilterBtn
                            ]
                        ]
                    ]
                ],
                "language" => [
                    "lengthMenu" => "Show _MENU_ ",
                    "searchPlaceholder" => "Users Search"
                ],
                "columnDefs" => [
                    [
                        "orderable" => false,
                        "render" => "DataTable.render.select()",
                        "targets" => 0,
                        "className" => 'select-checkbox',
                    ],
                    [
                        "orderable" => false,
                        "targets" => 0,
                    ]
                ],
                "select" => [
                    "style" => 'multi',
                    "selector" => 'input[type="checkbox"]',
                ],
                "stateSave" => true,
                "stateSaveParams" => "function(settings, data) {
                                                data.columns.map(item => {
                                                    item.search = '';
                                                });
                                                data.search.search = '';
                                            }",


                "fnDrawCallback" => "function( oSettings ) {
      $('.selected-item').text(window.LaravelDataTables['collected_customer_date_from_import-table'].rows({ selected: true }).count());
      $('.selected-badge').text(window.LaravelDataTables['collected_customer_date_from_import-table'].rows({ selected: true }).count());
    },lengthMenu: [
        [10, 25, 50,100,200],
        [10, 25, 50, 'All']
    ]",

            ]);
        ;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('')->content('')->addClass('text-center')->searchable(false)->orderable(false),
            Column::make('id')->addClass('text-center'),
            Column::make('policy_holder')->addClass('text-center'),
            Column::make('member_name')->addClass('text-center'),
            Column::make('employee_code')->addClass('text-center'),
            Column::make('medical_code')->addClass('text-center'),
            Column::make('gender')->addClass('text-center'),
            Column::make('date_of_birth')->addClass('text-center'),
            Column::make('marital_status')->addClass('text-center'),
            Column::make('start_date')->addClass('text-center'),
            Column::make('end_date')->addClass('text-center'),
            Column::make('insurance_category')->addClass('text-center'),
            Column::make('room_type')->addClass('text-center'),
            Column::make('optical')->addClass('text-center'),
            Column::make('dental')->addClass('text-center'),
            Column::make('medication')->addClass('text-center'),
            Column::make('maternity')->addClass('text-center'),
            Column::make('hof_id')->addClass('text-center'),
            Column::make('labs_and_radiology')->addClass('text-center'),
            Column::make('potential_account')->addClass('text-center'),
            Column::make('notes')->addClass('text-center'),
            Column::make('created_by')->addClass('text-center'),
            Column::make('created_at')->addClass('text-center'),
            Column::make('updated_at')->addClass('text-center'),
            /* Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'), */
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ImportedCustomerData_' . date('YmdHis');
    }
}
