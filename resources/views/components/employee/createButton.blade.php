@if (empty($isForcedToDisable)
    && Auth::check()
    && Auth::user()->can('create', App\Employee::class))
<a class="btn btn-link"
    href="{{ route('employee.create',
        ['defaultCompany' => $defaultCompany ?? null]) }}">
@else
<a class="btn btn-link disabled" href="">
@endif
    Create New
</a>
