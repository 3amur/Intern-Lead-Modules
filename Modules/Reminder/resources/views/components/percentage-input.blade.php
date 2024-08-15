@props(['label','name','id'=>false,'class'=>false,'value' , 'required'=>false])

<div class="form-group">
    <label for="{{ $id }}" class="form-label @if($class){{ $class }}@endif">{{ __($label) }}</label>
    <div class="input-group input-group-sm">
        <input type="text" class="form-control" name="{{ $name }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="100%" value="{{ $value }}" @if($required) required @endif>
        <span class="input-group-text"@if($id) id="{{ $id }}"@endif >%</span>
    </div>
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
</div>
