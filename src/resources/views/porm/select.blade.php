@php
if (! isset($errors)) {
    $errors = collect();
}
@endphp
<div class="form-group row">
    <label for="{{ $name }}" class="col-md-3 col-form-label col-form-label-lg">{{ $label }}</label>
    
    <div class="col-md-8">
        <select id="{{ $name }}" name="{{ $name }}" class="{{ $class }}{{ $errors->has($errorName) ? ' is-invalid' : '' }}"  {!! $attr !!}>
            @foreach($items as $key => $item)
                <option value="{{ $key }}" {{ in_array($key, $selected) ? 'selected' : ''   }}>{{ $item }}</option>
            @endforeach
        </select>

        <div class="invalid-feedback">
            <strong>{{ $errors->first($errorName) }}</strong>
        </div>
    </div>
</div>