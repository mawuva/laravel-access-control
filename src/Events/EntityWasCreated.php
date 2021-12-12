<?php

namespace Mawuekom\Accontrol\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Mawuekom\Accontrol\Models\Entity;

class EntityWasCreated
{
    use Dispatchable, SerializesModels;

    /**
     * @var \Mawuekom\Accontrol\Models\Entity
     */
    public $entity;

    /**
     * Create new event instance.
     *
     * @param \Mawuekom\Accontrol\Models\Entity $entity
     * 
     * @return void
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }
}