@extends('layouts.employeeList', ['isFromCompanyEmployees' => true])
@section('title')
<a href="{{ route('company.show', $company->id) }}">{{$company->name}}</a> Employees
@endsection
