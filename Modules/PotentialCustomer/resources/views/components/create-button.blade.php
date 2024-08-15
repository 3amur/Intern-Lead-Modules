@props(['route', 'title'])

<a class="btn btn-success float-end btn-sm" href="{{ $route }}">
    <i class="fa-solid fa-plus" style="color: #ffffff;"></i> {{ __('Create '.Str::ucfirst($title)) }}
</a>
