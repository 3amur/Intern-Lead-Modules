
@props(['name', 'label', 'type', 'placeholder', 'value'=>false, 'oninput' , 'id'=> false,'required'=>false ,'class'=>false])

<div class="form-group mb-3">
    <label for="{{ $id }}" class="form-label @if($class){{ $class }}@endif">{{ __($label) }}</label>
    <input type="{{ $type }}" class="form-control form-control-sm @error($name) is-invalid @enderror"
    name="{{ $name }}"
    @if($id) id="{{ $id }}" @endif
    @if($required) required @endif
    @if($value) value="{{ $value }}"@endif
        aria-describedby="helpId" placeholder="{{ $placeholder }}"  oninput="{{ $oninput }}" >
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

