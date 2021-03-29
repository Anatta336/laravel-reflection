@if ($authorized)
<a class="btn btn-link" href="{{ $route }}">
@else
<a class="btn btn-link disabled" href="">
@endif
    {{ $label }}
</a>
