@extends('dashboard.layouts.app')
@section('title')
    {{ isset($state) ? __('Edit State ') : __('Create New State') }}
@endsection
@section('css')
@endsection
@section('content')
    <!-- Your View.blade.php -->
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('lead_home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('states.index') }}">{{ __('States') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item active="{{ isset($state) }}">
            {{ isset($state) ? __('Edit :type', ['type' => $state->name]) : __('Create New State') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

    <div class="container">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($state) ? __('Edit :type', ['type' => $state->name]) : __('Create New State') }}
            </div>
            <form action="{{ isset($state) ? route('states.update', ['state' => $state]) : route('states.store') }}"
                method="POST">
                @csrf
                @if (isset($country))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <x-potentialcustomer::form-input type="text" :value="isset($state) ? $state->name : old('name')" label="Name" name='name'
                        placeholder='State Name' id="state_name" oninput="{{ null }}" required />




                    <x-potentialcustomer::form-select name='country_id' id="country" label='Country'>
                        <option value="">{{ __('Select :type', ['type' => __('Country')]) }}</option>
                        @foreach ($countries as $oldCountry)
                            <option @if (isset($country) && ($country->id == $oldCountry->id || old('country') == $oldCountry->id)) selected="selected" @endif
                                value="{{ $oldCountry->id }}">
                                {{ $oldCountry->name }}
                            </option>
                        @endforeach
                    </x-potentialcustomer::form-select>


                    <x-potentialcustomer::form-select name='status' id="status"
                        label="status" required>
                        <option @if (isset($state) && $state->status == 'active') selected @endif value="active">
                            {{ __('Active') }}</option>
                        <option @if (isset($state) && $state->status == 'inactive') selected @endif value="inactive">
                            {{ __('Inactive') }}</option>
                        <option @if (isset($state) && $state->status == 'draft') selected @endif value="draft">
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
