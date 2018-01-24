<?php

namespace Neji0924\Porm;

use Route;
use Session;
use Illuminate\Support\HtmlString;

class Porm
{
    private $method;
    private $class;
    private $model;
    private $csrf = true;

    public function open(Array $attributes = [])
    {
        return $this->toHtmlString(view("porm::form", [
            'attr'   => $this->makeGeneralAttr($attributes),
            'method' => $this->method,
            'csrf'   => $this->csrf,
            'class'  => $this->class
        ]));
    }

    public function model($model, $attributes = [])
    {
        $this->model = $model;

        return $this->open($attributes);
    }

    public function select($name, $label, $items, $selected = [], $attributes = [])
    {
        if(null === $selected) {
            $selected = [];
        }

        if ($selected == [] && $this->model) {
            $key = str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $name);
            $selected = data_get($this->model, $key);
        }

        return $this->toHtmlString(view('porm::select', [
            'name'     => $name,
            'errorName' =>str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $name),
            'label'    => $label,
            'items'    => $items,
            'selected' => is_array($selected) ? $selected : [$selected],
            'attr'     => $this->makeGeneralAttr($attributes),
            'class'  => $this->class
        ]));
    }

    public function button($content, $attributes = [], $type = 'button')
    {
        return $this->toHtmlString(view('porm::button', [
            'content'  => $content,
            'attr'     => $this->makeButtonAttr($attributes),
            'type'     => $type,
            'class'    => $this->class
        ]));
    }

    public function submit($content, $attributes = [])
    {
        return $this->button($content, $attributes, 'submit');
    }

    public function close()
    {
        return $this->toHtmlString('</form>');
    }

    public function hidden($key, $value)
    {
        return $this->toHtmlString(view('porm::hidden', compact('key', 'value')));
    }

    public function file($name, $label = null, $attributes = [])
    {
        return $this->toHtmlString(view("porm::file", [
            'name'  => $name,
            'errorName' =>str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $name),
            'label' => $label,
            'attr'  => $this->makeGeneralAttr($attributes),
            'class' => $this->class
        ]));
    }

    private function toHtmlString($html)
    {
        return new HtmlString($html);
    }

    private function makeButtonAttr($attributes)
    {
        if (isset($attributes['class']) && preg_match('/btn-/', $attributes['class'])) {
            $this->class = 'form-control';
        } else {
            $this->class = 'form-control btn btn-info';
        }

        return $this->makeAttr($attributes);
    }

    private function makeGeneralAttr($attributes)
    {
        $this->class = 'form-control';

        return $this->makeAttr($attributes);
    }
    
    private function makeAttr($attributes)
    {
        $html = [];

        foreach ($attributes as $key => $value) {
            $element = $this->parseAttr($key, $value);

            if (! is_null($element)) {
                $html[] = $element;
            }
        }

        return ' ' . implode(' ', $html);
    }
    
    private function parseAttr($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        } elseif (is_bool($value) && $key != 'value') {
            if ('file' === $key) {
                return $value ? 'enctype="multipart/form-data"' : '';
            }

            return $value ? $key : '';
        } elseif ('class' == $key) {
            $this->class .= ' ' . $value;
        } elseif ('route' == $key) {
            if (is_array($value)) {
                return 'action="' . route($value[0], $value[1]) . '"';
            } elseif(Route::has($value)) {
                return 'action="' . route($value) . '"';
            }

            return 'action="' . $value . '"';
        } elseif ('method' == $key) {
            $method = strtoupper($value);
            if ('GET' === $method) {
                $this->csrf = false;
            } elseif(in_array($method, ['PUT', 'PATCH', 'DELETE'])) {
                $this->method = $method;
            }
        } else {
            return $key . '="' . $value . '"';
        }
    }

    public function __call($method, $parameters)
    {
        $name = $parameters[0];

        if (isset($parameters[2])) {
            $value = $parameters[2];
        } elseif ($this->model) {
            //https://github.com/LaravelCollective/html/blob/5.5/src/FormBuilder.php line:1196
            $key = str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $name);
            $value = data_get($this->model, $key);
        } else {
            $value = null;
        }
        
        return $this->toHtmlString(view("porm::{$method}", [
            'name'  => $name,
            'errorName' =>str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $name),
            'label' => $parameters[1] ?? $parameters[0],
            'value' => $value,
            'attr'  => $this->makeGeneralAttr($parameters[3] ?? []),
            'class' => $this->class
        ]));
    }
}
