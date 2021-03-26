@extends('layouts.company', [
    'company' => $company,
    'header' => 'Edit Company',
])

@section('companyContent')
<form action="{{ route('company.update', $company->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    @component('components.company.form', [
        'company' => $company,
        'errors' => $errors,
    ])@endcomponent

    <button class="btn btn-primary" type="submit">Save</button>
</form>
@endsection
