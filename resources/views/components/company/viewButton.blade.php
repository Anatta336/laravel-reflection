@component('components.linkButton', [
    'authorized' => !!$company && Auth::check() && Auth::user()->can('view', $company),
    'route' => $company ? route('company.show', $company->id) : '',
    'label' => 'View',
])@endcomponent
