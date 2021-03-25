<div class="card-header">
    <ul class="nav nav-pills card-header-pills">
        <li class="nav-item">
            <a class="nav-link @if ($isShowActive)
                active
            @endif" href="{{ route('employee.show', $employee->id) }}">
                {{ __('employees.showSingleTitle') }}
            </a>
        </li>
        @if (Auth::check())
            <li class="nav-item">
            <a class="nav-link @if ($isEditActive)
                active
            @endif" href="{{ route('employee.edit', $employee->id) }}">
                {{ __('employees.edit') }}
            </a>
            </li>
            <li class="nav-item">
                <form method="POST" action="{{ route('employee.destroy', $employee->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        {{ __('employees.destroy') }}
                    </button>
                </form>
            </li>
        @endif
      </ul>
</div>