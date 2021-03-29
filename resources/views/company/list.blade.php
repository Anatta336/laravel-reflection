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
            <td>
                @component('components.company.viewButton', ['company' => $company])
                @endcomponent
            </td>
            <td>
                @component('components.company.editButton', ['company' => $company])
                @endcomponent
            </td>
            <td>
                @component('components.company.deleteButton', ['company' => $company])
                @endcomponent
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
