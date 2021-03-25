@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
@component('employee.cardHeader', [
    'employee' => $employee,
    'isShowActive' => true,
    'isEditActive' => false,
])
@endcomponent
<div class="card-body">
    @component('components.flashStatus')@endcomponent
    
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
</div>
<div class="card-footer"><a href="{{ route('employee.all') }}">{{ __('employees.showAll') }}</a></div>
</div>
</div>
</div>
</div>
@endsection
