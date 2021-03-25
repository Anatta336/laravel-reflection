@extends('layouts.app')

@section('content')
<div class="container">
<div class="row justify-content-center">
<div class="col-md-8">
<div class="card">
<div class="card-header">{{ __('employees.listTitle') }}</div>
<div class="card-body">
    <table class="table table-striped">
    @foreach ($employees as $employee)
        <tr>
            <td class="name">
                {{ $employee->first_name }} {{ $employee->last_name }}
            </td>
            <td class="show">
                <a class="btn btn-link" href="{{ route('employee.show', $employee->id) }}">
                    {{ __('employees.show') }}
                </a>
            </td>
            {{-- only show edit and delete if user is logged in --}}
            @if (Auth::check())
                <td class="edit">
                    <a class="btn btn-link" href="{{ route('employee.edit', $employee->id) }}">
                        {{ __('employees.edit') }}
                    </a>
                </td>
                <td class="delete">
                    <form method="POST" action="{{ route('employee.destroy', $employee->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link">
                            {{ __('employees.destroy') }}
                        </button>
                    </form>
                </td>
            @endif
        </tr>
    @endforeach
    </table>
</div>
</div>
</div>
</div>
</div>
@endsection
