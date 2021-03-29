@component('components.linkButton', [
    'authorized' => Auth::check() && Auth::user()->can('view', App\Employee::class),
    'route' => route('employee.index'),
    'label' => 'Show all employees',
])
@endcomponent
