@extends('dashboard.layouts.app')
@section('title')
    {{ isset($salesTarget) ? __('Edit Sales Target ') : __('Create New Sales Target') }}
@endsection
@section('css')
    <link href="{{ asset('dashboard') }}/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('lead_home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('sales_targets.index') }}">{{ __('Sales Target') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($salesTarget) ? __('Edit :type', ['type' => $salesTarget->title]) : __('Create New Sales Target') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        @include('dashboard.layouts.alerts')

        <div class="card my-3">
            <div class="card-header">
                {{ isset($salesTarget) ? __('Edit :type', ['type' => $salesTarget->title]) : __('Create New Sales Target') }}
            </div>
            <form
                action="{{ isset($salesTarget) ? route('sales_targets.update', ['sales_target' => $salesTarget]) : route('sales_targets.store') }}"
                method="POST" enctype="multipart/form-data" id="salesTargetForm">
                @csrf
                @if (isset($salesTarget))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::form-input type="text" :value="isset($salesTarget) ? $salesTarget->target_name : old('target_name')" label="Target Title"
                                name='target_name' placeholder='Sales Target Title' id="target_name"
                                oninput="{{ null }}" required />
                        </div>
                        <div class="col-6">
                            <x-potentialcustomer::currency-input
                                value="{{ isset($salesTarget) ? number_format($salesTarget->target_value, 2, '.', ',') : old('target_value') }}"
                                label="Target Value" name='target_value' placeholder='Sales Target Value' id="target_value"
                                required />
                        </div>
                    </div>
                    <div id="errorContainer" role="alert">

                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="target_type_id" class="form-label ">{{ __('Target Types') }}</label>
                            <select
                                class="form-select js-example-basic-multiple fs-xs form-select-sm @error('target_type_id[]') is-invalid @enderror"
                                id="target_type_id" multiple="multiple"
                                data-options='{"removeItemButton":true,"placeholder":true}'
                                data-placeholder="{{ __('Select :type', ['type' => __('Target Type')]) }}"
                                name="target_type_id[]" required>

                                @foreach ($targetTypes as $targetType)
                                    <option
                                        @if (isset($salesTarget) && in_array($targetType->id, $salesTarget->targetTypes->pluck('id')->toArray())) selected="selected"
                                        @elseif(old('target_type_id') && in_array($targetType->id, old('target_type_id'))) selected="selected" @endif
                                        value="{{ $targetType->id }}">{{ $targetType->title }}</option>
                                @endforeach
                            </select>
                            @error('target_type_id[]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-3 col-12 col-sm-12 col-md-6 col-lg-6">
                            <label for="sales_agent_id" class="form-label">{{ __('Sales Agent') }}</label>
                            <select
                                class="form-select js-example-basic-multiple fs-xs form-select-sm @error('sales_agent_id[]') is-invalid @enderror"
                                id="sales_agent_id" multiple="multiple"
                                data-options='{"removeItemButton":true,"placeholder":true}'
                                data-placeholder="{{ __('Select :type', ['type' => __('Sales Agent')]) }}"
                                name="sales_agent_id[]">
                                @foreach ($salesAgents as $salesAgent)
                                    <option
                                        @if (isset($salesTarget) && in_array($salesAgent->id, $salesTarget->salesAgents->pluck('id')->toArray())) selected="selected"
                                        @elseif(old('sales_agent_id') && in_array($salesAgent->id, old('sales_agent_id'))) selected="selected" @endif
                                        value="{{ $salesAgent->id }}">{{ $salesAgent->name }}</option>
                                @endforeach
                            </select>
                            @error('sales_agent_id[]')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group mb-3 col-6">
                            <label class="form-label" for="start_date">Select Start Time </label>
                            <input class="form-control @error('start_date') is-invalid @enderror" type="date"
                                placeholder="d/m/y" name="start_date" id="start_date"
                                value="{{ isset($salesTarget) ? $salesTarget->start_date : old('start_date') }}"
                                required />
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-3 col-6">
                            <label class="form-label" for="end_date">Select End Time</label>
                            <input class="form-control @error('end_date') is-invalid @enderror" type="date"
                                placeholder="d/m/y " name="end_date" id="end_date"
                                value="{{ isset($salesTarget) ? $salesTarget->end_date : old('end_date') }}" required />
                            <small id="end-date-error" class="text-danger"></small>
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <x-potentialcustomer::form-description
                        value="{{ isset($salesTarget) ? $salesTarget->notes : old('notes') }}" label="Notes"
                        name='notes' placeholder='Sales Target notes' id="notes"/>
                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                                <option @if (isset($salesTarget) && $salesTarget->status == 'active') selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (isset($salesTarget) && $salesTarget->status == 'inactive') selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (isset($salesTarget) && $salesTarget->status == 'draft') selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </x-potentialcustomer::form-select>                        </div>
                        <div class="form-group mb-3 col-6">
                            <label for="target_calc_method"
                                class="form-label">{{ __('Target Calculation Method') }}</label>
                            <select
                                class="form-select js-example-basic-single fs-xs form-select-sm @error('target_calc_method') is-invalid @enderror"
                                id="target_calc_method"
                                data-placeholder="{{ __('Select :type', ['type' => __('Target Calculation Method')]) }}"
                                name="target_calc_method" required>
                                <option value="NULL">{{ __('Select Target Calculation Method') }}</option>
                                <option
                                    @if (isset($salesTarget) && $salesTarget->target_calc_method == 'group') selected="selected"
                                    @elseif(old('target_calc_method') == 'group') selected="selected" @endif
                                    value="{{ 'group' }}">{{ 'Group' }}
                                </option>
                                <option
                                    @if (isset($salesTarget) && $salesTarget->target_calc_method == 'separate') selected="selected"
                                    @elseif(old('target_calc_method') == 'separate') selected="selected" @endif
                                    value="{{ 'separate' }}">{{ 'Separate' }}
                                </option>
                            </select>
                            @error('target_calc_method')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="ms-3" id="target_layers"></div>
                <div class="card-footer text-muted text-center" id="card-footer">
                    <x-potentialcustomer::form-submit-button id="submitBtn"  label='Confirm' hidden disabled/>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('dashboard/assets/js/jquery.validate.js') }}"></script>
    @if (isset($salesTarget))
        <script>
            $(document).ready(function() {
                $('#submitBtn').prop('hidden', false).prop('disabled', false);

                $('label[for]').each(function() {
                    var inputId = $(this).attr('for');
                    $(this).append(' <span class="text-danger">*</span>');
                });

                $('#target_type_id, #sales_agent_id, #start_date, #end_date').on('change', function() {
                    handleFormChanges();
                });

                function handleFormChanges() {
                    $('#submitBtn').prop('hidden', true).prop('disabled', true);

                    sendAjaxRequest();
                }

                function sendAjaxRequest() {
                    var targetTypes = $('#target_type_id').val();
                    var salesAgents = $('#sales_agent_id').val();
                    var startDate = $('#start_date').val();
                    var endDate = $('#end_date').val();

                    var data = {
                        target_types: targetTypes,
                        sales_agents: salesAgents,
                        start_date: startDate,
                        end_date: endDate,
                        currentTargetId: '{{ $salesTarget->id }}'
                    };

                    $.ajax({
                        url: "{{ route('sales_targets.checkExistingTargetOnUpdate') }}",
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            handleAjaxSuccess(response);
                        },
                        error: function(error) {
                            handleAjaxError();
                        }
                    });
                }

                function handleAjaxSuccess(response) {
                    if (response.success) {
                        $('#errorContainer').text('');

                        $('#submitBtn').prop('hidden', false).prop('disabled', false);
                    } else {
                        $('#errorContainer').html(`
                        <div class="alert alert-soft-warning alert-dismissible fade show">${response.error}</div>
                    `);
                    }
                }

                function handleAjaxError() {
                    $('#errorContainer').text('An error occurred.');
                }
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('label[for]').each(function() {
                    var inputId = $(this).attr('for');
                    $(this).append(' <span class="text-danger">*</span>');
                });

                $('#target_type_id, #sales_agent_id, #start_date, #end_date').on('change', function() {
                    handleFormChanges();
                });

                function handleFormChanges() {
                    sendAjaxRequest();
                }

                function sendAjaxRequest() {
                    var targetTypes = $('#target_type_id').val();
                    var salesAgents = $('#sales_agent_id').val();
                    var startDate = $('#start_date').val();
                    var endDate = $('#end_date').val();

                    var data = {
                        target_types: targetTypes,
                        sales_agents: salesAgents,
                        start_date: startDate,
                        end_date: endDate
                    };
                    $.ajax({
                        url: "{{ route('sales_targets.checkExistingTargetOnCreate') }}",
                        type: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(response) {
                            handleAjaxSuccess(response);
                        },
                        error: function(error) {
                            handleAjaxError();
                        }
                    });
                }

                function handleAjaxSuccess(response) {
                    if (response.success) {
                        $('#errorContainer').text('');

                        $('#submitBtn').prop('hidden', false).prop('disabled', false);
                    } else {
                        $('#errorContainer').html(`
                        <div class="alert alert-soft-warning alert-dismissible fade show">${response.error}</div>
                    `);
                    }
                }

                function handleAjaxError() {
                    $('#errorContainer').text('An error occurred.');
                }
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {

            $("#salesTargetForm").validate({
                rules: {
                    target_name: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                    },
                    target_value: {
                        required: true,
                    },
                    'target_type_id[]': {
                        required: true,
                        minlength: 1,

                    },
                    'sales_agent_id[]': {
                        required: true,
                        minlength: 1,
                    },
                    start_date: {
                        required: true,
                        date: true,
                        min: todayFormatted(),
                    },
                    end_date: {
                        required: true,
                        date: true,
                        min: todayFormatted(),
                        greaterThanStartDate: true,
                    },
                    target_calc_method: {
                        required: true,
                        in: ['separate', 'group'],
                    },
                    notes: {
                        maxlength: 500,
                    },
                    status: {
                        required: true,

                    },
                    from: {
                        required: true,
                    },
                    to: {
                        required: true,
                    },
                    percentage: {
                        required: true,
                    },
                    'percentage.*': {
                        numeric: true,
                        range: [0, 100],
                    },
                },
                messages: {
                    target_name: {
                        required: "Target Title is required",
                        minlength: 'Target Title must be more than 3 letters',
                        maxlength: "Target Title cannot exceed 100 characters",
                    },
                    target_value: {
                        required: "Target Value is required",
                    },
                    'target_type_id[]': {
                        required: "At least one Target Type must be selected",
                        minlength: "At least one Target Type must be selected",
                    },
                    'sales_agent_id[]': {
                        required: "At least one Sales Agent must be selected",
                        minlength: "At least one Sales Agent must be selected",
                    },
                    start_date: {
                        required: "Start Date is required",
                        date: "Invalid Start Date format",
                        min: "Start Date cannot be in the past",
                    },
                    end_date: {
                        required: "End Date is required",
                        date: "Invalid End Date format",
                        min: "End Date cannot be in the past",
                        greaterThanStartDate: "End Date must be after Start Date",
                    },
                    target_calc_method: {
                        required: "Target Calculation Method is required",
                        in: "Invalid Target Calculation Method",
                    },
                    notes: {
                        maxlength: "Notes cannot exceed 500 characters",
                    },
                    status: {
                        required: "Status is required",

                    },
                    from: {
                        required: "From field is required",
                    },
                    to: {
                        required: "To field is required",
                    },
                    percentage: {
                        required: "Percentage field is required",
                    },
                    'percentage.*': {
                        numeric: "Percentage must be a numeric value",
                        range: "Percentage must be between 0 and 100",
                    },
                },
                errorClass: "text-danger",

                errorPlacement: function(error, element) {

                    error.appendTo(element.parent());
                }
            });

            $.validator.addMethod("greaterThanStartDate", function(value, element) {
                var startDate = $('#start_date').val();
                return Date.parse(value) > Date.parse(startDate);
            }, "End Date must be after Start Date");

            function todayFormatted() {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                var yyyy = today.getFullYear();
                return yyyy + '-' + mm + '-' + dd;
            }
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#target_type_id').on('select2:select', function(e) {
                var selectedData = e.params.data;
                addCard(selectedData.text, selectedData.id);
            });

            $('#target_type_id').on('select2:unselect', function(e) {
                var deselectedOptionText = e.params.data.text;
                removeCard(deselectedOptionText);
            });

            function fetchDataAndDisplay() {
                $.ajax({
                    url: "{{ isset($salesTarget) ? route('sales_targets.getTargetLayersData', ['sales_target_id' => $salesTarget->id]) : '' }}",
                    type: 'GET',
                    success: function(response) {
                        var data = response.data;
                        if (data.target_type) {
                            for (let targetType of data.target_type) {
                                addCard(targetType.title, targetType.id);

                                if (data.target_layers) {
                                    let targetLayers = data.target_layers.filter(layer => layer
                                        .target_type_id === targetType.id);
                                    for (let targetLayer of targetLayers) {
                                        addInputRow(targetLayer.target_type_id, numberFormat(targetLayer
                                                .from),
                                            numberFormat(targetLayer.to), targetLayer.percentage);
                                    }
                                }
                            }
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching data:', error);
                    }
                });
            }





            function addCard(title, id) {
                var containerId = 'target_inputs_' + id;
                if ($('#' + containerId).length === 0) {
                    var cardHtml = `
            <hr>
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="">${title}</h5>
                </div>
                <div class="card-body">
                    <div id="${containerId}">
                        <button type="button" class="btn btn-primary mb-2 col-1 target-type-button" data-option-value="${title}" onclick="showInputs('${title}', '${containerId}')">
                            <i class="fa-solid fa-plus" style="color: #ffffff;"></i>
                        </button>
                    </div>
                </div>
            </div>`;
                    $('#target_layers').append(cardHtml);
                }
            }

            function removeCard(optionText) {
                $('.target-type-button[data-option-value="' + optionText + '"]').closest('.card').remove();
            }
            var targetTypeHtml = "";

            function addInputRow(targetTypeId, from, to, percentage) {
                var targetTypeHtml = `
                    <div class="row mb-2">
                        <input type="text" name="layer_target_type_id[]" hidden value="${targetTypeId}">
                        <div class="form-group col-2 me-1">
                            <label for="">From :</label>
                            <input type="text" class="form-control from-input" name="from[]" oninput="validateFromTo(this)" value="${from}" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="EGP 1,000,000.00">
                            <small class="text-danger from-error"></small>
                        </div>
                        <div class="form-group col-2 me-1">
                            <label for="">To :</label>
                            <input type="text" class="form-control to-input" name="to[]" oninput="validateFromTo(this)" value="${to}" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency" placeholder="EGP 1,000,000.00">
                            <small class="text-danger to-error"></small>
                        </div>
                        <div class="col-2">
                            <label for="">Percentage :</label>
                            <div class="input-group ">
                                <input type="text" class="form-control" name="percentage[]" oninput="this.value = this.value.replace(/[^0-9]/g, '')" value="${percentage}" placeholder="100%" required>
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>
                        <div class="form-group col-1 me-1">
                            <button type="button" class="btn btn-danger mt-4" onclick="removeInputRow(this)">
                                <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                            </button>
                        </div>
                    </div>
                `;

                // value = "${}"; // Remove this line, as it seems to be unnecessary and causing the syntax error
                $('#target_inputs_' + targetTypeId).append(targetTypeHtml);

                // Apply currency formatting to the newly added inputs
                $("input[data-type='currency']").off(); // Remove previous bindings
                $("input[data-type='currency']").on({
                    keyup: function() {
                        formatCurrency($(this));
                    },
                    blur: function() {
                        formatCurrency($(this), "blur");
                    }
                });
            }

            fetchDataAndDisplay();
        });

        function numberFormat(yourNumber) {
                let numericValue = parseFloat(yourNumber);
                if (isNaN(numericValue)) {
                    return 'Invalid Number';
                }
                let formattedNumber = numericValue.toFixed(2).toString();

                formattedNumber = formattedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                return formattedNumber;
            }
        var targetTypeHtml = "";

        function showInputs(optionText, containerId, optionId) {
            var targetTypeId = $('#target_type_id option:contains(' + optionText + ')').val();
            $('#' + containerId).append(`
            <div class="row mb-2">
                <input type="text" name="layer_target_type_id[]" hidden value="${targetTypeId}">
                <div class="form-group col-2 me-1">
                    <label for="">From :</label>
                    <input type="text" class="form-control from-input" name="from[]" onblur="validateFromTo(this)" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency" placeholder="EGP 1,000,000.00">
                    <small class="text-danger from-error"></small>
                </div>
                <div class="form-group col-2 me-1">
                    <label for="">To :</label>
                    <input type="text" class="form-control to-input" name="to[]" onblur="validateFromTo(this)" id="currency-field" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="" data-type="currency" placeholder="EGP 1,000,000.00">
                    <small class="text-danger to-error"></small>
                </div>
                <div class="col-2">
                    <label for="">Percentage :</label>
                    <div class="input-group ">
                        <input type="text" class="form-control" name="percentage[]" onblur="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="100%" required>
                        <span class="input-group-text" id="basic-addon2">%</span>
                    </div>
                </div>
                <div class="form-group col-1 me-1">
                    <button type="button" class="btn btn-danger mt-4" onclick="removeInputRow(this)">
                        <i class="fa-solid fa-trash" style="color: #ffffff;"></i>
                    </button>
                </div>
            </div>
        `);

            // Append targetTypeHtml to the corresponding container
            $('#target_inputs_' + targetTypeId).append(targetTypeHtml);

            // Apply currency formatting to the newly added inputs
            $("input[data-type='currency']").off(); // Remove previous bindings
            $("input[data-type='currency']").on({
                keyup: function() {
                    formatCurrency($(this));
                },
                blur: function() {
                    formatCurrency($(this), "blur");
                }
            });
        }


        function removeInputRow(button) {
            $(button).closest('.row').remove();
        }

        function validateFromTo(input) {
            var targetValue = $('#target_value').val();
            var targetValueNumber = parseFloat(targetValue.replace(/,/g, ''));
            var inputType = $(input).hasClass('from-input') ? 'from' : 'to';
            var inputValue = parseFloat($(input).val().replace(/,/g, ''));
            var errorElement = inputType === 'from' ? $(input).next('.from-error') : $(input).next('.to-error');

            if (inputType === 'from' && (isNaN(inputValue) || inputValue >= targetValueNumber)) {
                errorElement.text('From value must be smaller than Target Value.');
                $(input).val('');
            } else if (inputType === 'to' && (isNaN(inputValue) || inputValue > targetValueNumber)) {
                errorElement.text('To value must be smaller or equal to Target Value.');
                $(input).val('');
            } else {
                errorElement.text('');

                // Check for conflicts with other target layers within the same target type
                var targetTypeId = $(input).closest('.row').find('input[name="layer_target_type_id[]"]').val();
                var fromValues = [];
                var toValues = [];

                // Collect all "from" and "to" values for the current target type

                $('.from-input').each(function() {
                    if ($(this).closest('.row').find('input[name="layer_target_type_id[]"]').val() ===
                        targetTypeId) {
                        var value = parseFloat($(this).val().replace(/,/g, ''));
                        if (!isNaN(value)) {
                            fromValues.push(value)

                        }
                    }
                });

                $('.to-input').each(function() {
                    if ($(this).closest('.row').find('input[name="layer_target_type_id[]"]').val() ===
                        targetTypeId) {
                        var value = parseFloat($(this).val().replace(/,/g, ''));
                        if (!isNaN(value)) {
                            toValues.push(value)
                        }
                    }
                });


                // Check for conflicts
                if (fromValues.length > 1 && toValues.length > 1) {
                    for (var i = 0; i < fromValues.length; i++) {
                        for (var j = 0; j < toValues.length; j++) {
                            if (i !== j && fromValues[i] <= toValues[j] && toValues[i] >= fromValues[j]) {

                                errorElement.text('Conflict with existing target layer ranges.');
                                $(input).val('');
                                return;
                            }
                        }
                    }
                }
            }
        }
    </script>

    <script>
        // Jquery Dependency

        $("input[data-type='currency']").on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });


        function formatNumber(n) {
            // format number 1000000 to 1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
    </script>
@endsection
