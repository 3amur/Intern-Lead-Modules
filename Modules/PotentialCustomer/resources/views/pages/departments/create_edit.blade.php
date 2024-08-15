@extends('dashboard.layouts.app')
@section('title')
    {{ isset($department) ? __('Edit Department ') : __('Create New Department') }}
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
            <a href="{{ route('departments.index') }}">{{ __('Department') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($department) ? __('Edit :type', ['type' => $department->title]) : __('Create New Department') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($department) ? __('Edit :type', ['type' => $department->title]) : __('Create New Department') }}
            </div>
            <form
                action="{{ isset($department) ? route('departments.update', ['department' => $department]) : route('departments.store') }}"
                method="POST" id="leadSourceForm">
                @csrf
                @if (isset($department))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <x-potentialcustomer::form-input type="text" :value="isset($department) ? $department->title : old('title')" label="Title" name='title'
                        placeholder='Department Title' id="title" oninput="{{ null }}" required />
                    <x-potentialcustomer::form-description
                        value="{{ isset($department) ? $department->description : old('description') }}" label="Description"
                        name='description' placeholder='Department Description' id="description" />
                    <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                        <option @if (isset($department) && $department->status == 'active') selected @endif value="active">
                            {{ __('Active') }}</option>
                        <option @if (isset($department) && $department->status == 'inactive') selected @endif value="inactive">
                            {{ __('Inactive') }}</option>
                        <option @if (isset($department) && $department->status == 'draft') selected @endif value="draft">
                            {{ __('Draft') }}</option>
                    </x-potentialcustomer::form-select>
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
