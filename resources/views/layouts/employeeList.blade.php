@extends('layouts.app')
@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">@yield('title')</div>
<div class="card-body">
    @component('components.flashStatus')
    @endcomponent

    {{-- table of employee names --}}
    <table class="table table-striped">
    @foreach ($employees as $employee)
        <tr class="employee">
            <td class="name">
                {{ $employee->first_name }} {{ $employee->last_name }}
            </td>
            <td>
                @component('components.employee.viewButton', ['employee' => $employee])
                @endcomponent
            </td>
            <td>
                @component('components.employee.editButton', ['employee' => $employee])
                @endcomponent
            </td>
            <td>
               @component('components.employee.deleteButton', ['employee' => $employee])
               @endcomponent
            </td>
        </tr>
    @endforeach
    </table>

    {{-- pagination --}}
    {{ $employees->links() }}

</div>

<div class="card-footer">
    @component('components.employee.createButton')
    @endcomponent
</div>

</div>
</div>
</div>
</div>

@component('components.deletionModal')
@endcomponent

@endsection
