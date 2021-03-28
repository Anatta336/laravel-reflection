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
                @if (Auth::user()->can('view', $employee))
                <a class="btn btn-link" href="{{ route('employee.show', $employee->id) }}">
                @else
                <a class="btn btn-link disabled" href="">
                @endif
                    View
                </a>
            </td>
            
            <td>
                @if (Auth::user()->can('update', $employee))
                <a class="btn btn-link" href="{{ route('employee.edit', $employee->id) }}">
                @else
                <a class="btn btn-link disabled" href="">
                @endif
                    Edit
                </a>
            </td>
            <td>
                @if (Auth::user()->can('delete', $employee))
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

<div class="card-footer">
    @component('components.employee.createButton')
    @endcomponent
</div>

</div>
</div>
</div>
</div>

@component('components.deletionModal')
@endcomponent

@endsection
