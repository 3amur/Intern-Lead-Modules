@extends('dashboard.layouts.app')
@section('title')
{{ __('Family Memebers Page') }}
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
            {{ __('Family Memebers') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

<div class="card">
    <div class="card-header">
        <h4>{{ __('Family Memebers') }}</h4>
        @if(app\Helpers\Helpers::perUser('lead_account.create'))
        <a class="btn btn-success float-end" href="{{ route('family_members.create') }}">
            <i class="fa-solid fa-plus" style="color: #ffffff;"></i> {{ __('Create New Family Memeber') }}
        </a>
        @endif
    </div>
    <div class="card-body">
        {{ $dataTable->table(['class' => 'table  table-striped table-bordered table-sm fs--1 mb-0']) }}
    </div>
</div>





@endsection
@section('js')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.delete-this-family_member', function(e) {
            e.preventDefault();
            let el = $(this);
            let url = el.attr('data-url');
            let id = el.attr('data-id');
            Swal.fire({
                title: '{{ __('Do you really want to delete this Family Member  ?') }}',
                showCancelButton: true,
                confirmButtonText: '{{ __('Yes') }}',
                cancelButtonText: '{{ __('No') }}',
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        success: function(msg) {
                            window.location.href = "{{ route('family_members.index') }}";
                            Swal.fire(msg.message, '', msg.success ? 'success' :
                                'error');
                        }
                    });

                }
            });
        });
    });
</script>
@endsection
