@props(['label','name','value','required'=>false,'id'=>false,])
<div class="form-group mb-3">
    <label class="form-label" for="datePicker">{{ $label }}</label>
    <input class="form-control form-control-sm" @if($id) id="{{ $id }}"@endif type="datetime-local" name = {{ $name }} placeholder="dd/mm/yyyy"
         value="{{ $value }}" @if($required) required @endif  />
        @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>



