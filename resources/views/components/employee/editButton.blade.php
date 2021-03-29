@component('components.linkButton', [
    'authorized' => Auth::user()->can('update', $employee),
    'route' => route('employee.edit', $employee->id),
    'label' => 'Edit',
])@endcomponent
