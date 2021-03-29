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
<div class="card-footer">
    @component('components.employee.viewAllButton')
    @endcomponent

    @component('components.employee.viewButton', ['employee' => $employee ?? null])
    @endcomponent
    
    @component('components.employee.editButton', ['employee' => $employee ?? null])
    @endcomponent
    
    @component('components.employee.deleteButton', ['employee' => $employee ?? null])
    @endcomponent

    @if (!isset($hideCreateButton) || !$hideCreateButton)
        @component('components.employee.createButton')
        @endcomponent
    @endif
</div>
</div>
</div>
</div>
</div>

@component('components.deletionModal')
@endcomponent

@endsection
