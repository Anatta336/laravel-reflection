@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
    @component('employee.cardHeader', [
        'employee' => $employee,
        'isShowActive' => false,
        'isEditActive' => true,
    ])
    @endcomponent
<div class="card-body">
    <form action="{{ route('employee.update', $employee->id) }}" method="post">
        @csrf
        @method('PUT')

        <label class="form-label" for="first_name">{{ __('employees.firstName') }}</label>
        <input class="form-control" type="text" name="first_name" id="first_name" required value="{{ $employee->first_name }}">
        
        <label class="form-label" for="last_name">{{ __('employees.lastName') }}</label>
        <input class="form-control" type="text" name="last_name" id="last_name" required value="{{ $employee->last_name }}">
        
        <label class="form-label" for="company_id">{{ __('employees.employer') }}</label>
        <select class="form-control" name="company_id">
            <option @if (!$employee->company)
                selected
                @endif value="">
                {{ __('employees.noEmployer') }}
            </option>
            @foreach (App\Company::all() as $company)
                <option @if ($company == $employee->company)
                    selected
                    @endif value="{{ $company->id }}">
                    {{ $company->name }}
                </option>
            @endforeach
        </select>

        <label class="form-label" for="email">{{ __('employees.email') }}</label>
        <input class="form-control" type="email" name="email" id="email" value="{{ $employee->email }}">

        <label class="form-label" for="phone">{{ __('employees.phone') }}</label>
        <input class="form-control" type="tel" name="phone" id="phone" value="{{ $employee->phone }}">

        <button class="btn btn-primary" type="submit">{{ __('employees.editSubmit') }}</button>
    </form>
</div>
<div class="card-footer"><a href="{{ route('employee.all') }}">{{ __('employees.showAll') }}</a></div>
</div>
</div>
</div>
</div>
@endsection
