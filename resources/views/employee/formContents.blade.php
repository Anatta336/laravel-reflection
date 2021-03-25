<label class="form-label" for="first_name">{{ __('employees.firstName') }}</label>
<input class="form-control" type="text" name="first_name" id="first_name" required
    value="@if (old('_token'))
{{ old('first_name') }}
    @elseif (isset($employee))
{{ $employee->first_name }}
    @endif">
@if ($errors->has('first_name'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('first_name') }}</p>
    </div>
@endif

<label class="form-label" for="last_name">{{ __('employees.lastName') }}</label>
<input class="form-control" type="text" name="last_name" id="last_name" required
    value="@if (old('_token'))
{{ old('last_name') }}
    @elseif (isset($employee))
{{ $employee->last_name }}
    @endif">
@if ($errors->has('last_name'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('last_name') }}</p>
    </div>
@endif

<label class="form-label" for="company_id">{{ __('employees.employer') }}</label>
<select class="form-control" name="company_id">
    {{--
        if has data from last submission and old company_id is null, then it must be intentionally
        set to null, so make the "None" option be selected.
    --}}
    <option @if ((old('_token') && !old('company_id'))
            || (isset($employee) && !$employee->company))
        selected
        @endif value="">
        {{ __('employees.noEmployer') }}
    </option>
    @foreach (App\Company::all()->sortBy('name') as $company)
        <option @if (old('company_id') == $company->id
                || (!old('_token') && isset($employee) && $employee->company == $company))
            selected
            @endif value="{{ $company->id }}">
            {{ $company->name }}
        </option>
    @endforeach
</select>
@if ($errors->has('company_id'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('company_id') }}</p>
    </div>
@endif

<label class="form-label" for="email">{{ __('employees.email') }}</label>
<input class="form-control" type="email" name="email" id="email"
    value="@if (old('_token'))
{{ old('email') }}
    @elseif (isset($employee))
{{ $employee->email }}
    @endif">
@if ($errors->has('email'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('email') }}</p>
    </div>
@endif

<label class="form-label" for="phone">{{ __('employees.phone') }}</label>
<input class="form-control" type="tel" name="phone" id="phone"
    value="@if (old('_token'))
{{ old('phone') }}
    @elseif (isset($employee))
{{ $employee->phone }}
    @endif">
@if ($errors->has('phone'))
    <div class="alert alert-danger">
        <p>{{ $errors->first('phone') }}</p>
    </div>
@endif
