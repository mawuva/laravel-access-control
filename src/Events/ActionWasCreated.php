<?php

namespace Mawuekom\Accontrol\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Mawuekom\Accontrol\Models\Action;

class ActionWasCreated
{
    use Dispatchable, SerializesModels;

    /**
     * @var \Mawuekom\Accontrol\Models\Action
     */
    public $action;

    /**
     * Create new event instance.
     *
     * @param \Mawuekom\Accontrol\Models\Action $action
     * 
     * @return void
     */
    public function __construct(Action $action)
    {
        $this->action = $action;
    }
}