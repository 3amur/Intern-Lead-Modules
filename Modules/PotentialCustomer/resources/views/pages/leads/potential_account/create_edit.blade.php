@extends('dashboard.layouts.app')
@section('title')
    {{ isset($potentialAccount) ? __('Edit Potential Customer ') : __('Create New Potential Customer') }}
@endsection
@section('css')
    <style>
        .custom-avatar {
            display: inline-block;
            position: relative;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
        }

        .custom-avatar img {
            border-radius: 50%;
            width: 100%;
            height: 100%;
            transition: opacity 0.25s;
            display: block;
        }

        .custom-avatar .overlay {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.25s;
        }

        .custom-avatar:hover img,
        .custom-avatar:hover .overlay {
            opacity: 1;
        }

        .custom-avatar .icon {
            color: #ffffff;
            font-size: 32px;
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
            <a href="{{ route('potential_account.index') }}">{{ __('Potential Customer') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($potentialAccount) ? __('Edit :type', ['type' => $potentialAccount->title]) : __('Create New Potential Customer') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End bread crumb --}}
    @include('dashboard.layouts.alerts')
    <div class="container">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($potentialAccount) ? __('Edit :type', ['type' => $potentialAccount->name]) : __('Create New Potential Customer') }}
            </div>



            <form
                action="{{ isset($potentialAccount) ? route('potential_account.update', ['potential_account' => $potentialAccount]) : route('potential_account.store') }}"
                method="POST" enctype="multipart/form-data" id="potentialAccountForm">
                @csrf
                @if (isset($potentialAccount))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="card-title">
                        <h6>{{ __('Account Details') }}</h6>
                    </div>
                    <div class="col-12">
                        <x-potentialcustomer::form-personal-image :src="isset($potentialAccount) && isset($potentialAccount->image)
                            ? asset('storage/' . $potentialAccount->image)
                            : asset('dashboard/assets/img/team/avatar.png')" name="image" />
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($potentialAccount) ? $potentialAccount->account_name : old('account_name')" label="Customer Name*"
                                name='account_name' placeholder='Customer Name' required id="account_name"
                                oninput="{{ null }}" id="account_name" />
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($potentialAccount)
                                ? $potentialAccount->account_contact_name
                                : old('account_contact_name')" label="Contact Name*"
                                name='account_contact_name' placeholder='Contact Name' required id="account_contact_name"
                                oninput="{{ null }}" />
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($potentialAccount)
                                ? $potentialAccount->lead_account_title
                                : old('lead_account_title')" label="Customer title"
                                name='lead_account_title' placeholder='Customer Title' id="lead_account_title"
                                oninput="{{ null }}" />
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::form-input type="email" :value="isset($potentialAccount) ? $potentialAccount->email : old('email')" label="Email" name='email'
                                placeholder='Example@gmail.com' id="email" oninput="{{ null }}" />
                        </div>
                        <div class="col-6">
                            <x-potentialcustomer::form-input type="text" :value="isset($potentialAccount) ? $potentialAccount->website : old('website')" label="Website" name='website'
                                placeholder="https://www.example.com" id="website" oninput="{{ null }}" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <x-potentialcustomer::form-input type="text" :value="isset($potentialAccount)
                                ? $potentialAccount->personal_number
                                : old('personal_number')" label="Personal Number*"
                                id="personal_number" name='personal_number' placeholder="Personal Number Ex: 010xxxxxxxxx"
                                oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-input type="text" :value="isset($potentialAccount) ? $potentialAccount->mobile : old('mobile')" label="Mobile" id="mobile"
                                name='mobile' placeholder="Mobile Ex: 010xxxxxxxxx"
                                oninput="this.value = this.value.replace(/[^0-9+]/g, '')" />
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-input type="text" :value="isset($potentialAccount) ? $potentialAccount->phone : old('phone')" label="Phone ('landline')" id="phone"
                                name='phone' placeholder="Landline"
                                oninput="this.value = this.value.replace(/[^0-9+]/g, '')" />
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-input type="text" :value="isset($potentialAccount) ? $potentialAccount->zip_code : old('zip_code')" label="Zip Code"
                                id="zip_code" name='zip_code' placeholder=" Potential Customer zip_code"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-4">
                            <x-potentialcustomer::form-select name="country_id" id="country_id" label="Country*" required>
                                <option value="">{{ __('Select :type', ['type' => __('Country')]) }}</option>
                                @foreach ($countries as $id => $name)
                                    <option @if (isset($potentialAccount) && ($potentialAccount->city->state->country_id == $id || old('country') == $id)) selected="selected" @endif
                                        value="{{ $id }}">
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-select name="state_id" id="state_id" label="State*" required>
                                @if (!isset($potentialAccount))
                                    <option value="">{{ __('Select :type', ['type' => __('State')]) }}</option>
                                @endif
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-select name="city_id" id="city_id" label='City*' required>
                                @if (!isset($potentialAccount))
                                    <option value="">{{ __('Select :type', ['type' => __('City')]) }}</option>
                                @endif
                            </x-potentialcustomer::form-select>
                        </div>
                    </div>
                    <x-potentialcustomer::form-description
                        value="{{ isset($potentialAccount) ? $potentialAccount->address : old('address') }}"
                        label="Address" name='address' placeholder='Write Potential Customer address Here ....'
                        id="address" />
                    <x-potentialcustomer::form-description
                        value="{{ isset($potentialAccount) ? $potentialAccount->notes : old('notes') }}" label="notes"
                        name='notes' placeholder='Write Potential Customer notes Here ....' id="notes" />

                    <hr>


                    <div class="card-title">
                        <h6>{{ __('Account Setting') }}</h6>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::form-select name='status' id="status" label="status*" required>
                                <option @if (isset($potentialAccount) && $potentialAccount->status == 'active') selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (isset($potentialAccount) && $potentialAccount->status == 'inactive') selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (isset($potentialAccount) && $potentialAccount->status == 'draft') selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </x-potentialcustomer::form-select>
                        </div>

                        <div class="col-6">
                            <x-potentialcustomer::form-select name='sales_agent_id' id="sales_agent_id"
                                label="Assigned To">
                                @if (!isset($potentialAccount))
                                    <option value="">{{ __('Select :type', ['type' => __('Sales Agents')]) }}
                                    </option>
                                @endif
                                @foreach ($salesAgents as $salesAgent)
                                    <option @if (isset($potentialAccount) &&
                                            ($potentialAccount->sales_agent_id == $salesAgent->id || old('sales_agent_id') == $salesAgent->id)) selected="selected" @endif
                                        value="{{ $salesAgent->id }}">
                                        {{ $salesAgent->name }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-3">
                            <x-potentialcustomer::form-select name='lead_source_id' label='Lead Source*'
                                id="lead_source_id" required>
                                @if (!isset($potentialAccount) || !isset($leadAccount->lead_source_id))
                                    <option value="">{{ __('Select :type', ['type' => __('Lead Source')]) }}
                                    </option>
                                @endif
                                @foreach ($leadSources as $leadSource)
                                    <option @if (isset($potentialAccount) && $potentialAccount->lead_source_id == $leadSource->id) selected @endif
                                        value="{{ $leadSource->id }}">
                                        {{ $leadSource->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-select name='lead_status_id' label='Lead Status*'
                                id="lead_status_id" required>
                                @if (!isset($potentialAccount) || !isset($leadAccount->lead_status_id))
                                    <option value="">{{ __('Select :type', ['type' => __('Lead Status')]) }}
                                    </option>
                                @endif

                                @foreach ($leadStatuses as $leadStatus)
                                    <option @if (isset($potentialAccount) && $potentialAccount->lead_status_id == $leadStatus->id) selected @endif
                                        value="{{ $leadStatus->id }}">
                                        {{ $leadStatus->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-select name='lead_value_id' label='Lead Value*' id="lead_value_id"
                                required>
                                @if (!isset($potentialAccount) || !isset($leadAccount->lead_value_id))
                                    <option value="">{{ __('Select :type', ['type' => __('Lead Value')]) }}
                                    </option>
                                @endif
                                @foreach ($leadValues as $leadValue)
                                    <option @if (isset($potentialAccount) && $potentialAccount->lead_value_id == $leadValue->id) selected @endif
                                        value="{{ $leadValue->id }}">
                                        {{ $leadValue->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>

                        <div class="col-3">
                            <x-potentialcustomer::form-select name='lead_type_id' label='Lead Type*' id="lead_type_id"
                                required>
                                @if (!isset($potentialAccount) || !isset($leadAccount->lead_type_id))
                                    <option value="">{{ __('Select :type', ['type' => __('Lead Type')]) }}
                                    </option>
                                @endif
                                @foreach ($leadTypes as $leadType)
                                    <option @if (isset($potentialAccount) && $potentialAccount->lead_type_id == $leadType->id) selected @endif
                                        value="{{ $leadType->id }}">
                                        {{ $leadType->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                    </div>
                    <hr>
                    <div class="card-title">
                        <h6>{{ __('Account Sales Details') }}</h6>
                    </div>

                    <div class="row">
                        <div class="col">
                            <x-potentialcustomer::form-select name='current_insurer' id="current_insurer"
                                label="Current insurer">
                                <option value="">
                                    {{ __('Select :type', ['type' => __('Current insurer')]) }}
                                </option>
                                <option @if (isset($potentialAccountDetails) && $potentialAccountDetails->current_insurer === 'yes') selected @endif value= 'yes'>
                                    {{ __('Yes') }}
                                </option>
                                <option @if (isset($potentialAccountDetails) && $potentialAccountDetails->current_insurer === 'no') selected @endif value='no'>
                                    {{ __('No') }}
                                </option>
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col">
                            <x-potentialcustomer::form-select name='utilization' id="utilization" label="Utilization">
                                <option value="">
                                    {{ __('Select :type', ['type' => __('Utilization')]) }}
                                </option>
                                <option @if (isset($potentialAccountDetails) && $potentialAccountDetails->utilization === 'yes') selected @endif value="yes">
                                    {{ __('Yes') }}
                                </option>
                                <option @if (isset($potentialAccountDetails) && $potentialAccountDetails->utilization === 'no') selected @endif value="no">
                                    {{ __('No') }}
                                </option>
                            </x-potentialcustomer::form-select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::date-input label="{{ __('Starting Date') }}" name="starting_date"
                                value="{{ isset($potentialAccountDetails) ? $potentialAccountDetails->starting_date : old('starting_date') }}" id="starting_date" />
                        </div>
                        <div class="col-6">
                            <x-potentialcustomer::percentage-input label="Chance of Sale" name="chance_of_sale"
                                id="chance_of_sale"
                                value="{{ isset($potentialAccountDetails) ? $potentialAccountDetails->chance_of_sale : old('chance_of_sale') }}"/>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <x-potentialcustomer::currency-input
                                value="{{ isset($potentialAccountDetails) && $potentialAccountDetails->potential_premium > 0 ? number_format($potentialAccountDetails->potential_premium, 2, '.', ',') : old('potential_premium') }}"
                                label="Potential Premium" id="potential_premium" name='potential_premium'
                                placeholder="1,000,000 L.E" />
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::currency-input
                                value="{{ isset($potentialAccountDetails) && $potentialAccountDetails->price_range_min > 0 ? number_format($potentialAccountDetails->price_range_min, 2, '.', ',') : old('price_range_min') }}"
                                label="Min Price Range" id="price_range_min" name='price_range_min'
                                placeholder="1,000,000 L.E" />
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::currency-input
                                value="{{ isset($potentialAccountDetails) && $potentialAccountDetails->price_range_max > 0 ? number_format($potentialAccountDetails->price_range_max, 2, '.', ',') : old('price_range_max') }}"
                                label="Max Price Range" id="price_range_max" name='price_range_max'
                                placeholder="1,000,000 L.E" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <x-potentialcustomer::form-description
                                value="{{ isset($potentialAccountDetails) ? $potentialAccountDetails->reason : old('reason') }}"
                                label="Reason" name='reason' placeholder='Reasons ...' id="reason" />
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <x-potentialcustomer::form-submit-button id="submitBtn" label='Confirm' />
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script>
        function openFileInput() {
            document.getElementById('fileInput').click();
        }

        function handleFileSelect() {
            const fileInput = document.getElementById('fileInput');
            const avatarImage = document.getElementById('avatar');

            const selectedFile = fileInput.files[0];

            if (selectedFile) {

                const reader = new FileReader();

                reader.onload = function(e) {
                    avatarImage.src = e.target.result;
                };

                reader.readAsDataURL(selectedFile);
            }
        }
    </script>
    @if ((isset($potentialAccount) && $potentialAccount->city->state->country_id != 0) || old('country_id'))
        <script>
            $("#country_id").parent().addClass('loading');
            $("#state_id").parent().addClass('loading');
            $.ajax({
                type: "POST",
                url: "{{ route('states.getStates') }}",
                data: {
                    "country_id": "{{ isset($potentialAccount) ? $potentialAccount->city->state->country_id : old('country_id') }}",
                    "selected": "{{ isset($potentialAccount) ? $potentialAccount->city->state_id : old('state_id') }}"
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(response) {
                    $("#country_id").parent().removeClass('loading');
                    $("#state_id").html(response.data).trigger('change.select2');
                    $("#state_id").parent().removeClass('loading');
                }
            });
        </script>
    @endif
    @if ((isset($potentialAccount) && $potentialAccount->city->state_id != 0) || old('state_id'))
        <script>
            $("#state_id").parent().addClass('loading');
            $('#city_id').parent().addClass('loading');
            $.ajax({
                type: "POST",
                url: "{{ route('cities.getCities') }}",
                data: {
                    "state_id": "{{ isset($potentialAccount) ? $potentialAccount->city->state_id : old('state_id') }}",
                    "selected": "{{ isset($potentialAccount) ? $potentialAccount->city_id : old('city_id') }}"
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(response) {
                    console.log(response);
                    $("#state_id").parent().removeClass('loading');
                    $("#city_id").html(response.data).trigger('change.select2');
                    $('#city_id').parent().removeClass('loading');
                }
            });
        </script>
    @endif

    <script>
        $(document).on('change', '#country_id', function() {
            el = $(this);
            let country_id = el.val();
            el.parent().addClass('loading');
            $('#state_id').parent().addClass('loading');
            $.ajax({
                type: "POST",
                url: "{{ route('states.getStates') }}",
                data: {
                    country_id
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(response) {
                    el.parent().removeClass('loading');
                    $("#state_id").html(response.data);
                    $('#state_id').parent().removeClass('loading');
                }
            });
        });
        $(document).on('change', '#state_id', function() {
            el = $(this);
            let state_id = el.val();
            el.parent().addClass('loading');
            $('#city_id').parent().addClass('loading');
            $.ajax({
                type: "POST",
                url: "{{ route('cities.getCities') }}",
                data: {
                    state_id
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(response) {
                    el.parent().removeClass('loading');
                    $("#city_id").html(response.data);
                    $('#city_id').parent().removeClass('loading');
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $("#potentialAccountForm").validate({
                rules: {
                    account_name: {
                        required: true,
                        maxlength: 100,
                        minlength: 3,
                    },
                    account_contact_name: {
                        required: true,
                        maxlength: 100,
                        minlength: 3,
                    },
                    lead_account_title: {
                        maxlength: 100,
                        minlength: 3,
                    },
                    email: {
                        email: true,
                    },
                    website: {
                        url: true,
                    },
                    personal_number: {
                        required: true,
                        minlength: 11,
                        maxlength: 15,

                    },
                    mobile: {
                        minlength: 11,
                        maxlength: 15,

                    },
                    phone: {
                        minlength: 7,
                        maxlength: 15,
                    },
                    lead_source_id: {
                        required: true,

                    },
                    lead_status_id: {
                        required: true,

                    },
                    lead_value_id: {
                        required: true,

                    },
                    lead_type_id: {
                        required: true,

                    },
                    sales_agent_id: {
                        required: true,
                    },
                    country_id: {
                        required: true,

                    },
                    state_id: {
                        required: true,

                    },
                    city_id: {
                        required: true,

                    },
                    zip_code: {
                        maxlength: 10,
                        minlength: 3,
                    },
                    address: {
                        maxlength: 500,
                        minlength: 3,
                    },
                    notes: {
                        maxlength: 500,
                        minlength: 3,
                    },
                    status: {
                        required: true,
                    },
                    starting_date: {
                        date: true
                    },
                    chance_of_sale: {
                        number: true,
                        min: 0,
                        max: 100
                    },
                    price_range_min: {
                        min: 0
                    },
                    price_range_max: {
                        min: function() {
                            return parseFloat($('#price_range_min').val()) ||
                            0;
                        }
                    },
                    reason: {
                        maxlength: 500
                    }
                },
                messages: {

                    account_name: {
                        required: "Please enter an account name.",
                        maxlength: "Account name must not exceed 100 characters.",
                        minlength: "Account name must be at least 3 characters.",
                    },
                    account_name: {
                        required: "Please enter an account name.",
                        maxlength: "Account name must not exceed 100 characters.",
                        minlength: "Account name must be at least 3 characters.",
                    },
                    lead_account_title: {
                        maxlength: "Lead account title must not exceed 100 characters.",
                        minlength: "Lead account title must be at least 3 characters.",
                    },
                    email: {
                        email: "Please enter a valid email address.",
                    },
                    website: {
                        url: "Please enter a valid URL for the website."
                    },
                    personal_number: {
                        required: "Please enter a personal number.",
                        minlength: "Personal number must be at least 11 characters.",
                        maxlength: "Personal number must not exceed 15 characters.",
                    },
                    mobile: {
                        minlength: "Mobile number must be at least 11 characters.",
                        maxlength: "Mobile number must not exceed 15 characters.",
                    },
                    phone: {
                        minlength: "Phone number must be at least 7 characters.",
                        maxlength: "Phone number must not exceed 15 characters."
                    },
                    lead_source_id: {
                        required: "Please select a lead source.",
                    },
                    lead_status_id: {
                        required: "Please select a lead status.",
                    },
                    lead_value_id: {
                        required: "Please select a lead value.",
                    },
                    lead_type_id: {
                        required: "Please select a lead Type.",
                    },
                    sales_agent_id: {
                        required: "Please select a Sales Agent.",
                    },
                    country_id: {
                        required: "Please select a country.",
                    },
                    state_id: {
                        required: "Please select a state.",
                    },
                    city_id: {
                        required: "Please select a city.",
                    },
                    zip_code: {
                        maxlength: "Zip code must not exceed 10 characters."
                    },
                    address: {
                        maxlength: "Address must not exceed 500 characters.",
                        minlength: "Address must be at least 3 characters.",
                    },
                    notes: {
                        maxlength: "Notes must not exceed 500 characters.",
                        minlength: "Notes must be at least 3 characters.",
                    },
                    status: {
                        required: "Please enter a status.",
                    },

                    starting_date: {
                        date: "Please enter a valid date."
                    },
                    chance_of_sale: {
                        min: "Chance of sale must be at least 0.",
                        max: "Chance of sale must be at most 100."
                    },
                    price_range_min: {
                        min: "Minimum price range must be at least 0."
                    },
                    price_range_max: {
                        min: "Maximum price range must be greater than or equal to minimum price range."
                    },
                    reason: {
                        maxlength: "Reason must not exceed 500 characters."
                    }
                },

                errorClass: "error text-danger",
                errorElement: "span",
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass(errorClass).removeClass(validClass);
                    $(element.form).find("label[for=" + element.id + "]").addClass(errorClass);
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass(errorClass).addClass(validClass);
                    $(element.form).find("label[for=" + element.id + "]").removeClass(errorClass);
                },
            });
        });
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
