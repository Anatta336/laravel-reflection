@component('components.linkButton', [
    'authorized' => Auth::user()->can('view', $company),
    'route' => route('company.show', $company->id),
    'label' => 'View',
])@endcomponent
