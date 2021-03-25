@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card employee">
    <div class="card-header">{{ $header }}</div>
<div class="card-body">
    @component('components.flashStatus')
    @endcomponent
    
    @yield('employeeContent')
</div>
@component('components.employee.footer', [
    'employee' => isset($employee) ? $employee : null,
])@endcomponent
</div>
</div>
</div>
</div>
@endsection
