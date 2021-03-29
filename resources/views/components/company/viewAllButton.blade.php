@component('components.linkButton', [
    'authorized' => Auth::user()->can('view', App\Company::class),
    'route' => route('company.all'),
    'label' => 'Show all companies',
])
@endcomponent
