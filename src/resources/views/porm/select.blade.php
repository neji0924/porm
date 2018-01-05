@php
if (! isset($errors)) {
    $errors = collect();
}
@endphp
<div class="form-group row{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="email" class="col-md-3 col-form-label col-form-label-lg">{{ $label }}</label>
    
    <div class="col-md-8">
        <select id="{{ $name }}" name="{{ $name }}" {!! $attr !!}>
            @foreach($items as $key => $item)
                <option value="{{ $key }}" {{ in_array($key, $selected) ? 'selected' : ''   }}>{{ $item }}</option>
            @endforeach
        </select>

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>