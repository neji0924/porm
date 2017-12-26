<?php

namespace Neji0924\Porm;

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
            'attr'   => $this->makeFormAttr($attributes),
            'method' => $this->method,
            'csrf'   => $this->csrf
        ]));
    }

    public function model($model, $attributes = [])
    {
        $this->model = $model;

        return $this->open($attributes);
    }

    public function close()
    {
        return $this->toHtmlString('</form>');
    }

    private function toHtmlString($html)
    {
        return new HtmlString($html);
    }

    private function makeFormAttr($attributes)
    {
        $this->class = 'form-horizontal';

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

        $html[] = 'class="' . $this->class . '"';

        return ' ' . implode(' ', $html);
    }
    
    private function parseAttr($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        } elseif (is_bool($value) && $key != 'value') {
            return $value ? $key : '';
        } elseif ('class' == $key) {
            $this->class .= ' ' . $value;
        } elseif ('route' == $key) {
            if (is_array($value)) {
                return 'action="' . route($value[0], $value[1]) . '"';
            }
            
            return 'action="' . route($value) . '"';
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
        } elseif ($this->model && $this->model->$name) {
            $value = $this->model->$name;
        } else {
            $value = null;
        }
        
        return $this->toHtmlString(view("porm::{$method}", [
            'name'  => $name,
            'label' => $parameters[1] ?? $parameters[0],
            'value' => $value,
            'attr'  => $this->makeGeneralAttr($parameters[3] ?? [])
        ]));
    }
}
