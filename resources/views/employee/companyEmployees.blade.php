@extends('layouts.employeeList')
@section('title')
<a href="{{ route('company.show', $company->id) }}">{{$company->name}}</a> Employees
@endsection
