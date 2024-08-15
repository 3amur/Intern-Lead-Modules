@extends('dashboard.layouts.app')
@section('title')
    {{ isset($salesCommission) ? __('Edit Sales Commission ') : __('Create New Sales Commission') }}
@endsection
@section('css')
    <link href="{{ asset('dashboard') }}/vendors/flatpickr/flatpickr.min.css" rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        label {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;

            --slide-distance: 1.2rem;
            --slider-size: 1.25rem;
            --slider-padding: 0.2rem;
            --transition-duration: 200ms;
        }

        .slider {
            flex-shrink: 0;
            width: calc(var(--slider-size) + var(--slide-distance) + var(--slider-padding) * 2);
            padding: var(--slider-padding);
            border-radius: 9999px;
            background-color: #d1d5db;
            transition: background-color var(--transition-duration);

            &::after {
                content: "";
                display: block;
                width: var(--slider-size);
                height: var(--slider-size);
                background-color: #fff;
                border-radius: 9999px;
                transition: transform var(--transition-duration);
            }
        }

        input:checked+.slider {
            background-color: hsl(130deg, 100%, 30%);

            &::after {
                transform: translateX(var(--slide-distance));
            }
        }

        input:focus-visible+.slider {
            outline-offset: 2px;
            outline: 2px solid hsl(210deg, 100%, 40%);
        }

        .label {
            line-height: 1.5;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border-width: 0;
        }
    </style>
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('lead_home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('sales_agents.index') }}">{{ __('Sales Agents') }}</a>
        </x-potentialcustomer::breadcrumb-item>
        <x-potentialcustomer::breadcrumb-item>
            <a
                href="{{ route('sales_commissions.index', ['sales_agent' => $salesAgent->id]) }}">{{ __('Sales Commission') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($salesCommission) ? __('Edit :type', ['type' => $salesCommission->title]) : __('Create New Sales Commission') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        @include('dashboard.layouts.alerts')
        <div class="card my-3">
            <div class="card-header">
                {{ isset($salesCommission) ? __('Edit :type', ['type' => $salesCommission->title]) : __('Create New Sales Commission') }}
            </div>
            <form
                action="{{ isset($salesCommission) ? route('sales_commissions.update', ['sales_commission' => $salesCommission]) : route('sales_commissions.store', ['sales_agent' => $salesAgent]) }}"
                method="POST" enctype="multipart/form-data" id="salesCommissionForm">
                @csrf
                @if (isset($salesCommission))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::form-input type="text" :value="isset($salesCommission) ? $salesCommission->title : old('title')" label="Commission Title"
                                name='title' placeholder='Sales Commission Title' id="commission_title"
                                oninput="{{ null }}" required />
                        </div>
                        <div class="col-6">
                            <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                                <option @if (isset($salesCommission) && $salesCommission->status == 'active') selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (isset($salesCommission) && $potentialAccount->status == 'inactive') selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (isset($salesCommission) && $salesCommission->status == 'draft') selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </x-potentialcustomer::form-select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::date-input label="{{ __('Start date') }}" name="start_date"
                                value="{{ isset($brokerCommission) ? $brokerCommission->start_date : old('start_date') }}"
                                id="start_date" required />
                        </div>

                        <div class="col-6">
                            <x-potentialcustomer::date-input label="{{ __('End date') }}" name="end_date"
                                value="{{ isset($brokerCommission) ? $brokerCommission->end_date : old('end_date') }}"
                                id="end_date" required />
                        </div>
                    </div>

                    <x-potentialcustomer::form-description
                        value="{{ isset($salesCommission) ? $salesCommission->notes : old('notes') }}" label="Notes"
                        name='notes' placeholder='Sales Commission notes' id="notes" />

                    <div class="row my-4">
                        @if (!isset($salesCommission))
                            <div class="col-4">
                                <a style="" class="btn btn-primary btn-sm mt-3" id="addRow">Add layer</a>
                            </div>
                        @endif

                        <div class="col-6">

                            <table>
                                <thead class="thead fs--1" style="display: none;">
                                    <tr>
                                        <th>{{ __('Amount From') }}</th>
                                        <th>{{ __('Amount To') }} </th>
                                        <th> {{ __('Percent') }} </th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="rowParent">
                                    @if (!empty($salesCommission) && !empty($salesCommission->commissionLayers))
                                        @foreach ($salesCommission->commissionLayers as $index => $sales_commission_up_to)
                                            <tr>
                                                <td><input readonly type="text" data-amount_from="{{ $index + 1 }}"
                                                        data-type="currency" class="form-control" placeholder="Amount From"
                                                        min="0" max="9999999" name="amount_from[]"
                                                        value="{{ number_format($sales_commission_up_to->amount_from, 2, '.', ',') }}"
                                                        required=""></td>
                                                <td><input readonly type="text" data-amount_to="{{ $index + 1 }}"
                                                        data-type="currency" class="form-control" placeholder="Amount To"
                                                        min="0" max="9999999" name="amount_to[]"
                                                        @if ($sales_commission_up_to->amount_to == '1000000000000000.00') style="display:none" @endif
                                                        @if (!empty($sales_commission_up_to->amount_to) && $sales_commission_up_to->amount_to != '1000000000000000.00') value="{{ $sales_commission_up_to->amount_to ? number_format($sales_commission_up_to->amount_to, 2, '.', ',') : '' }}" @endif
                                                        required=""></td>
                                                <td><input readonly type="number" class="form-control"
                                                        placeholder="discount up to" min="0" max="100"
                                                        name="percent[]" data-percent="{{ $index + 1 }}"
                                                        value="{{ $sales_commission_up_to->percent }}" required="">
                                                </td>
                                                <td data-remove="{{ $index + 1 }}"></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>



                    @if (!isset($salesCommission))
                        <div class="form-group col-12">
                            <div class="input-group">
                                <a id="unlimited_amount_to" data-togele="0" class="btn btn-primary btn-sm"
                                    style="display: none;">
                                    {{ __('unlimited amount to') }} </a>
                            </div>
                        </div>
                    @endif

                    <div class="card-footer text-muted text-center" id="card-footer">
                        <x-potentialcustomer::form-submit-button id="submitBtn" label='Confirm' />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('dashboard/assets/js/jquery.validate.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <script>
        unlimeted = 0;
    </script>
    @if (!empty($sales_commission_up_to->amount_to) && $sales_commission_up_to->amount_to == '1000000000000000.00')
        <script>
            unlimeted = 1;
        </script>
    @else
        <script>
            unlimeted = 0;
        </script>
    @endif
    <script>

$(document).ready(function() {
            createRow()

        });

        
        @if (!empty($salesCommission) && !empty($salesCommission->commissionLayers))
            var indexs = [];
            for (var i = 1; i <= '{{ $salesCommission->commissionLayers->count() }}'; i++) {
                indexs.push(i);
            }
            localStorage.setItem('indexs', JSON.stringify(indexs));
        @else
            localStorage.setItem('indexs', JSON.stringify([]));
        @endif


        function removeTr(td) {
            var storedArray = JSON.parse(localStorage.getItem('indexs'));
            var modifiedArray = storedArray.filter(function(item) {
                return item !== parseInt(td.getAttribute('data-remove'));
            });
            $('[data-remove="' + (parseInt(td.getAttribute('data-remove')) - 1) + '"]').show();
            localStorage.setItem('indexs', JSON.stringify(modifiedArray));
            if ((!amount_to && localStorage.getItem('indexs') == '[]')) {
                $("#unlimited_amount_to").hide()
            }
            const tr = td.parentElement;
            var trCount = document.getElementsByTagName('tr').length;
            if (trCount == 2) {
                $('.thead').hide();
            }
            tr.remove();
        }

        const rowParent = document.getElementById("rowParent");

        function createInputField(placeholder) {
            const input = document.createElement("input");
            input.type = "text";
            input.className = "form-control";
            input.placeholder = placeholder;
            return input;
        }

        function createRow() {
            $('.thead').show();
            if (localStorage.getItem('indexs') !== null && localStorage.getItem('indexs') !== '[]') {
                storedArray = JSON.parse(localStorage.getItem('indexs'));
                numericArray = storedArray.map(Number).filter(value => !isNaN(value));

                index = Math.max(...numericArray);
            } else {
                index = 0;
            }

            var amount_to = $('[data-amount_to="' + index + '"]').val();
            var amount_from = $('[data-amount_from="' + index + '"]').val();
            var percent_value = $('[data-percent="' + index + '"]').val();


            const percentInputs = document.querySelectorAll('[data-percent]');

            let percent = null;
            percentInputs.forEach(function(input) {
                const value = parseFloat(input.value);
                if (!isNaN(value) && (percent === null || value > percent)) {
                    percent = value;
                }
            });



            if ((!amount_to && localStorage.getItem('indexs') !== '[]') || $("#unlimited_amount_to").data('togele') ==
                '1') {
                Swal.fire({
                    icon: "error",
                    title: "The amount to is required to continue",
                });

            } else if ((!percent_value && localStorage.getItem('indexs') !== '[]') || $("#unlimited_amount_to").data(
                    'togele') ==
                '1') {
                Swal.fire({
                    icon: "error",
                    title: 'The percent is required to continue',
                });
            } else if ((!amount_from && localStorage.getItem('indexs') !== '[]') || $("#unlimited_amount_to").data(
                    'togele') ==
                '1') {
                Swal.fire({
                    icon: "error",
                    title: 'The amount_from is required to continue',
                });
            } else if (index > 1 && parseInt($('[data-percent="' + index + '"]').val()) <= parseInt($('[data-percent="' + (
                    index - 1) + '"]').val())) {
                Swal.fire({
                    icon: "error",
                    title: "The the percent must be bigger than " + $('[data-percent="' + (index - 1) + '"]').val(),
                });

            } else if (amount_to && amount_from && parseCurrency(amount_from) >= parseCurrency(amount_to)) {
                Swal.fire({
                    icon: "error",
                    title: "The amount to must be bigger than amount from",
                });
            } else {

                $('[data-amount_to="' + index + '"]').attr('readonly', true);
                $('[data-amount_from="' + index + '"]').attr('readonly', true);
                $('[data-percent="' + index + '"]').attr('readonly', true);
                $('[data-remove="' + index + '"]').hide();

                $("#unlimited_amount_to").show();
                storedArray = JSON.parse(localStorage.getItem('indexs'));

                storedArray.push(index + 1);
                localStorage.setItem('indexs', JSON.stringify(storedArray));

                const tr = document.createElement("tr");
                const amountFromTd = document.createElement("td");
                const amountFromInput = createInputField("Amount From");
                amountFromInput.type = "text";
                //amountFromInput.min = "0";
                amountFromInput.setAttribute("data-type", "currency");
                amountFromInput.addEventListener('keyup', function() {
                    formatCurrency($(this));

                });
                amountFromInput.name = "amount_from[]";

                if (amount_to) {

                    amount_to_float = parseCurrency(amount_to);
                    amount_to_float += 0.1;

                    amountFromInput.value = formatNumberByLable(amount_to_float.toLocaleString('en-US', {
                        style: 'decimal',
                        maximumFractionDigits: 2
                    }));
                    amountFromInput.setAttribute('readonly', true);
                }



                amountFromInput.setAttribute("data-amount_from", index + 1);
                amountFromInput.required = true;
                amountFromTd.appendChild(amountFromInput);

                const amountToTd = document.createElement("td");
                const amountToInput = createInputField("Amount  To");
                amountToInput.type = "text";
                //amountToInput.min = "0";
                amountToInput.setAttribute("data-type", "currency");
                amountToInput.addEventListener('keyup', function() {
                    formatCurrency($(this));

                });

                amountToInput.name = "amount_to[]";
                amountToInput.setAttribute("data-amount_to", index + 1);
                amountToInput.required = true;

                amountToTd.appendChild(amountToInput);


                const amountfromTd = document.createElement("td");

                const amountfromInput = createInputField("percent");
                amountfromInput.type = "number";
                if (percent) {
                    amountfromInput.min = percent + 1;
                } else {
                    amountfromInput.min = "0";
                }

                amountfromInput.name = "percent[]";
                amountfromInput.setAttribute("data-percent", index + 1);

                amountfromInput.required = true;
                amountfromTd.appendChild(amountfromInput);

                const actionTd = document.createElement("td");
                actionTd.setAttribute("data-remove", index + 1);
                const removeButton = document.createElement("a");
                removeButton.innerText = "Remove";
                removeButton.setAttribute("data-remove", index + 1);
                removeButton.className = "btn btn-danger";
                actionTd.addEventListener("click", function() {
                    removeTr(this);
                });
                if (index == 1) {
                    actionTd.appendChild(removeButton);

                }
                tr.appendChild(amountFromTd);
                tr.appendChild(amountToTd);
                tr.appendChild(amountfromTd);
                tr.appendChild(actionTd);

                rowParent.appendChild(tr);
            }
        }

        document.getElementById("addRow").addEventListener("click", createRow);
    </script>


    <script>
        $("#unlimited_amount_to").hide();
        if (localStorage.getItem('indexs') !== null && localStorage.getItem('indexs') !== '[]') {
            storedArray = JSON.parse(localStorage.getItem('indexs'));
            numericArray = storedArray.map(Number).filter(value => !isNaN(value));

            index = Math.max(...numericArray);
        } else {
            index = 0;
        }

        var amount_to = $('[data-amount_to="' + index + '"]').val();



        if (unlimeted == 1) {
            $("#unlimited_amount_to").text('Show Amount to Input');
            $("#unlimited_amount_to").data('togele', '1');
        }
        if ((!amount_to && localStorage.getItem('indexs') !== '[]')) {
            $("#unlimited_amount_to").show()
        }

        $(document).on('click', '#unlimited_amount_to', function() {
            if (localStorage.getItem('indexs') !== null && localStorage.getItem('indexs') !== '[]') {
                storedArray = JSON.parse(localStorage.getItem('indexs'));
                numericArray = storedArray.map(Number).filter(value => !isNaN(value));

                index = Math.max(...numericArray);
            } else {
                index = 0;
            }
            if ($("#unlimited_amount_to").data('togele') == '0') {
                $('[data-amount_to="' + index + '"]').val('999,999,999,999,999 (B)');
                $('[data-amount_to="' + index + '"]').hide();

                $("#unlimited_amount_to").text('Show Amount Input');
                $("#unlimited_amount_to").data('togele', '1');
            } else {
                $('[data-amount_to="' + index + '"]').val('');
                $('[data-amount_to="' + index + '"]').show();
                $("#unlimited_amount_to").text('unlimited Amount');
                $("#unlimited_amount_to").data('togele', '0');
            }
        });

        $('input[data-type="currency"]').on({
            keyup: function() {
                formatCurrency($(this));
            },
            blur: function() {
                formatCurrency($(this), "blur");
            }
        });


        function formatNumber(n) {

            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
            var input_val = input.val();

            if (input_val === "") {
                return;
            }
            var original_len = input_val.length;
            var caret_pos = input.prop("selectionStart");
            if (input_val.indexOf(".") >= 0) {

                var decimal_pos = input_val.indexOf(".");

                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                left_side = formatNumber(left_side);

                right_side = formatNumber(right_side);

                if (blur === "blur") {
                    right_side += "00";
                }

                right_side = right_side.substring(0, 2);

                input_val = left_side + "." + right_side;

            } else {

                input_val = formatNumber(input_val);
                input_val = input_val;

                if (blur === "blur")
                    input_val += ".00";
            }

            input.val(input_val);


            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);

        }

        function parseCurrency(input) {
            var number = input.replace(/,/g, '');

            var suffix = input.match(/\(([^\)]+)\)/);
            /*   console.log(number + "ffffffffff");
               console.log(parseFloat(number)); */
            /* if (suffix) {
                 switch (suffix[1]) {
                     case 'k':
                         number *= 1000;
                         break;
                     case 'M':
                         number *= 1000000;
                         break;
                     case 'B':
                         number *= 1000000000;
                         break;
                 }
             }*/

            return parseFloat(number);
        }

        function formatNumberByLable(input_val) {
            if (input_val.length >= 5 && input_val.length < 10) {
                return input_val;
            } else if (input_val.length >= 10 && input_val.length < 14) {
                return input_val;
            } else if (input_val.length >= 14) {
                return input_val;
            } else {
                return input_val;
            }
        }
    </script>


    <script>
        $(document).ready(function() {
            $("#salesCommissionForm").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
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
                    notes: {
                        maxlength: 500,
                    },
                    status: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: "Commission Title is required",
                        minlength: 'Commission Title must be more than 3 letters',
                        maxlength: "Commission Title cannot exceed 100 characters",
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

                    notes: {
                        maxlength: "Notes cannot exceed 500 characters",
                    },
                    status: {
                        required: "Status is required",
                    },
                },
                errorClass: "text-danger fs--1",

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
@endsection
