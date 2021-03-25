@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
    @component('employee.cardHeader', [
        'employee' => $employee,
        'isShowActive' => false,
        'isEditActive' => true,
    ])
    @endcomponent
<div class="card-body">
    @component('components.flashStatus')@endcomponent
    
    <form action="{{ route('employee.update', $employee->id) }}" method="post">
        @csrf
        @method('PUT')

        @component('employee.formContents', [
            'employee' => $employee,
            'errors' => $errors,
        ])@endcomponent

        <button class="btn btn-primary" type="submit">{{ __('employees.editSubmit') }}</button>
    </form>
</div>
<div class="card-footer"><a href="{{ route('employee.all') }}">{{ __('employees.showAll') }}</a></div>
</div>
</div>
</div>
</div>
@endsection
