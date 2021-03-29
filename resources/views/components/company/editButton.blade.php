@component('components.linkButton', [
    'authorized' => !!$company && Auth::user()->can('update', $company),
    'route' => $company ? route('company.edit', $company->id) : '',
    'label' => 'Edit',
])@endcomponent
