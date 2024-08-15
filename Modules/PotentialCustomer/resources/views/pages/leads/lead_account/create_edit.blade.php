@extends('dashboard.layouts.app')
@section('title')
    {{ isset($leadAccount) ? __('Edit Lead Account ') : __('Create New Lead Account') }}
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
            <a href="{{ route('lead_account.index') }}">{{ __('Lead Account') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($leadAccount) ? __('Edit :type', ['type' => $leadAccount->title]) : __('Create New Lead Account') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

    <div class="container">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($leadAccount) ? __('Edit :type', ['type' => $leadAccount->name]) : __('Create New Lead Account') }}
            </div>
            <form
                action="{{ isset($leadAccount) ? route('lead_account.update', ['lead_account' => $leadAccount]) : route('lead_account.store') }}"
                method="POST" enctype="multipart/form-data" id="leadAccountForm">
                @csrf
                @if (isset($leadAccount))
                    @method('PUT')
                @endif
                <div class="card-body">

                    <div class="card-title">
                        <h6>{{ __('Account Details') }}</h6>
                    </div>
                    <div class="col-12">
                        <x-potentialcustomer::form-personal-image :src="isset($leadAccount) && isset($leadAccount->image)
                            ? asset('storage/' . $leadAccount->image)
                            : asset('dashboard/assets/img/team/avatar.png')" name="image" />
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($leadAccount) ? $leadAccount->account_name : old('account_name')" label="Lead Name*"
                                name='account_name' placeholder='Lead Name' required id="account_name" oninput="{{ null }}" />
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($leadAccount) ? $leadAccount->account_contact_name : old('account_contact_name')" label="Contact Name*"
                                name='account_contact_name' placeholder='Contact Name' required id="account_contact_name" oninput="{{ null }}"/>
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($leadAccount)
                                ? $leadAccount->lead_account_title
                                : old('lead_account_title')" label="Contact Title"
                                name='lead_account_title' placeholder='Contact Title' id="lead_account_title"
                                oninput="{{ null }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::form-input type="email" :value="isset($leadAccount) ? $leadAccount->email : old('email')" label="Email" name='email'
                                placeholder='Example@gmail.com' id="email" oninput="{{ null }}" />
                        </div>
                        <div class="col-6">
                            <x-potentialcustomer::form-input type="text" :value="isset($leadAccount) ? $leadAccount->website : old('website')" label="Website" name='website'
                                placeholder="httwww.example.com" id="website" oninput="{{ null }}" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">

                            <x-potentialcustomer::form-select name="country_id" id="country_id" label="Country*" required>
                                <option value="">{{ __('Select :type', ['type' => __('Country')]) }}</option>

                                @foreach ($countries as $id => $name)
                                    <option @if (isset($leadAccount) && ($leadAccount->city->state->country_id == $id || old('country') == $id)) selected="selected" @endif
                                        value="{{ $id }}">
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-select name="state_id" id="state_id" label="State*" required>
                                @if (!isset($leadAccount))
                                    <option value="">{{ __('Select :type', ['type' => __('State')]) }}</option>
                                @endif
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-select name="city_id" id="city_id" label='City*' required>
                                @if (!isset($leadAccount))
                                    <option value="">{{ __('Select :type', ['type' => __('City')]) }}</option>
                                @endif
                            </x-potentialcustomer::form-select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <x-potentialcustomer::form-input type="text" :value="isset($leadAccount) ? $leadAccount->personal_number : old('personal_number')" label="Personal Number*"
                                id="personal_number" name='personal_number' placeholder="Personal Number Ex: 010xxxxxxxxx"
                                oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-input type="text" :value="isset($leadAccount) ? $leadAccount->mobile : old('mobile')" label="Mobile" id="mobile"
                                name='mobile' placeholder="Mobile Ex: 010xxxxxxxxx"
                                oninput="this.value = this.value.replace(/[^0-9+]/g, '')" />
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-input type="text" :value="isset($leadAccount) ? $leadAccount->phone : old('phone')" label="Phone('Landline')" id="phone"
                                name='phone' placeholder="Landline"
                                oninput="this.value = this.value.replace(/[^0-9+]/g, '')" />
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-input type="text" :value="isset($leadAccount) ? $leadAccount->zip_code : old('zip_code')" label="Zip Code"
                                id="zip_code" name='zip_code' placeholder=" Potential Customer zip_code"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" />
                        </div>
                    </div>

                    <x-potentialcustomer::form-description
                        value="{{ isset($leadAccount) ? $leadAccount->address : old('address') }}" label="Address"
                        name='address' placeholder='Write Account address Here ....' id="address" />
                    <x-potentialcustomer::form-description
                        value="{{ isset($leadAccount) ? $leadAccount->notes : old('notes') }}" label="notes"
                        name='notes' placeholder='Write Account  notes Here ....' id="notes" />
                    <hr>
                    <div class="card-title">
                        <h6>{{ __('Account Settings') }}</h6>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::form-select name='status' id="status" label="status*" required>
                                <option @if (isset($leadAccount) && $leadAccount->status == 'active') selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (isset($leadAccount) && $leadAccount->status == 'inactive') selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (isset($leadAccount) && $leadAccount->status == 'draft') selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-6">
                            <x-potentialcustomer::form-select name='sales_agent_id' id="sales_agent_id"
                                label="Assigned To">
                                @if(! isset($leadAccount))
                                <option value="">{{ __('Select :type', ['type' => __('Sales Agents')]) }}</option>
                                @endif
                                @foreach ($salesAgents as $salesAgent)
                                    <option @if (isset($leadAccount) &&
                                            ($leadAccount->sales_agent_id == $salesAgent->id || old('sales_agent_id') == $salesAgent->id)) selected="selected" @endif
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
                                @if (!isset($leadAccount) || !isset($leadAccount->leadSource) )
                                    <option value="">{{ __('Select :type', ['type' => __('Lead Source')]) }}
                                    </option>
                                @endif
                                @foreach ($leadSources as $leadSource)
                                    <option @if (isset($leadAccount) && $leadAccount->lead_source_id == $leadSource->id) selected @endif
                                        value="{{ $leadSource->id }}">
                                        {{ $leadSource->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-select name='lead_status_id' label='Lead Status*'
                                id="lead_status_id" required>
                                @if (!isset($leadAccount) || !isset($leadAccount->leadStatus) )
                                    <option value="">{{ __('Select :type', ['type' => __('Lead Status')]) }}
                                    </option>
                                @endif
                                @foreach ($leadStatuses as $leadStatus)
                                    <option @if (isset($leadAccount) && $leadAccount->lead_status_id == $leadStatus->id) selected @endif
                                        value="{{ $leadStatus->id }}">
                                        {{ $leadStatus->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-3">
                            <x-potentialcustomer::form-select name='lead_value_id' label='Lead Value*' id="lead_value_id"
                                required>
                                @if (!isset($leadAccount) || !isset($leadAccount->leadValue) )
                                    <option value="">{{ __('Select :type', ['type' => __('Lead Value')]) }}
                                    </option>
                                @endif
                                @foreach ($leadValues as $leadValue)
                                    <option @if (isset($leadAccount) && $leadAccount->lead_value_id == $leadValue->id) selected @endif
                                        value="{{ $leadValue->id }}">
                                        {{ $leadValue->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>

                        <div class="col-3">
                            <x-potentialcustomer::form-select name='lead_type_id' label='Lead Type*' id="lead_type_id"
                                required>
                                @if (!isset($leadAccount) || !isset($leadAccount->leadType) )
                                    <option value="">{{ __('Select :type', ['type' => __('Lead Type')]) }}
                                    </option>
                                @endif
                                @foreach ($leadTypes as $leadType)
                                    <option @if (isset($leadAccount) && $leadAccount->lead_type_id == $leadType->id) selected @endif
                                        value="{{ $leadType->id }}">
                                        {{ $leadType->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-muted text-center">
                    <x-potentialcustomer::form-submit-button label='Submit' id="submitBtn" />
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
    @if ((isset($leadAccount) && $leadAccount->city->state->country_id  != 0) || old('country_id'))
        <script>
            $("#country_id").parent().addClass('loading');
            $("#state_id").parent().addClass('loading');
            $.ajax({
                type: "POST",
                url: "{{ route('states.getStates') }}",
                data: {
                    "country_id": "{{ isset($leadAccount) ? $leadAccount->city->state->country_id  : old('country_id') }}",
                    "selected": "{{ isset($leadAccount) ? $leadAccount->city->state_id : old('state_id') }}"
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
    @if ((isset($leadAccount) && $leadAccount->city->state_id != 0) || old('state_id'))
        <script>
            $("#state_id").parent().addClass('loading');
            $('#city_id').parent().addClass('loading');
            $.ajax({
                type: "POST",
                url: "{{ route('cities.getCities') }}",
                data: {
                    "state_id": "{{ isset($leadAccount) ? $leadAccount->city->state_id : old('state_id') }}",
                    "selected": "{{ isset($leadAccount) ? $leadAccount->city_id : old('city_id') }}"
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
            $("#leadAccountForm").validate({
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
                },
                messages: {
                    image: {
                        accept: "Please select a valid image file (png, jpg, jpeg, gif).",
                        filesize: "The image file size must be less than or equal to 2048 KB."
                    },
                    account_name: {
                        required: "Please enter an account name.",
                        maxlength: "Account name must not exceed 100 characters.",
                        minlength: "Account name must be at least 3 characters.",
                    },
                    account_contact_name: {
                        required: "Please enter an Contact name.",
                        maxlength: "Contact name must not exceed 100 characters.",
                        minlength: "Contact name must be at least 3 characters.",
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
                        required: "Please select a lead value.",
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
@endsection
