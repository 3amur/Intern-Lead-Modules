@extends('dashboard.layouts.app')
@section('title')
    {{ isset($broker) ? __('Edit Broker') : __('Create New Broker') }}
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
            <a href="{{ route('brokers.index') }}">{{ __('Brokers') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($broker) ? __('Edit :type', ['type' => $broker->name]) : __('Create New Broker') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        @include('dashboard.layouts.alerts')
        <div class="card my-3">
            <div class="card-header">
                {{ isset($broker) ? __('Edit :type', ['type' => $broker->name]) : __('Create New Broker') }}
            </div>
            <form
                action="{{ isset($broker) ? route('brokers.update', ['broker' => $broker]) : route('brokers.store') }}"
                method="POST" enctype="multipart/form-data" id="brokerForm">
                @csrf
                @if (isset($broker))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="col-lg-12">
                        <x-potentialcustomer::form-personal-image :src="isset($broker) && isset($broker->image)
                            ? asset('storage/' . $broker->image)
                            : asset('dashboard/assets/img/team/avatar.png')" name="image" />
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($broker) ? $broker->name : old('name')" label="Broker Name" name='name'
                                placeholder='Broker Name' id="name" oninput="{{ null }}" required />
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($broker) ? $broker->email : old('email')" label="Broker Email" name='email'
                                placeholder='Broker Email' id="email" oninput="{{ null }}" required />
                        </div>
                        <div class="col-4">
                            <x-potentialcustomer::form-input type="text" :value="isset($broker) ? $broker->phone : old('phone')" label="Phone" id="phone"
                                name='phone' placeholder=" Phone"
                                oninput="this.value = this.value.replace(/[^0-9+]/g, '')" required />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <x-potentialcustomer::form-select name='broker_type_id' label='Broker Type' id="broker_type" required>
                                @if (!isset($broker))
                                    <option value="">{{ __('Select :type', ['type' => __('Broker Type')]) }}</option>
                                @endif
                                @foreach ($brokerTypes as $brokerType)
                                    <option @if ((isset($broker) && $broker->broker_type_id == $brokerType->id) || old('broker_type_id') == $brokerType->id) selected @endif
                                        value="{{ $brokerType->id }}">
                                        {{ $brokerType->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>
                        </div>
                        <div class="col-6">
                            <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                                <option @if (isset($broker) && $broker->status == 'active') selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (isset($broker) && $broker->status == 'inactive') selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (isset($broker) && $broker->status == 'draft') selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </x-potentialcustomer::form-select>
                        </div>
                    </div>
                    <div class="card-footer text-muted text-center">
                        <x-potentialcustomer::form-submit-button id="submitBtn"  label='Confirm'/>
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
<script>
    $(document).ready(function() {
        $("#brokerForm").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                },
                email: {
                    email: true,
                    required: true,
                },
                phone: {
                    required: true,
                    minlength: 11,
                    maxlength: 15,
                },
                national_id:{
                    required:false
                    minlength: 14,
                    maxlength: 20,
                },
                broker_type_id: {
                    required: true,
                },
            },
            messages: {
                name: {
                    required: 'Name field is required.',
                    minlength: 'Name field must be at least 4 characters',
                    maxlength: 'Name field must not exceed 100 characters.',
                },
                email: {
                    email: "Please enter a valid email address.",
                    required: 'Email field is required.',
                },
                phone: {
                    required: 'Phone field is required.',
                    minlength: "Phone number must be at least 11 characters.",
                    maxlength: "Phone number must not exceed 15 characters."
                },
                national_id: {
                    minlength: "National Id must be at least 14 characters.",
                    maxlength: "National Id must not exceed 20 characters."
                },
                broker_type_id: {
                    required: "Please select a Broker Type.",
                },

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

