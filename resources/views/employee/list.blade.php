@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">Employees</div>
<div class="card-body">
    @component('components.flashStatus')
    @endcomponent

    {{-- table of employee names --}}
    <table class="table table-striped">
    @foreach ($employees as $employee)
        <tr class="employee">
            <td class="name">
                {{ $employee->first_name }} {{ $employee->last_name }}
            </td>
            <td class="show">
                <a class="btn btn-link" href="{{ route('employee.show', $employee->id) }}">
                    View
                </a>
            </td>
            
            <td>
                @if (Auth::check())
                    <a class="btn btn-link" href="{{ route('employee.edit', $employee->id) }}">
                        Edit
                    </a>
                @else
                    <a class="btn btn-link disabled" href="">
                        Edit
                    </a>
                @endif
            </td>
            <td>
                @if (Auth::check())
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

@component('components.deletionModal')
@endcomponent

@endsection
