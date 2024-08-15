@extends('dashboard.layouts.app')
@section('title')
{{ isset($leadValue) ? __('Edit Lead Value ') : __('Create New Lead Value') }}
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
            <a href="{{ route('lead_value.index') }}">{{ __('Lead Value') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($leadValue) ? __('Edit :type', ['type' => $leadValue->title]) : __('Create New Lead Value') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

<div class="container">
    <div class="card my-3">
        <div class="card-header">
            {{ isset($leadValue) ? __('Edit :type', ['type' => $leadValue->name]) : __('Create New Lead Value') }}
        </div>
        <form action="{{ isset($leadValue) ? route('lead_value.update', ['lead_value' => $leadValue]) : route('lead_value.store') }}" method="POST" id="leadValueForm">
            @csrf
            @if (isset($leadValue))
            @method('PUT')
        @endif
            <div class="card-body">
                <x-potentialcustomer::form-input type="text" :value="isset($leadValue) ? $leadValue->title : old('title')" label="Title" name='title' placeholder='Lead Value Title' id="title"  oninput="{{NULL}}" required/>
                    <x-potentialcustomer::form-description  id="description" value="{{ isset($leadValue) ? $leadValue->description : old('description') }}" label="Description" name='description' placeholder='Lead Value Description' />
                        <x-potentialcustomer::form-select name='status' id="status" label="status"  required>
                            <option @if (isset($leadValue) && $leadValue->status == 'active') selected @endif value="active">
                                {{ __('Active') }}</option>
                            <option @if (isset($leadValue) && $leadValue->status == 'inactive') selected @endif value="inactive">
                                {{ __('Inactive') }}</option>
                            <option @if (isset($leadValue) && $leadValue->status == 'draft') selected @endif value="draft">
                                {{ __('Draft') }}</option>
                        </x-potentialcustomer::form-select>                    <div class="card-footer text-muted text-center">
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
        $("#leadValueForm").validate({
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
