@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card employee">
    <div class="card-header">{{ $header }}</div>
<div class="card-body">
    @component('components.flashStatus')
    @endcomponent
    
    @yield('employeeContent')
</div>
<div class="card-footer">
    @if (Auth::user()->can('view', App\Employee::class))
    <a class="btn btn-link" href="{{ route('employee.all') }}">
    @else
    <a class="btn btn-link disabled" href="">
    @endif
    Show all employees
    </a>
    
    @if (isset($employee) && Auth::user()->can('view', $employee))
    <a class="btn btn-link" href="{{ route('employee.show', $employee->id) }}">
    @else
    <a class="btn btn-link disabled" href="">
    @endif
        View
    </a>

    @if (isset($employee) && Auth::user()->can('update', $employee))
    <a class="btn btn-link" href="{{ route('employee.edit', $employee->id) }}">
    @else
    <a class="btn btn-link disabled" href="">
    @endif
        Edit
    </a>
    
    @if (isset($employee) && Auth::user()->can('delete', $employee))
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

    @if (!isset($hideCreateButton) || !$hideCreateButton)
        @component('components.employee.createButton')
        @endcomponent
    @endif
</div>
</div>
</div>
</div>
</div>

@component('components.deletionModal')
@endcomponent

@endsection
