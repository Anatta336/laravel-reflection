@extends('layouts.employee', [
    'employee' => $employee,
    'header' => 'Edit Employee',
])

@section('employeeContent')
<form action="{{ route('employee.update', $employee->id) }}" method="post">
    @csrf
    @method('PUT')

    @component('components.employee.form', [
        'employee' => $employee,
        'errors' => $errors,
    ])@endcomponent

    <button class="btn btn-primary" type="submit">Save</button>
</form>
@endsection
