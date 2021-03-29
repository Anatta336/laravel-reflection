@component('components.linkButton', [
    'authorized' => !!$employee && Auth::check() && Auth::user()->can('view', $employee),
    'route' => $employee ? route('employee.show', $employee->id) : '',
    'label' => 'View',
])@endcomponent
