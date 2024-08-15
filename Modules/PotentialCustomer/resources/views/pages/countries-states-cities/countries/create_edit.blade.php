@extends('dashboard.layouts.app')
@section('title')
    {{ isset($country) ? __('Edit Country ') : __('Create New Country') }}
@endsection
@section('css')
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('lead_home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('countries.index') }}">{{ __('Countries') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item active="{{ isset($country) }}">
            {{ isset($country) ? __('Edit :type', ['type' => $country->name]) : __('Create New Country') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

    <div class="container">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($country) ? __('Edit :type', ['type' => $country->name]) : __('Create New Country') }}
            </div>
            <form
                action="{{ isset($country) ? route('countries.update', ['country' => $country]) : route('countries.store') }}"
                method="POST">
                @csrf
                @if (isset($country))
                    @method('PUT')
                @endif
                <div class="card-body">

                    <x-potentialcustomer::form-input type="text" :value="isset($country) ? $country->name : old('name')" label="Name" name='name'
                        placeholder='Country Name' id="country_name" oninput="{{ null }}" required />
                    <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                        <option @if (isset($country) && $country->status == 'active') selected @endif value="active">
                            {{ __('Active') }}</option>
                        <option @if (isset($country) && $country->status == 'inactive') selected @endif value="inactive">
                            {{ __('Inactive') }}</option>
                        <option @if (isset($country) && $country->status == 'draft') selected @endif value="draft">
                            {{ __('Draft') }}</option>
                    </x-potentialcustomer::form-select>
                </div>
                <div class="card-footer text-muted text-center">

                <x-potentialcustomer::form-submit-button id="submitBtn"  label='Confirm'/>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
@endsection
