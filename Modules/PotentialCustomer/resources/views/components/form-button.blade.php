@props(['label','id'=>false,'data_bs_target'=>false,'class'=>false])
<button type="button" class="btn btn-primary btn-sm @if($class) {{ $class }} @endif" @if($id)id="{{ $id }}"@endif data-bs-toggle="modal" @if ($data_bs_target)data-bs-target="{{ '#'.$data_bs_target }}"@endif >{{ __($label) }}</button>
