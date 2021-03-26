@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">{{ __('employees.listTitle') }}</div>
<div class="card-body">

    {{-- table of employee names --}}
    <table class="table table-striped">
    @foreach ($employees as $employee)
        <tr>
            <td class="name">
                {{ $employee->first_name }} {{ $employee->last_name }}
            </td>
            <td class="show">
                <a class="btn btn-link" href="{{ route('employee.show', $employee->id) }}">
                    {{ __('employees.show') }}
                </a>
            </td>
            
            <td>
                @if (Auth::check())
                <a class="btn btn-link" href="{{ route('employee.edit', $employee->id) }}">
                    {{ __('employees.edit') }}
                </a>
                @else
                <a class="btn btn-link disabled" href="">
                    {{ __('employees.edit') }}
                </a>
                @endif
            </td>
            <td>
                @if (Auth::check())
                <form method="POST" action="{{ route('employee.destroy', $employee->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link">
                        {{ __('employees.destroy') }}
                    </button>
                </form>
                @else
                <form method="" action="">
                    <button type="submit" class="btn btn-link disabled">
                        {{ __('employees.destroy') }}
                    </button>
                </form>

                @endif
            </td>
        </tr>
    @endforeach
    </table>

    {{-- pagination --}}
    {{ $employees->links() }}

</div>
</div>
</div>
</div>
</div>
@endsection
