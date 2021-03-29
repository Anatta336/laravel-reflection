@component('components.linkButton', [
    'authorized' => Auth::user()->can('view', $employee),
    'route' => route('employee.show', $employee->id),
    'label' => 'View',
])@endcomponent
