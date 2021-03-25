@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">
    <ul class="nav nav-pills card-header-pills">
        <li class="nav-item">
          <a class="nav-link active" href="#"> {{ __('employees.showSingleTitle') }}</a>
        </li>
        @if (Auth::check())
            <li class="nav-item">
            <a class="nav-link" href="{{ route('employee.edit', $employee->id) }}">{{ __('employees.edit') }}</a>
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
<div class="card-body">

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
