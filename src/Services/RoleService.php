<?php

namespace Mawuekom\Accontrol\Services;

use Mawuekom\Accontrol\Contracts\Persistables\RoleManager as RoleManagerContract;
use Mawuekom\Accontrol\Persistables\RoleManager;
use Mawuekom\Accontrol\Repositories\RoleRepository;

class RoleService implements RoleManagerContract
{
    use RoleManager;

    protected $resource;

    /**
     * @var \Mawuekom\Accontrol\Repositories\RoleRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Accontrol\Repositories\RoleRepository $roleRepository
     * 
     * @return void
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this ->resource    = config('accontrol.role.resource_name');
        $this ->repository  = $roleRepository;
    }
}