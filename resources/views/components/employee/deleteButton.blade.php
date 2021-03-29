@if ($employee && Auth::user()->can('delete', $employee))
<form class="inline" method="POST" action="{{ route('employee.destroy', $employee->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-link delete-employee"
        data-employee-name="{{ $employee->first_name . ' ' . $employee->last_name }}">
        Delete
    </button>
</form>
@else
<button type="button" class="btn btn-link disabled">
    Delete
</button>
@endif
