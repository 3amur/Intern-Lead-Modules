@props(['route', 'title'])

<a class="btn btn-success float-end" href="{{ route($route.'.create') }}">
    <i class="fa-solid fa-plus" style="color: #ffffff;"></i> {{ __('Create '.Str::ucfirst($title)) }}
</a>
