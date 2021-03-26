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

<p>Logo: <strong>notYetImplemented.jpg</strong></p>

@endsection
