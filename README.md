# Porm

##安裝

##使用

範例:

```php
{{ Porm::email('email', '信箱', ['class' => 'text-red', 'required']) }}
```
產生

```html
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
    <label for="email" class="col-md-4 control-label">信箱</label>

    <div class="col-md-6">
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>
```
---
- email
- password
