<?php

namespace Mawuekom\Accontrol;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\Accontrol\Skeleton\SkeletonClass
 */
class AccontrolFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-access-control';
    }
}
