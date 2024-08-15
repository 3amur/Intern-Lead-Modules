@props(['id'=>false,'class'=>false,'hidden'=>false])
<div class="form-group">
    <button type="button" @if($id) id="{{ $id }}"@endif  class="btn  btn-danger btn-sm   mt-4 @if($class){{ ' '. $class }}@endif" @if($hidden) hidden @endif>
        <i class="fa-solid fa-trash fa-sm" style="color: #ffffff;"></i></button>
</div>
