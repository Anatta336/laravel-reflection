@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">Companies</div>
<div class="card-body">
    @component('components.flashStatus')
    @endcomponent

    {{-- table of company names --}}
    <table class="table table-striped">
    @foreach ($companies as $company)
        <tr class="company">
            <td class="name">
                {{ $company->name }}
            </td>
            <td class="show">
                <a class="btn btn-link" href="{{ route('company.show', $company->id) }}">
                    View
                </a>
            </td>
            
            <td>
                @if (Auth::check())
                    <a class="btn btn-link" href="{{ route('company.edit', $company->id) }}">
                        Edit
                    </a>
                @else
                    <a class="btn btn-link disabled" href="">
                        Edit
                    </a>
                @endif
            </td>
            <td>
                @if (Auth::check())
                    <form class="inline" method="POST" action="{{ route('company.destroy', $company->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link delete-company"
                            data-company-name="{{ $company->name }}">
                            Delete
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-link disabled">
                        Delete
                    </button>
                @endif
            </td>
        </tr>
    @endforeach
    </table>

    {{-- pagination --}}
    {{ $companies->links() }}

</div>

<div class="card-footer">
    @component('components.company.createButton')
    @endcomponent
</div>

</div>
</div>
</div>
</div>

@component('components.deletionModal')
@endcomponent

@endsection
