<?php

namespace Mawuekom\Accontrol\Services;

use Mawuekom\Accontrol\Contracts\Persistables\EntityManager as EntityManagerContract;
use Mawuekom\Accontrol\Persistables\EntityManager;
use Mawuekom\Accontrol\Repositories\EntityRepository;

class EntityService implements EntityManagerContract
{
    use EntityManager;

    protected $resource;

    /**
     * @var \Mawuekom\Accontrol\Repositories\EntityRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Accontrol\Repositories\EntityRepository $entityRepository
     * 
     * @return void
     */
    public function __construct(EntityRepository $entityRepository)
    {
        $this ->resource    = config('accontrol.entity.resource_name');
        $this ->repository  = $entityRepository;
    }
}