<?php

namespace Accontrol\Services;

use Accontrol\Contracts\Persistables\RoleManager as RoleManagerContract;
use Accontrol\Persistables\RoleManager;
use Accontrol\Repositories\RoleRepository;

class RoleService implements RoleManagerContract
{
    use RoleManager;

    protected $resource;

    /**
     * @var \Accontrol\Repositories\RoleRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Accontrol\Repositories\RoleRepository $roleRepository
     * 
     * @return void
     */
    public function __construct(RoleRepository $roleRepository)
    {
        $this ->resource    = config('accontrol.role.resource_name');
        $this ->repository  = $roleRepository;
    }
}