@extends('dashboard.layouts.app')
@section('title')
    {{ isset($team) ? __('Edit Team ') : __('Create New Team') }}
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
            <a href="{{ route('teams.index') }}">{{ __('Team') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($team) ? __('Edit :type', ['type' => $team->title]) : __('Create New Team') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($team) ? __('Edit :type', ['type' => $team->title]) : __('Create New Team') }}
            </div>
            <form action="{{ isset($team) ? route('teams.update', ['team' => $team]) : route('teams.store') }}" method="POST"
                id="leadSourceForm">
                @csrf
                @if (isset($team))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <x-potentialcustomer::form-input type="text" :value="isset($team) ? $team->title : old('title')" label="Title" name='title'
                        placeholder='Team Title' id="title" oninput="{{ null }}" required />
                    <x-potentialcustomer::form-description
                        value="{{ isset($team) ? $team->description : old('description') }}" label="Description"
                        name='description' placeholder='Team Description' id="description" />
                    <div class="row">
                        <div class="col-6">

                            <x-potentialcustomer::form-select name='department_id' id="department_id" label="Department"
                                required>
                                @if (!isset($team))
                                    <option value="">{{ __('Select :type', ['type' => __('Department')]) }}
                                    </option>
                                @endif
                                @foreach ($departments as $department)
                                    <option @if (isset($team) && $team->department_id == $department->id) selected @endif
                                        value="{{ $department->id }}">
                                        {{ $department->title }}
                                    </option>
                                @endforeach
                            </x-potentialcustomer::form-select>


                        </div>
                        <div class="col-6">

                            <x-form-select name='status' id="status" label="status" required>
                                <option @if (isset($team) && $team->status == 'active') selected @endif value="active">
                                    {{ __('Active') }}</option>
                                <option @if (isset($team) && $team->status == 'inactive') selected @endif value="inactive">
                                    {{ __('Inactive') }}</option>
                                <option @if (isset($team) && $team->status == 'draft') selected @endif value="draft">
                                    {{ __('Draft') }}</option>
                            </x-form-select>
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
        $(document).ready(function() {
            $("#leadSourceForm").validate({
                rules: {
                    title: {
                        required: true,
                        maxlength: 100,
                    },
                    description: {
                        minlength: 3,
                        maxlength: 500
                    },
                    department_id: {
                        required: true,
                    }
                },
                messages: {
                    title: {
                        required: 'Title is required.',
                        maxlength: 'Title must not exceed 100 characters.',
                    },
                    description: {
                        minlength: 'Description must be at least 4 characters',
                        maxlength: 'Description must not exceed 500 characters.'
                    },
                    department_id: {
                        required: 'Title is required.',
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
