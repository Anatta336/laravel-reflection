@component('components.linkButton', [
    'authorized' => Auth::user()->can('view', App\Employee::class),
    'route' => route('employee.all'),
    'label' => 'Show all employees',
])
@endcomponent
