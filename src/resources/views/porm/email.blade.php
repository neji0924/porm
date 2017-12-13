<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
    <label for="email" class="col-md-4 control-label">{{ $label }}</label>

    <div class="col-md-6">
        <input id="{{ $name }}" type="email" name="{{ $name }}" value="{{ old($name) }}"  {!! $attr !!} >

        @if ($errors->has($name))
            <span class="help-block">
                <strong>{{ $errors->first($name) }}</strong>
            </span>
        @endif
    </div>
</div>