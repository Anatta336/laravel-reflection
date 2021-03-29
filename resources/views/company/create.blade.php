@extends('layouts.company', [
    'header' => 'Create Company',
    'disableCreateButton' => true, // user might think this "create" link will use current form values
])

@section('companyContent')
<form action="{{ route('company.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('POST')

    @component('components.company.form', [
        'errors' => $errors
    ])@endcomponent

    <button class="btn btn-primary" type="submit">Create</button>
</form>
@endsection
