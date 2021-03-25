@extends('layouts.employee', [
    'employee' => $employee,
    'header' => __('employees.showTitle'),
])

@section('employeeContent')
<p>{{ __('employees.name') }}: <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong></p>
<p>
    {{ __('employees.employer') }}:
    @if ($employee->company)
    <a href="{{ route('company.show', $employee->company->id) }}"><strong>{{ $employee->company->name }}</strong></a>
    @else
        {{ __('employees.noEmployer') }}
    @endif
</p>
<p>{{ __('employees.email') }}: <strong>{{ $employee->email }}</strong></p>
<p>{{ __('employees.phone') }}: <strong>{{ $employee->phone }}</strong></p>
@endsection
