@extends('dashboard.layouts.app')
@section('title')
    {{ __('Collected Customer Data Import Match Page') }}
@endsection
@section('css')
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>


        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('collected_customer_data.showCollectedDataDetails',['potential_account'=>$potentialAccount->id]) }}">{{ __('Collectd Customer Data') }}</a>
        </x-potentialcustomer::breadcrumb-item>
        <x-potentialcustomer::breadcrumb-item>
            {{ __('Collected Customer Data Import Match Page') }}
        </x-potentialcustomer::breadcrumb-item>
        </x-breadcrumb>
        {{-- End breadcrumb --}}
        @include('dashboard.layouts.alerts')

        <div class="container">
            <div class="card my-3">
                <div class="card-header">
                    <h4 class="mb-0">{{ __('Import') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="submitForm">
                        @csrf
                        <input type="text" name="potential_account_id" id="potential_account_id" value="{{ $potentialAccount->id }}" hidden>
                        <div class="row">
                            @foreach ($tableColumns as $key => $col)
                                <div class="form-group col-lg-6 mb-3">
                                    <label for="columns_{{ $col }}">{{ str_replace('_', ' ', $key) }}</label>
                                    <select required onchange="CheckArray()"
                                        class="form-select select3 js-example-basic-single  fs-xs form-select-sm"
                                        id="select_{{ $col }}" name="{{ strtolower($col) }}">
                                        <option value="0">
                                            {{ __('Select :type', ['type' => str_replace('_', ' ', $key)]) }}</option>
                                    </select>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            <x-potentialcustomer::form-submit-button id="submitBtn"  label='Confirm'/>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
    @section('js')
        <script>
            $(document).on('submit', 'form#submitForm', function(e) {
                const selectElements = document.querySelectorAll('select.select3');
                const sendData = {};
                selectElements.forEach(selectElement => {
                    let value = selectElement.value;
                    let name = selectElement.name;
                    sendData[name] = value;
                });
                var selectedValues = $('#potential_account_id').val();
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: '{{ route('imported_customer_data.matchColumnUpdate') }}',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    async: true,
                    data: {
                        "columns": JSON.stringify(sendData),
                        potential_account_id: selectedValues
                    },

                    success: function(data) {
                        $.notify(data.message,
                            data.success == true ? "success" : "error"
                        );
                        if (data.success && data.redirect_url) {
                            setTimeout(function() {
                                window.location.href = data.redirect_url;
                            }, 3000);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("POST request error:", error);
                    }
                });
            });
        </script>


<script>
    let fileColumns_array = @json($fileColumns);
    const selectElements = document.querySelectorAll('select.select3');
    console.log(selectElements);
    selectElements.forEach(selectElement => {
        fileColumns_array.forEach(option => {
            const optionElement = document.createElement('option');
            optionElement.value = option;
            optionElement.textContent = option;
            selectElement.appendChild(optionElement);
        });
    });

    function CheckArray() {
        const selectElements = document.querySelectorAll('select.select3');
        let selectedDataArray = [];
        selectElements.forEach(selectElement => {
            let value = selectElement.value;
            if (value != 0) {
                selectedDataArray.push(value);
            }
            mainArray = fileColumns_array.filter(element => !selectedDataArray.includes(element));
        });

        selectElements.forEach(selectElement => {
            let value = selectElement.value;
            if (value == 0 || value == 'Select') {
                for (let i = selectElement.options.length - 1; i > 0; i--) {
                    selectElement.remove(i);
                }
                mainArray.forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option;
                    optionElement.textContent = option;
                    selectElement.appendChild(optionElement);
                });
            } else {
                for (let i = selectElement.options.length - 1; i > 0; i--) {
                    selectElement.remove(i);
                }
                const optionElement = document.createElement('option');
                optionElement.value = value;
                optionElement.textContent = value;
                optionElement.selected = true;
                selectElement.appendChild(optionElement);
                mainArray.forEach(option => {
                    const optionElement = document.createElement('option');
                    optionElement.value = option;
                    optionElement.textContent = option;
                    selectElement.appendChild(optionElement);
                });
            }
        });
    }
</script>
    @endsection
