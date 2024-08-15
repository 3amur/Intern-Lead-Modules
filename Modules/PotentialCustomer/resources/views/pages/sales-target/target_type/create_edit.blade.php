@extends('dashboard.layouts.app')
@section('title')
    {{ isset($targetType) ? __('Edit Target Type ') : __('Create New Target Type') }}
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
            <a href="{{ route('target_types.index') }}">{{ __('Target Type') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ isset($targetType) ? __('Edit :type', ['type' => $targetType->title]) : __('Create New Target Type') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}
    <div class="container">
        @include('dashboard.layouts.alerts')
        <div class="card my-3">
            <div class="card-header">
                {{ isset($targetType) ? __('Edit :type', ['type' => $targetType->title]) : __('Create New Target Type') }}
            </div>
            <form
                action="{{ isset($targetType) ? route('target_types.update', ['target_type' => $targetType]) : route('target_types.store') }}"
                method="POST" enctype="multipart/form-data" id="targetTypeForm">
                @csrf
                @if (isset($targetType))
                    @method('PUT')
                @endif
                <div class="card-body">
                    <div class="col-lg-12">
                    </div>
                    <x-potentialcustomer::form-input type="text" :value="isset($targetType) ? $targetType->title : old('title')" label="Title" name='title'
                        placeholder='Target Type Title' id="title" oninput="{{ null }}" required />
                    <x-potentialcustomer::form-description
                        value="{{ isset($targetType) ? $targetType->description : old('description') }}" label="Description"
                        name='description' placeholder='Target Type Description' id="description" />

                    <x-potentialcustomer::file-input name="image" id="imageInput" label="Image"/>

                    <x-potentialcustomer::form-select name='status' id="status" label="status" required>
                        <option @if (isset($targetType) && $targetType->status == 'active') selected @endif value="active">
                            {{ __('Active') }}</option>
                        <option @if (isset($targetType) && $targetType->status == 'inactive') selected @endif value="inactive">
                            {{ __('Inactive') }}</option>
                        <option @if (isset($targetType) && $targetType->status == 'draft') selected @endif value="draft">
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
        $("#targetTypeForm").validate({
            rules: {
                title: {
                    required: true,
                    minlength: 3,
                    maxlength: 100,
                },
                description: {
                    maxlength: 500
                },
            },
            messages: {
                title: {
                    required: 'Title is required.',
                    minlength: 'Title must be at least 4 characters',
                    maxlength: 'Title must not exceed 100 characters.',
                },
                description: {
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
