@extends('dashboard.layouts.app')
@section('title')
{{ isset($leadStatus) ? __('Edit Lead Status ') : __('Create New Lead Status') }}
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
            <a href="{{ route('lead_status.index') }}">{{ __('Lead Status') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($leadStatus) ? __('Edit :type', ['type' => $leadStatus->title]) : __('Create New Lead Status') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        <div class="card my-3">
            <div class="card-header">
                {{ isset($leadStatus) ? __('Edit :type', ['type' => $leadStatus->title]) : __('Create New Lead Status') }}
            </div>
            <form
                action="{{ isset($leadStatus) ? route('lead_status.update', ['lead_status' => $leadStatus]) : route('lead_status.store') }}"
                method="POST" id="leadStatusForm">
                @csrf
                @if (isset($leadStatus))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <x-potentialcustomer::form-input type="text" :value="isset($leadStatus) ? $leadStatus->title : old('title')" label="Title" name='title' placeholder='Lead Status Title' id="title"  oninput="{{NULL}}" required/>
                    <x-potentialcustomer::form-description value="{{ isset($leadStatus) ? $leadStatus->description : old('description') }}"
                        label="Description" name='description' placeholder='Lead Status Description'  id="description"/>
                        <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                            <option @if (isset($leadStatus) && $leadStatus->status == 'active') selected @endif value="active">
                                {{ __('Active') }}</option>
                            <option @if (isset($leadStatus) && $leadStatus->status == 'inactive') selected @endif value="inactive">
                                {{ __('Inactive') }}</option>
                            <option @if (isset($leadStatus) && $leadStatus->status == 'draft') selected @endif value="draft">
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
        $("#leadStatusForm").validate({
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
