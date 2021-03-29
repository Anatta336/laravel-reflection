@component('components.linkButton', [
    'authorized' => Auth::user()->can('update', $company),
    'route' => route('company.edit', $company->id),
    'label' => 'Edit',
])@endcomponent
