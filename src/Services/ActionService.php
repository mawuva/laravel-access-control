<?php

namespace Accontrol\Services;

use Accontrol\Contracts\Persistables\ActionManager as ActionManagerContract;
use Accontrol\Persistables\ActionManager;
use Accontrol\Repositories\ActionRepository;

class ActionService implements ActionManagerContract
{
    use ActionManager;

    protected $resource;

    /**
     * @var \Accontrol\Repositories\ActionRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Accontrol\Repositories\ActionRepository $actionRepository
     * 
     * @return void
     */
    public function __construct(ActionRepository $actionRepository)
    {
        $this ->resource    = config('accontrol.action.resource_name');
        $this ->repository  = $actionRepository;
    }
}