@extends('dashboard.layouts.app')
@section('title')
    {{ __('Team Page') }}
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
            {{ __('Teams') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Team') }}</h4>
                    @if(app\Helpers\Helpers::perUser('teams.create'))
                    <x-potentialcustomer::create-button route="{{ route('teams.create') }}" title="Teams"/>
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

            $(document).on('click', '.delete-this-team', function(e) {
                e.preventDefault();
                let el = $(this);
                let url = el.attr('data-url');
                let id = el.attr('data-id');
                Swal.fire({
                    title: '{{ __('Do you really want to delete this Team ?') }}',
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
                                window.location.href = "{{ route('teams.index') }}";
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
