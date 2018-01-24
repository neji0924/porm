@php
if (! isset($errors)) {
    $errors = collect();
}
@endphp
<div class="form-group row">
    <label for="{{ $name }}" class="col-md-3 col-form-label col-form-label-lg">{{ $label }}</label>

    <div class="col-md-8">
        <textarea id="{{ $name }}" name="{{ $name }}" class="{{ $class }}{{ $errors->has($errorName) ? ' is-invalid' : '' }}" {!! $attr !!} >{{ $value or old($name) }}</textarea>

        <div class="invalid-feedback">
            <strong>{{ $errors->first($errorName) }}</strong>
        </div>
    </div>
</div>