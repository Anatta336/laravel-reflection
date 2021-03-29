@if ($company && Auth::check() && Auth::user()->can('delete', $company))
<form class="inline" method="POST" action="{{ route('company.destroy', $company->id) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-link delete"
        data-name="{{ $company->name }}">
        Delete
    </button>
</form>
@else
<button type="button" class="btn btn-link disabled">
    Delete
</button>
@endif
