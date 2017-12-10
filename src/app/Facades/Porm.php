<?php

namespace Neji0924\Porm\Facades;

use Illuminate\Support\Facades\Facade;

class Porm extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'porm';
    }
}
