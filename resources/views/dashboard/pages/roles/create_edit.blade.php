@extends('dashboard.layouts.app')
@section('title')
    {{ isset($role) ? __('Edit Role ') : __('Create Role') }}
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
            <a href="{{ route('roles.index') }}">{{ __('Roles') }}</a>
        </x-breadcrumb-item>

        <x-breadcrumb-item active="{{ isset($role) }}">
            {{ isset($role) ? __('Edit :type', ['type' => $role->name]) : __('Create New Role') }}
        </x-breadcrumb-item>
    </x-breadcrumb>
    {{-- End breadcrumb --}}

    <div class="container ">
        <div class="card radius-15 border-lg-top-primary my-5">
            <div class="card-body">
                <div class="card-title">
                    <h4 class="mb-0">
                        {{ isset($role) ? __('Edit :type', ['type' => $role->name]) : __('Create New Role') }}</h4>
                </div>
                <hr>
                <form method="POST"
                    action="{{ isset($role) ? route('roles.update', ['role' => $role]) : route('roles.store') }}">
                    @csrf
                    @if (isset($role))
                        @method('PUT')
                    @endif
                    <div class="card-body">
                        <x-form-input type="text" :value="isset($role) ? $role->name : old('name')" label="Name" name='name' placeholder='role Name'
                            id="role_name" oninput="{{ null }}" required />
                        <x-form-description value="{{ isset($role) ? $role->description : old('description') }}"
                            label="Description" name='description' placeholder='Role Description' />
                        <x-form-select name='status' id="status" label="status" required>
                            <option @if (isset($role) && $role->status == 'active') selected @endif value="active">
                                {{ __('Active') }}</option>
                            <option @if (isset($role) && $role->status == 'inactive') selected @endif value="inactive">
                                {{ __('Inactive') }}</option>
                            <option @if (isset($role) && $role->status == 'draft') selected @endif value="draft">
                                {{ __('Draft') }}</option>
                        </x-form-select>

                        @include('dashboard.layouts.permissions_table')
                        <div class="text-center mt-2">
                            <x-form-submit-button label='Confirm' />

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('dashboard') }}/assets/js/permissions_table.js"></script>
@endsection
