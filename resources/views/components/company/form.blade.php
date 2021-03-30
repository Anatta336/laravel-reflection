<div class="form-group">
    <label class="form-label required" for="name">Name:</label>
    <input class="form-control" type="text" name="name" id="name" required
        @if (old('_token'))
            value="{{ old('name') }}"
        @elseif (isset($company))
            value="{{ $company->name }}"
        @endif
        >
    @if ($errors->has('name'))
        <div class="alert alert-danger">
            {{ $errors->first('name') }}
        </div>
    @endif
</div>

<div class="form-group">
    <label class="form-label required" for="logo-file">Logo:</label>
    <input class="form-control" type="file" name="logo-file" id="logo-file"
        accept=".png, .jpg, .jpeg, .webp, image/*">
    @if ($errors->has('logo-file'))
        <div class="alert alert-danger">
            {{ $errors->first('logo-file') }}
        </div>
    @endif
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
            {{ $errors->first('email') }}
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
            {{ $errors->first('website') }}
        </div>
    @endif
</div>
