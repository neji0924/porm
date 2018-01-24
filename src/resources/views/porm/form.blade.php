<form class="{{ $class }}" {!! $attr !!}{!! $csrf ? ' method="POST"' : '' !!}>
@if ($csrf)
    {{ csrf_field() }}
@endif

@if ($method)
    <input type="hidden" name="_method" value="{{ $method }}">
@endif
