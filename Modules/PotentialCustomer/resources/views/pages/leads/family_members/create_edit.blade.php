@extends('dashboard.layouts.app')
@section('title')
    {{ isset($familyMember) ? __('Edit Family Member ') : __('Create New Family Member') }}
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
            <a href="{{ route('family_members.index') }}">{{ __('Family Members') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($familyMember) ? __('Edit :type', ['type' => $familyMember->name]) : __('Create New Family Member') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}



    <div class="container">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($familyMember) ? __('Edit :type', ['type' => $familyMember->name]) : __('Create New Family Member') }}
            </div>
            @include('dashboard.layouts.alerts')
            <form
                action="{{ isset($familyMember) ? route('family_members.update', ['family_member' => $familyMember]) : route('family_members.store') }}"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($familyMember))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="col-lg-12">
                        <x-potentialcustomer::form-personal-image :src="isset($familyMember) && isset($familyMember->image)
                            ? asset('storage/' . $familyMember->image)
                            : asset('dashboard/assets/img/team/avatar.png')" name="personal_image" required/>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-lg-6">
                            <label for="potential_account_id" class="form-label">{{ __('Potential Account') }}</label>
                            <div class="input-group">
                                <select class="form-select js-example-basic-single  fs-xs form-select-sm"
                                    name="potential_account_id" id="potential_account_id"
                                    aria-label="Default select example" required>
                                    @if (!isset($familyMember))
                                        <option value="{{ null }}">{{ __('Select Potential Account') }}</option>
                                    @endif
                                    @foreach ($potentialAccounts as $potentialAccount)
                                        <option @if (isset($familyMember) && $familyMember->potential_account_id == $potentialAccount->id) selected @endif
                                            value="{{ $potentialAccount->id }}">
                                            {{ $potentialAccount->account_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('potential_account_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-3 col-lg-6">
                            <label for="relationship_type_id" class="form-label">{{ __('relationship') }}</label>
                            <div class="input-group">
                                <select class="form-select js-example-basic-single  fs-xs form-select-sm"
                                    name="relationship_type_id" id="relationship_type_id"
                                    aria-label="Default select example" required>
                                    @if (!isset($familyMember))
                                        <option value="{{ null }}">{{ __('Select relationship') }}</option>
                                    @endif
                                    @foreach ($relationships as $relationship)
                                        <option @if (isset($familyMember) && $familyMember->relationship_type_id == $relationship->id) selected @endif
                                            value="{{ $relationship->id }}">
                                            {{ $relationship->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('relationship_type_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <x-potentialcustomer::form-input type="name" :value="isset($familyMember) ? $familyMember->name : old('name')" label="Name" name='name'
                                placeholder='Family Member Name' id="name" required oninput="{{NULL}}" />
                        </div>
                        <div class="col-lg-6">
                            <x-potentialcustomer::form-input type="text" :value="isset($familyMember) ? $familyMember->phone : old('phone')" label="phone" name='phone'
                                placeholder="+201xxxxxxxxxxxxxxx" id="phone"
                                oninput="{this.value = this.value.replace(/[^0-9+]/g, '')}" required />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <x-potentialcustomer::form-input type="text" :value="isset($familyMember) ? $familyMember->national_id : old('national_id')" label="national id"
                                name='national_id' placeholder='{{ null }}' id="national_id" required
                                oninput="{this.value = this.value.replace(/[^0-9+]/g, '')}" required />
                        </div>
                        <div class="col-lg-6">
                            <x-potentialcustomer::form-input type="date" :value="isset($familyMember) ? $familyMember->birth_date : old('birth_date')" label="date of birth"
                                name='birth_date' placeholder="dd/mm/yyyy" id="birth_date" oninput="{{NULL}}" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nationalIdCardInput">Upload
                            National Id Card</label>
                        <input class="form-control" id="nationalIdCardInput" required name="national_id_card"
                            type="file" />
                    </div>
                    <x-potentialcustomer::status-select name='status' :model="isset($familyMember) ? $familyMember : null" />

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
@endsection
