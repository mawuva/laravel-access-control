<?php

namespace Mawuekom\Accontrol\Services;

use Mawuekom\Accontrol\Contracts\Persistables\ActionManager as ActionManagerContract;
use Mawuekom\Accontrol\Persistables\ActionManager;
use Mawuekom\Accontrol\Repositories\ActionRepository;

class ActionService implements ActionManagerContract
{
    use ActionManager;

    protected $resource;

    /**
     * @var \Mawuekom\Accontrol\Repositories\ActionRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Accontrol\Repositories\ActionRepository $actionRepository
     * 
     * @return void
     */
    public function __construct(ActionRepository $actionRepository)
    {
        $this ->resource    = config('accontrol.action.resource_name');
        $this ->repository  = $actionRepository;
    }
}