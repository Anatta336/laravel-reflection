@extends('layouts.employee', [
    'employee' => $employee,
    'header' => 'View Employee',
])

@section('employeeContent')
<p>Name: <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></p>
<p>
    Employer: 
    @if ($employee->company)
        @if (Auth::user()->can('view', $employee->company))
            <a href="{{ route('company.show', $employee->company->id) }}">
                <strong>{{ $employee->company->name }}</strong>
            </a>
        @else
            <strong>{{ $employee->company->name }}</strong>
        @endif
    @else
        <strong>None</strong>
    @endif
</p>

<p>Email address:
    @if ($employee->email)
        <strong><a href="mailto:{{ $employee->email }}">
            {{ $employee->email }}
        </a></strong>
    @else
        <strong>None</strong>
    @endif
</p>

<p>Phone number: <strong>{{ $employee->phone }}</strong></p>
@endsection
