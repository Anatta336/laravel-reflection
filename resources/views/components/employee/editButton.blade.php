@component('components.linkButton', [
    'authorized' => !!$employee && Auth::check() && Auth::user()->can('update', $employee),
    'route' => $employee ? route('employee.edit', $employee->id) : false,
    'label' => 'Edit',
])@endcomponent
