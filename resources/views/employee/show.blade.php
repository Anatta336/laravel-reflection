@extends('layouts.employee', [
    'employee' => $employee,
    'header' => 'View Employee',
])

@section('employeeContent')
<p>Name: <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></p>
<p>
    Employer: 
    @if ($employee->company)
        <a href="{{ route('company.show', $employee->company->id) }}">
            <strong>{{ $employee->company->name }}</strong>
        </a>
    @else
        <strong>None</strong>
    @endif
</p>
<p>Email address: <strong>{{ $employee->email }}</strong></p>
<p>Phone number: <strong>{{ $employee->phone }}</strong></p>
@endsection
