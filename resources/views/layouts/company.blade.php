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
    @if (Auth::user()->can('view', App\Company::class))
    <a class="btn btn-link" href="{{ route('company.all') }}">
    @else
    <a class="btn btn-link disabled" href="">
    @endif
        Show all companies
    </a>
    
    @if (isset($company) && Auth::user()->can('view', $company))
    <a class="btn btn-link" href="{{ route('company.show', $company->id) }}">
    @else
    <a class="btn btn-link disabled" href="">
    @endif
        View
    </a>

    @if (isset($company) && Auth::user()->can('update', $company))
    <a class="btn btn-link" href="{{ route('company.edit', $company->id) }}">
    @else
    <a class="btn btn-link disabled" href="">
    @endif
        Edit
    </a>
    
    @if (isset($company)  && Auth::user()->can('delete', $company))
    <form class="inline" method="POST" action="{{ route('company.destroy', $company->id) }}">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-link delete-company"
            data-company-name="{{ $company->name }}">
            Delete
        </button>
    </form>
    @else
    <form class="inline">
        <button type="button" class="btn btn-link disabled">
            Delete
        </button>
    </form>
    @endif

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
