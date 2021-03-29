@component('components.linkButton', [
    'authorized' => !!$employee && Auth::user()->can('update', $employee),
    'route' => $employee ? route('employee.edit', $employee->id) : false,
    'label' => 'Edit',
])@endcomponent
