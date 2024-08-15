@props(['href','title','description'])
    <div class=" w-100  my-2" >
        <a class="category nav-link btn bg-white w-100 p-3 fs-0"
            href="{{ $href }}">
            {{ $slot }}
            <!-- <span class="category-icon text-800 fs-2 fa-solid fa-chart-pie"></span> Font Awesome fontawesome.com -->
            <span class="d-block fs-1 fw-bolder lh-1 text-900 mt-3 mb-2">{{ $title }}</span>
            <span class="d-block text-900 fw-normal mb-0 fs--1">{{ $description }}</span>
        </a>
</div>
