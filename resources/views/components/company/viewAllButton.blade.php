@component('components.linkButton', [
    'authorized' => Auth::check() && Auth::check() && Auth::user()->can('view', App\Company::class),
    'route' => route('company.index'),
    'label' => 'Show all companies',
])
@endcomponent
