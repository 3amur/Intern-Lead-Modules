@extends('dashboard.layouts.app')
@section('title')
    {{ isset($city) ? __('Edit City ') : __('Create New City') }}
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
            <a href="{{ route('cities.index') }}">{{ __('Cities') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($city) ? __('Edit :type', ['type' => $city->name]) : __('Create New City') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}
    @include('dashboard.layouts.alerts')
    <div class="container ">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($city) ? __('Edit :type', ['type' => $city->name]) : __('Create New Cities') }}
            </div>
            <form action="{{ isset($city) ? route('cities.update', ['city' => $city]) : route('cities.store') }}"
                method="POST">
                @csrf
                @if (isset($city))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <x-potentialcustomer::form-input type="text" :value="isset($city) ? $city->name : old('name')" label="Name" name='name'
                        placeholder='City Name' required id="city_name" oninput="{{ null }}" />


                    <x-potentialcustomer::form-select name='country_id' id="country" label='Country'>
                        <option value="">{{ __('Select :type', ['type' => __('Country')]) }}</option>
                        @foreach ($countries as $country)
                            <option @if (isset($city) && ($city->state->country->id == $country->id || old('country') == $country->id)) selected="selected" @endif
                                value="{{ $country->id }}">
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </x-potentialcustomer::form-select>
                    <x-potentialcustomer::form-select name='state_id' id="state" label='State'>
                        <option value="">{{ __('Select :type', ['type' => __('State')]) }}</option>

                        <option @if (isset($city) && ($state->id == $city->state_id)) selected="selected" @endif
                            value="{{ $city->state_id }}">
                            {{ $city->state->name }}

                    </x-potentialcustomer::form-select>


                    <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                        <option @if (isset($city) && $city->status == 'active') selected @endif value="active">
                            {{ __('Active') }}</option>
                        <option @if (isset($city) && $city->status == 'inactive') selected @endif value="inactive">
                            {{ __('Inactive') }}</option>
                        <option @if (isset($city) && $city->status == 'draft') selected @endif value="draft">
                            {{ __('Draft') }}</option>
                    </x-potentialcustomer::form-select>


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
        $(document).ready(function() {
            const countrySelect = $('#country');
            const stateSelect = $('#state');

            countrySelect.change(function() {
                const countryId = $(this).val();
                const postData = {
                    country_id: countryId,
                }
                $.ajax({
                    url: '{{ route('states.getStates') }}',
                    type: 'POST',
                    data: postData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success && response.data) {

                            stateSelect.empty();
                            stateSelect.html(response.data);

                            stateSelect.prepend('<option value="">Select State</option>');
                        } else {
                            console.error('Empty or unexpected response:', response);
                        }
                    },
                    error: function(error) {
                        console.error('Error fetching states:', error);
                    }
                });
            });
        });
    </script>
@endsection
