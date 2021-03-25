@extends('layouts.employee', [
    'header' => __('employees.createTitle'),
])

@section('employeeContent')
<form action="{{ route('employee.store') }}" method="post">
    @csrf
    @method('POST')

    @component('components.employee.form', [
        'errors' => $errors
    ])@endcomponent

    <button class="btn btn-primary" type="submit">{{ __('employees.createSubmit') }}</button>
</form>
@endsection
