    @props(['label','id'=>false,'color'])
    <button type="button" class="btn btn-{{ $color }} btn-sm" @if($id)id="{{ $id }}"@endif  >{{ __($label) }}</button>
