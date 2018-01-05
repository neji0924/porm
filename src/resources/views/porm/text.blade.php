@php
if (! isset($errors)) {
    $errors = collect();
}
@endphp
<div class="form-group row{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="{{ $name }}" class="col-md-3 col-form-label col-form-label-lg">{{ $label }}</label>

    <div class="col-md-8">
        <input id="{{ $name }}" type="text" name="{{ $name }}" value="{{ $value or old($name) }}"  {!! $attr !!} >

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>