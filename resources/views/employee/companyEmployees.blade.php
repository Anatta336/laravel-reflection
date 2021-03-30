@extends('layouts.employeeList', [
    'isFromCompanyEmployees' => true,
    'owningCompany' => $company,
])
@section('title')
<a href="{{ route('company.show', $company->id) }}">{{$company->name}}</a> Employees
@endsection
