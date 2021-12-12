<?php

namespace Mawuekom\Accontrol\Listeners;

use Mawuekom\Accontrol\Events\EntityWasCreated;
use Mawuekom\Accontrol\Facades\Accontrol;

class ResolveEntityPermissions
{
    /**
     * Handle listener
     *
     * @param \Mawuekom\Accontrol\Events\EntityWasCreated $event
     *
     * @return void
     */
    public function handle(EntityWasCreated $event)
    {
        Accontrol::resolveEntityPermissions($event ->entity);
    }
}