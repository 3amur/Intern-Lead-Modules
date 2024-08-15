
@props(['name', 'label', 'type', 'placeholder', 'value'=>false, 'oninput' , 'id'=> false,'required'=>false , 'readonly'=>false,'maxlength'=>false])

<div class="form-group mb-3">
    <label for="{{ $id }}" class="form-label">{{ __($label) }}</label>
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" name="{{ $name }}" @if($id) id="{{ $id }}" @endif
    @if($required) required @endif     @if($readonly) readonly @endif

        aria-describedby="helpId" placeholder="{{ $placeholder }}" @if($value) value="{{ $value }}" @endif oninput="{{ $oninput }}" @if($maxlength) maxlength="{{ $maxlength }}" @endif >
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

