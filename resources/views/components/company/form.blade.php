<div class="form-group">
    <label class="form-label" for="name">Name:</label>
    <input class="form-control" type="text" name="name" id="name" required
        @if (old('_token'))
            value="{{ old('name') }}"
        @elseif (isset($company))
            value="{{ $company->name }}"
        @endif
        >
    @if ($errors->has('name'))
        <div class="alert alert-danger">
            <p>{{ $errors->first('name') }}</p>
        </div>
    @endif
</div>

<div class="form-group">
    <input type="file" name="logo-file" id="logo-file">
</div>

<div class="form-group">
    <label class="form-label" for="email">Email address</label>
    <input class="form-control" type="email" name="email" id="email"
        @if (old('_token'))
            value="{{ old('email') }}"
        @elseif (isset($company))
            value="{{ $company->email }}"
        @endif
        >
    @if ($errors->has('email'))
        <div class="alert alert-danger">
            <p>{{ $errors->first('email') }}</p>
        </div>
    @endif

    <label class="form-label" for="website">Website</label>
    <input class="form-control" type="text" name="website" id="website"
        @if (old('_token'))
            value="{{ old('website') }}"
        @elseif (isset($company))
            value="{{ $company->website }}"
        @endif
        >
    @if ($errors->has('website'))
        <div class="alert alert-danger">
            <p>{{ $errors->first('website') }}</p>
        </div>
    @endif
</div>
