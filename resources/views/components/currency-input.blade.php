@props(['name', 'label', 'value', 'id'=> false,'required'=>false])

<div class="input-group  mt-4">
    <span class="input-group-text" id="basic-addon1">EGP</span>
    <input class="form-control @error($name) is-invalid @enderror" type="text" name="{{ $name }}" @if($id) id="{{ $id }}" @endif
    @if($required) required @endif pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" value="{{ $value }}"
        data-type="currency" placeholder="EGP 1,000,000.00" >
        @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
</div>
