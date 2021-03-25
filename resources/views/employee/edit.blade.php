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
        <input class="form-control" type="text" name="first_name" id="first_name" required
            value="{{ old('first_name') ?? $employee->first_name }}">
        @if ($errors->has('first_name'))
            <div class="alert alert-danger">
                <p>{{ $errors->first('first_name') }}</p>
            </div>
        @endif
        
        <label class="form-label" for="last_name">{{ __('employees.lastName') }}</label>
        <input class="form-control" type="text" name="last_name" id="last_name" required
            value="{{ old('last_name') ?? $employee->last_name }}">
        @if ($errors->has('last_name'))
            <div class="alert alert-danger">
                <p>{{ $errors->first('last_name') }}</p>
            </div>
        @endif

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
        @if ($errors->has('company_id'))
            <div class="alert alert-danger">
                <p>{{ $errors->first('company_id') }}</p>
            </div>
        @endif

        <label class="form-label" for="email">{{ __('employees.email') }}</label>
        <input class="form-control" type="email" name="email" id="email"
            value="{{ old('email') ?? $employee->email }}">
        @if ($errors->has('email'))
            <div class="alert alert-danger">
                <p>{{ $errors->first('email') }}</p>
            </div>
        @endif

        <label class="form-label" for="phone">{{ __('employees.phone') }}</label>
        <input class="form-control" type="tel" name="phone" id="phone"
            value="{{ old('phone') ?? $employee->phone }}">
        @if ($errors->has('phone'))
            <div class="alert alert-danger">
                <p>{{ $errors->first('phone') }}</p>
            </div>
        @endif

        <button class="btn btn-primary" type="submit">{{ __('employees.editSubmit') }}</button>
    </form>
</div>
<div class="card-footer"><a href="{{ route('employee.all') }}">{{ __('employees.showAll') }}</a></div>
</div>
</div>
</div>
</div>
@endsection
