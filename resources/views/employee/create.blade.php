@extends('layouts.employee', [
    'header' => __('employees.createTitle'),
    'hideCreateButton' => true, // user might think this "create" link will use current form values
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
