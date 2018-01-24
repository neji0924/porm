@php
if (! isset($errors)) {
    $errors = collect();
}
@endphp
<div class="form-group row{{ $errors->has($errorName) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-3 col-form-label col-form-label-lg">{{ $label }}</label>

    <div class="col-md-8">
        <textarea id="{{ $name }}" name="{{ $name }}" class="{{ $class }}" {!! $attr !!} >{{ $value or old($name) }}</textarea>

        @if ($errors->has($errorName))
            <span class="help-block">
                <strong>{{ $errors->first($errorName) }}</strong>
            </span>
        @endif
    </div>
</div>