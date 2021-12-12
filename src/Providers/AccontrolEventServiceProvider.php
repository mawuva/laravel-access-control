<?php

namespace Mawuekom\Accontrol\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Mawuekom\Accontrol\Events\ActionWasCreated;
use Mawuekom\Accontrol\Events\EntityWasCreated;
use Mawuekom\Accontrol\Listeners\ResolveActionPermissions;
use Mawuekom\Accontrol\Listeners\ResolveEntityPermissions;

class AccontrolEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        EntityWasCreated::class => [
            ResolveEntityPermissions::class,
        ],

        ActionWasCreated::class => [
            ResolveActionPermissions::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}