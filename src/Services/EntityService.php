<?php

namespace Accontrol\Services;

use Accontrol\Contracts\Persistables\EntityManager as EntityManagerContract;
use Accontrol\Persistables\EntityManager;
use Accontrol\Repositories\EntityRepository;

class EntityService implements EntityManagerContract
{
    use EntityManager;

    protected $resource;

    /**
     * @var \Accontrol\Repositories\EntityRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Accontrol\Repositories\EntityRepository $entityRepository
     * 
     * @return void
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this ->resource    = config('accontrol.entity.resource_name');
        $this ->repository  = $entityRepository;
    }
}