@if (Auth::check())
    <a class="btn btn-link" href="{{ route('company.create') }}">
        Create New
    </a>
@else
    <a class="btn btn-link disabled" href="">
        Create New
    </a>
@endif
