<div class="card-footer">
    <a class="btn btn-link" href="{{ route('employee.all') }}">
        {{ __('employees.showAll') }}
    </a>
    
    @if (isset($employee))
    <a class="btn btn-link" href="{{ route('employee.show', $employee->id) }}">
    @else
    <a class="btn btn-link disabled" href="">
    @endif
        {{ __('employees.show') }}
    </a>

    @if (Auth::check() && isset($employee))
    <a class="btn btn-link" href="{{ route('employee.edit', $employee->id) }}">
    @else
    <a class="btn btn-link disabled" href="">
    @endif
        {{ __('employees.edit') }}
    </a>
    
    @if (Auth::check())
    <a class="btn btn-link" href="{{ route('employee.create') }}">
        {{ __('employees.create')}}
    </a>
    @endif

    @if (Auth::check() && isset($employee))
        <form class="inline" method="POST" action="{{ route('employee.destroy', $employee->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-link">
                {{ __('employees.destroy') }}
            </button>
        </form>
    @else
        <form class="inline">
            <button type="button" class="btn btn-link disabled">
                {{ __('employees.destroy') }}
            </button>
        </form>
    @endif

</div>