@extends('dashboard.layouts.app')
@section('title')
{{ isset($leadType) ? __('Edit Lead Type ') : __('Create New Lead Type') }}
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
            <a href="{{ route('lead_type.index') }}">{{ __('Lead Type') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($leadType) ? __('Edit :type', ['type' => $leadType->title]) : __('Create New Lead Type') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

<div class="container">
    <div class="card my-3">
        <div class="card-header">
            {{ isset($leadType) ? __('Edit :type', ['type' => $leadType->name]) : __('Create New Lead Type') }}
        </div>
        <form action="{{ isset($leadType) ? route('lead_type.update', ['lead_type' => $leadType]) : route('lead_type.store') }}" method="POST" id="leadTypeForm">
            @csrf
            @if (isset($leadType))
            @method('PUT')
        @endif
            <div class="card-body">
                <x-potentialcustomer::form-input type="text" :value="isset($leadType) ? $leadType->title : old('title')" label="Title" name='title' placeholder='Lead Type Title' id="title"  oninput="{{NULL}}" required/>
                    <x-potentialcustomer::form-description  id="description" value="{{ isset($leadType) ? $leadType->description : old('description') }}" label="Description" name='description' placeholder='Lead Type Description' />
                        <x-potentialcustomer::form-select name='status' id="status" label="status"  required>
                            <option @if (isset($leadType) && $leadType->status == 'active') selected @endif value="active">
                                {{ __('Active') }}</option>
                            <option @if (isset($leadType) && $leadType->status == 'inactive') selected @endif value="inactive">
                                {{ __('Inactive') }}</option>
                            <option @if (isset($leadType) && $leadType->status == 'draft') selected @endif value="draft">
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
        $("#leadTypeForm").validate({
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
