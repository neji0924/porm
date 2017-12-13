<?php

namespace Neji0924\Porm;

use Session;
use Illuminate\Support\HtmlString;

class Porm
{
    private $class = 'form-control';

    public function password($name, $label = null, $attributes = [])
    {
        $attr = $this->makeAttr($attributes);

        return $this->toHtmlString(view('porm::password', compact(
            'name',
            'label',
            'attr'
        )));
    }

    private function toHtmlString($html)
    {
        return new HtmlString($html);
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
        } else {
            return $key . '="' . $value . '"';
        }
    }
}
