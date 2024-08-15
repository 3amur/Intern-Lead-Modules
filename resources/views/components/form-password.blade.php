@props(['name', 'label', 'placeholder', 'value', 'id'=> false ,'required' => false ])


<div class="form-group mb-3">
    <label for="" class="form-label">{{ __($label) }}</label>
    <div class="input-group ">
        <input type="password"
            class="form-control @error($name) is-invalid @enderror border-left-0"
            name="{{ $name }}" id="{{ $id }}"
            placeholder="{{ __('Enter :value', ['value' => __($placeholder)]) }}"  @if($required) required @endif>
        @error($name)
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
