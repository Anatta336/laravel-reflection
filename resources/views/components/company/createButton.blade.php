@if (Auth::check() && Auth::user()->can('create', App\Company::class))
<a class="btn btn-link" href="{{ route('company.create') }}">
@else
<a class="btn btn-link disabled" href="">
@endif
    Create New
</a>
