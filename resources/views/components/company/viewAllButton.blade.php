@component('components.linkButton', [
    'authorized' => Auth::user()->can('view', App\Company::class),
    'route' => route('company.index'),
    'label' => 'Show all companies',
])
@endcomponent
