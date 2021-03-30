<div class="form-group">
    <label class="form-label required" for="first_name">First name</label>
    <input class="form-control" type="text" name="first_name" id="first_name" required
        @if (old('_token'))
            value="{{ old('first_name') }}"
        @elseif (isset($employee))
            value="{{ $employee->first_name }}"
        @endif
        >
    @if ($errors->has('first_name'))
        <div class="alert alert-danger">
            {{ $errors->first('first_name') }}
        </div>
    @endif

    <label class="form-label required" for="last_name">Last name</label>
    <input class="form-control" type="text" name="last_name" id="last_name" required
        @if (old('_token'))
            value="{{ old('last_name') }}"
        @elseif (isset($employee))
            value="{{ $employee->last_name }}"
        @endif
        >
    @if ($errors->has('last_name'))
        <div class="alert alert-danger">
            {{ $errors->first('last_name') }}
        </div>
    @endif
</div>

<div class="form-group">
    <label class="form-label" for="company_id">Employer</label>
    <select class="form-control" name="company_id">
        {{--
            if has data from last submission and old company_id is null, then it must be intentionally
            set to null, so make the "None" option be selected.
        --}}
        <option @if ((old('_token') && !old('company_id'))
                || (isset($employee) && !$employee->company))
            selected
            @endif value="">
            None
        </option>
        
        @foreach (App\Company::all()->sortBy('name') as $company)
            <option @if (old('company_id') == $company->id
                    || (!old('_token') && isset($employee) && $employee->company == $company)
                    || (!old('_token') && isset($defaultCompanyId) && $defaultCompanyId == $company->id))
                selected
                @endif value="{{ $company->id }}">
                {{ $company->name }}
            </option>
        @endforeach
    </select>
    @if ($errors->has('company_id'))
        <div class="alert alert-danger">
            {{ $errors->first('company_id') }}
        </div>
    @endif
</div>

<div class="form-group">
    <label class="form-label" for="email">Email address</label>
    <input class="form-control" type="email" name="email" id="email"
        @if (old('_token'))
            value="{{ old('email') }}"
        @elseif (isset($employee))
            value="{{ $employee->email }}"
        @endif
        >
    @if ($errors->has('email'))
        <div class="alert alert-danger">
            {{ $errors->first('email') }}
        </div>
    @endif

    <label class="form-label" for="phone">Phone number</label>
    <input class="form-control" type="tel" name="phone" id="phone"
        @if (old('_token'))
            value="{{ old('phone') }}"
        @elseif (isset($employee))
            value="{{ $employee->phone }}"
        @endif
        >
    @if ($errors->has('phone'))
        <div class="alert alert-danger">
            {{ $errors->first('phone') }}
        </div>
    @endif
</div>
