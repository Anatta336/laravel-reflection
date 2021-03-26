<div class="card-footer">
    <a class="btn btn-link" href="{{ route('employee.all') }}">
        Show all employees
    </a>
    
    @if (isset($employee))
        <a class="btn btn-link" href="{{ route('employee.show', $employee->id) }}">
            View
        </a>
    @else
        <a class="btn btn-link disabled" href="">
            View
        </a>
    @endif

    @if (Auth::check() && isset($employee))
        <a class="btn btn-link" href="{{ route('employee.edit', $employee->id) }}">
            Edit
        </a>
    @else
        <a class="btn btn-link disabled" href="">
            Edit
        </a>
    @endif
    
    @if (Auth::check() && isset($employee))
        <form class="inline" method="POST" action="{{ route('employee.destroy', $employee->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link delete-employee"
                data-employee-name="{{ $employee->first_name . ' ' . $employee->last_name }}">
                Delete
            </button>
        </form>
    @else
        <form class="inline">
            <button type="button" class="btn btn-link disabled">
                Delete
            </button>
        </form>
    @endif

    @if (Auth::check())
        <a class="btn btn-link" href="{{ route('employee.create') }}">
            Create New
        </a>
    @else
        <a class="btn btn-link disabled" href="">
            Create New
        </a>
    @endif

</div>