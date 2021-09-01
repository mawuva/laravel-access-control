<?php

namespace Mawuekom\LaravelAccessControl;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mawuekom\LaravelAccessControl\Skeleton\SkeletonClass
 */
class LaravelAccessControlFacade extends Facade
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
