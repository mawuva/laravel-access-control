<?php

namespace Mawuekom\Accontrol\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\Accontrol\Skeleton\SkeletonClass
 */
class Accontrol extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'accontrol';
    }
}
