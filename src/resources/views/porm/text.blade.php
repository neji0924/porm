@php
if (! isset($errors)) {
    $errors = collect();
}
@endphp
<div class="form-group row">
    <label for="{{ $name }}" class="col-md-3 col-form-label col-form-label-lg">{{ $label }}</label>

    <div class="col-md-8">
        <input id="{{ $name }}" type="text" name="{{ $name }}" value="{{ $value or old($name) }}" class="{{ $class }}" {!! $attr !!}>

        @if ($errors->has($errorName))
            <span class="help-block">
                <strong>{{ $errors->first($errorName) }}</strong>
            </span>
        @endif
    </div>
</div>

{{--  {{ $errors->has($errorName) ? ' is-invalid' : '' }}  --}}