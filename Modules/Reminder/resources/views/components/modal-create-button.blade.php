@props(['data_bs_target','title'])

<button class="btn btn-success btn-sm  float-end" type="button" data-bs-toggle="modal" data-bs-target="{{ $data_bs_target }}">
    <i class="fa-solid fa-plus me-2" style="color: #ffffff;"></i>{{ __($title) }}
</button>
