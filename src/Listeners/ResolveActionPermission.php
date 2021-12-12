<?php

namespace Mawuekom\Accontrol\Listeners;

use Mawuekom\Accontrol\Events\ActionWasCreated;
use Mawuekom\Accontrol\Facades\Accontrol;

class ResolveActionPermissions
{
    /**
     * Handle listener
     *
     * @param \Mawuekom\Accontrol\Events\ActionWasCreated $event
     *
     * @return void
     */
    public function handle(ActionWasCreated $event)
    {
        Accontrol::resolveActionPermissions($event ->action);
    }
}