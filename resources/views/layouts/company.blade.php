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
    <a class="btn btn-link" href="{{ route('company.all') }}">
        Show all companies
    </a>
    
    @if (isset($company))
        <a class="btn btn-link" href="{{ route('company.show', $company->id) }}">
            View
        </a>
    @else
        <a class="btn btn-link disabled" href="">
            View
        </a>
    @endif

    @if (Auth::check() && isset($company))
        <a class="btn btn-link" href="{{ route('company.edit', $company->id) }}">
            Edit
        </a>
    @else
        <a class="btn btn-link disabled" href="">
            Edit
        </a>
    @endif
    
    @if (Auth::check() && isset($company))
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
