@props(['id'=>false,'class'=>false])
<button type="button" @if($id) id="{{ $id }}"@endif  class="btn btn-sm btn-danger   mt-4 @if($class){{ ' '. $class }}@endif">
    <i class="fa-solid fa-trash fa-sm" style="color: #ffffff;"></i></button>
