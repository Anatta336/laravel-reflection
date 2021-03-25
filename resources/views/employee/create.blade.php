@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">
    {{ __('employees.createTitle') }}
</div>
<div class="card-body">
    @component('components.flashStatus')@endcomponent
    
    <form action="{{ route('employee.store') }}" method="post">
        @csrf
        @method('POST')

        @component('employee.formContents', [
            'errors' => $errors
        ])@endcomponent

        <button class="btn btn-primary" type="submit">{{ __('employees.createSubmit') }}</button>
    </form>
</div>
<div class="card-footer"><a href="{{ route('employee.all') }}">{{ __('employees.showAll') }}</a></div>
</div>
</div>
</div>
</div>
@endsection
