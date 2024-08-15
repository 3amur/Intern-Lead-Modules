@extends('dashboard.layouts.app')
@section('title')
    {{ isset($user) ? __('Edit User ') : __('Create User') }}
@endsection
@section('css')
    <style>
        .custom-avatar {
            display: inline-block;
            position: relative;
            width: 150px;
            height: 150px;
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

<style>
    .provider-roles-card {
        max-height: 200px;
        /* Set the maximum height for the card */
        height: 100%;
        margin-top: 20px !important;
        overflow-y: auto;
        /* Enable vertical scrolling */
        scrollbar-width: 5px !important;
        /* Set the scrollbar width */
        scrollbar-color: rgba(148, 147, 147, 0.5) rgba(0, 0, 0, 0);
        /* Set the scrollbar track and thumb colors */
    }

    /* Customizing scrollbar track */
    .provider-roles-card::-webkit-scrollbar {
        width: 5px !important;
        /* Set the width of the scrollbar */
    }

    /* Customizing scrollbar thumb */
    .provider-roles-card::-webkit-scrollbar-thumb {
        background-color: rgba(243, 243, 243, 0.5);
        /* Set the color of the scrollbar thumb */
        border-radius: 4px !important;
        /* Set the border radius of the scrollbar thumb */
    }

    .form-check-lg {
        width: 26px;
        height: 26px;
        margin-right: 8px;
    }
</style>
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-breadcrumb>
        <x-breadcrumb-item>
            <a href="{{ route('home.index') }}">{{ __('Home') }}</a>
        </x-breadcrumb-item>

        <x-breadcrumb-item>
            <a href="{{ route('users.index') }}">{{ __('Users') }}</a>
        </x-breadcrumb-item>

        <x-breadcrumb-item active="{{ isset($user) }}">
            {{ isset($user) ? __('Edit :type', ['type' => $user->name]) : __('Create New User') }}
        </x-breadcrumb-item>
    </x-breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        @include('dashboard.layouts.alerts')
        <div class="card radius-15 border-lg-top-primary">
            <div class="card-title">
                <h4 class="m-3 mb-0">{{ isset($user) ? __('Edit :type', ['type' => $user->name]) : __('Create New User') }}
                </h4>
            </div>
            <hr>
            <form method="POST"
                action="{{ isset($user) ? route('users.update', ['user' => $user]) : route('users.store') }}"
                enctype="multipart/form-data" id="userForm">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="col-lg-12">
                        <x-form-personal-image :src="isset($user) && isset($user->image)
                            ? asset('storage/' . $user->image)
                            : asset('dashboard/assets/img/team/avatar.png')" name="image" />
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <x-form-input type='text' :value="isset($user) ? $user->name : old('name')" label="Name" name='name'
                                placeholder='User Name' id="name" oninput="" required />
                        </div>
                        <div class="col-6">
                            <x-form-input type='email' :value="isset($user) ? $user->email : old('email')" label="email" name='email'
                                placeholder='User Email' id="email" oninput="" required />
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-6">
                            <x-form-password :value="old('password')" label="password" name='password' placeholder='Your Password'
                                id="password" />
                        </div>
                        <div class="col-6">
                            <x-form-password :value="old('password_confirmation')" label="Confirm Password" name='password_confirmation'
                                placeholder='Confirm Your Password ' id="password_confirmation" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <x-form-select name='status' id="status" label="status" required>
                                <option @if (isset($user) && $user->status == 'active') selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (isset($user) && $user->status == 'inactive') selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (isset($user) && $user->status == 'draft') selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </x-form-select>
                        </div>
                        <div class="col-6">
                            <div class="form-group mb-3">
                                <label for="" class="form-label">{{ __('Role') }}</label>
                                <select class="form-select js-example-basic-multiple" id="role_id" multiple="multiple"
                                    data-options='{"removeItemButton":true,"placeholder":true}'
                                    data-placeholder="{{ __('Select :type', ['type' => __('Role')]) }}" name="role_id[]"
                                    required>
                                    @foreach (\Spatie\Permission\Models\Role::where('status', 'active')->pluck('name', 'id')->toArray() as $id => $name)
                                        <option
                                            @if (isset($user) && in_array($id, $user->roles()->pluck('id')->toArray())) selected="selected"
                        @elseif(old('role_id') && in_array($id, old('role_id'))) selected="selected" @endif
                                            value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="title_container"></div>


                    @include('dashboard.layouts.permissions_table')
                    @php
                        $groups = \Spatie\Permission\Models\Permission::select(
                            'group',
                            \Illuminate\Support\Facades\DB::raw("COUNT('x')"),
                        )
                            ->groupBy('group')
                            ->orderBy(\Illuminate\Support\Facades\DB::raw("COUNT('x')"), 'DESC')
                            ->pluck('group')
                            ->toArray();

                        foreach ($groups as $group) {
                            /* dd(
                                \Spatie\Permission\Models\Permission::where('group', $group)
                                    ->get()
                                    ->count(),
                            ); */
                        }
                    @endphp
                </div>
                <div class="text-center mt-2">
                    <x-form-submit-button label='Confirm' />

                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('dashboard') }}/assets/js/permissions_table.js"></script>
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
        function roleData(role_id) {
            $.ajax({
                url: "{{ route('roles.rolesPermissions') }}",
                method: "POST",
                data: {
                    'array': JSON.stringify(role_id)
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                success: function(data) {
                    updateCheckboxes(data.data);
                },
                error: function() {
                    console.log('Error fetching data');
                }
            });
        }

        function updateCheckboxes(selectedPermissions) {
            $('input[name="permissions[]"]').prop('checked', false).prop('hidden', false);
            console.log("Number of permissions: " + selectedPermissions.length);

            var userPermissions = {!! !empty($user) ? json_encode($user->permissions) : '[]' !!};

            userPermissions.forEach(function(permission) {
                var trimmedValue = $.trim(permission.name);
                $('input[value="' + trimmedValue + '"]').prop('checked', false).prop('readonly', false);
            });


            selectedPermissions.forEach(function(permission) {
                var trimmedValue = $.trim(permission.name);
                $('input[value="' + trimmedValue + '"]').prop('checked', true).addClass('checkbox_readonly');
            });
        }

        $(document).ready(function() {
            $('#role_id').on('change', function() {
                var selectedRoles = $(this).val();
                roleData(selectedRoles);
            });
            roleData($('#role_id').val());

            $(document).on('click', '.checkbox_readonly,#roles_select_all', function() {
                if (!this.checked) {
                    return false;
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to toggle title container visibility
            function toggleTitleContainer(show) {
                if (show) {
                    $('#title_container').empty();
                    $('#title_container').append(`
                        <div class="col-12" id='title_type_group'>
                            <x-form-select name="title_type" id="title_type" label='Title Type' required>
                                @if (!isset($user) || empty(old('title_type')))
                                    <option value="">{{ __('Select :type', ['type' => __('Title Type')]) }}</option>
                                @endif
                                <option @if (isset($user) && $user->title_type == 'manger') selected @endif value="manger">
                                    {{ __('Manger') }}</option>
                                <option @if (isset($user) && $user->title_type == 'team_leader') selected @endif value="team_leader">
                                    {{ __('Team Leader') }}</option>
                                <option @if (isset($user) && $user->title_type == 'agent') selected @endif value="agent">
                                    {{ __('Agent') }}</option>
                            </x-form-select>
                        </div>
                    `);
                } else {
                    $('#title_type_group').remove();
                }
            }

            // Initial hide of title container
            toggleTitleContainer(false);

            // AJAX request function
            function fetchRoleData(roleId) {
                $.ajax({
                    url: '{{ route('users.getRole') }}',
                    data: {
                        role_id: roleId
                    },
                    method: 'GET',
                    success: function(response) {
                        console.log(response.data);
                        toggleTitleContainer(response.data.includes('sales'));
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }

            // Fetch role data on document ready
            fetchRoleData($('#role_id').val());

            // Event handler for role change
            $('#role_id').on('change', function() {
                fetchRoleData($(this).val());
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            $('#userForm').validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 150
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        minlength: 8
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: '#password'
                    },
                    image: {
                        accept: 'image/png,image/jpeg,image/gif,image/svg',
                        filesize: 2048
                    },
                    title_type:{
                        required: true,
                    },
                    status: {
                        required: true
                    },
                    'role_id[]':{
                        required:true,
                    }
                },
                messages: {
                    name: {
                        required: 'Please enter your name.',
                        maxlength: 'Name must not exceed 150 characters.'
                    },
                    email: {
                        required: 'Please enter your email address.',
                        email: 'Please enter a valid email address.',
                    },
                    password: {
                        required: 'Please enter your password.',
                        minlength: 'Password must be at least 6 characters long.'
                    },
                    password_confirmation: {
                        required: 'Please confirm your password.',
                        equalTo: 'Passwords do not match.'
                    },
                    image: {
                        accept: 'Please upload an image of type: png, jpg, jpeg, gif, svg.',
                        filesize: 'File size must be less than 2MB.'
                    },
                    title_type:{
                    required: 'Please enter title.',

                    },
                    status: {
                        required: 'Please select a status.'
                    },
                    'role_id[]':{
                        required: 'Please select a role.'
                    }
                },
                errorClass: "error text-danger fs--1",
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
