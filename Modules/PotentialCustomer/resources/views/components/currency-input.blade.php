@props(['name', 'label', 'value', 'id' => false, 'required' => false, 'class' => false])

<div class="form-group">
    <label for="{{ $id }}"
        class="form-label @if ($class) {{ $class }} @endif">{{ __($label) }}</label>
    <div class="input-group input-group-sm">
        <span class="input-group-text" id="basic-addon1">EGP</span>
        <input class="form-control @error($name) is-invalid @enderror" type="text" name="{{ $name }}"
            @if ($id) id="{{ $id }}" @endif
            @if ($required) required @endif value="{{ $value }}" data-type="currency"
            placeholder="EGP 1,000,000.00">
    </div>
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
