@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card company">
    <div class="card-header">{{ $header }}</div>
<div class="card-body">
    @component('components.flashStatus')
    @endcomponent
    
    @yield('companyContent')
</div>
<div class="card-footer">
    @component('components.company.viewAllButton')
    @endcomponent
    
    @component('components.company.viewButton', ['company' => $company ?? null])
    @endcomponent

    @component('components.company.editButton', ['company' => $company ?? null])        
    @endcomponent
    
    @component('components.company.deleteButton', ['company' => $company ?? null])
    @endcomponent

    @if (!isset($hideCreateButton) || !$hideCreateButton)
        @component('components.company.createButton')
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
