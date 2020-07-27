<?php

namespace Ezias\MultiQueue\Facades;

use Illuminate\Support\Facades\Facade;

class MultiQueue extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'multiqueue';
    }
}
