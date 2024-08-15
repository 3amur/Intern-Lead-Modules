@props(['label','name','id'=>false,'class'=>false,'value' , 'required'=>false])

<div class="form-group ">
    <label for="{{ $id }}" class="form-label @if($class){{ $class }}@endif">{{ __($label) }}</label>
    <input type="text" class="form-control form-control-sm @error($name) is-invalid @enderror"
    name="{{ $name }}"
    @if($id) id="{{ $id }}" @endif
    oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="100%" value="{{ $value }}" @if($required) required @endif
        aria-describedby="helpId">
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
