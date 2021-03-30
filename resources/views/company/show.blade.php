@extends('layouts.company', [
    'company' => $company,
    'header' => 'View Company',
])

@section('companyContent')
<p>Name: <strong>{{ $company->name }}</strong></p>
<p>Email address:
    @if ($company->email)
        <strong><a href="mailto:{{ $company->email }}">
            {{ $company->email }}
        </a></strong>
    @else
        <strong>None</strong>
    @endif
</p>

<p>Website:
    @if ($company->website)
        <strong><a href="{{ $company->website }}">
            {{ $company->website }}
        </a></strong>
    @else
        <strong>None</strong>
    @endif
</p>

<p>Logo:
@if ($company->logo)
    </p>
    <img class="img-fluid img-thumbnail logo"
        src="{{ asset('storage/' . $company->logo) }}"
        alt="Logo of {{ $company->name }}">
@else
    <strong>None</strong>
    </p>
@endif

<p>Employees:
    <strong>{{ $company->employees->count() }} </strong>
</p>
@component('components.linkButton', [
    'authorized' => Auth::check() && Auth::user()->can('view', App\Employee::class),
    'route' => route('employeesOfCompany.index', $company->id),
    'label' => "View employees of {$company->name}",
])@endcomponent

@endsection
