@php
if (! isset($errors)) {
    $errors = collect();
}
@endphp
<div class="form-group row">
    <label for="{{ $name }}" class="col-md-3 col-form-label col-form-label-lg">{{ $label }}</label>

    <div class="col-md-8">
        <input id="{{ $name }}" type="email" name="{{ $name }}" value="{{ $value or old($name) }}" class="{{ $class }}{{ $errors->has($errorName) ? ' is-invalid' : '' }}" {!! $attr !!} >

        <div class="invalid-feedback">
            <strong>{{ $errors->first($errorName) }}</strong>
        </div>
    </div>
</div>