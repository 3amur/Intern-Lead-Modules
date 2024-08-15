@props(['label','name','value' , 'placeholder','id'=>false])

<div class="form-group mb-3">
    <label for="{{ $id }}" class="form-label">{{ __($label) }}</label>
    <textarea class="form-control @error($name) is-invalid @enderror" name="{{ $name }}"
        placeholder="{{ $placeholder }}" id="{{ $id }}">{{ $value }}</textarea>
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
