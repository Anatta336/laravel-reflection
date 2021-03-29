@if ($employee && Auth::check() && Auth::user()->can('delete', $employee))
<form class="inline" method="POST" action="{{ route('employee.destroy', $employee->id) }}">
    @csrf
    @method('DELETE')
    @if (isset($isFromCompanyEmployees) && $isFromCompanyEmployees)
        <input type="hidden" name="is-from-company-employees" value="1">
    @endif

    <button type="submit" class="btn btn-link delete"
        data-name="{{ $employee->first_name . ' ' . $employee->last_name }}">
        Delete
    </button>
</form>
@else
<button type="button" class="btn btn-link disabled">
    Delete
</button>
@endif
