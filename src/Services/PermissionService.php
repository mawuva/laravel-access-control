<?php

namespace Mawuekom\Accontrol\Services;

use Mawuekom\Accontrol\Contracts\Persistables\PermissionManager as PermissionManagerContract;
use Mawuekom\Accontrol\Persistables\PermissionManager;
use Mawuekom\Accontrol\Repositories\PermissionRepository;

class PermissionService implements PermissionManagerContract
{
    use PermissionManager;

    protected $resource;

    /**
     * @var \Mawuekom\Accontrol\Repositories\PermissionRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Mawuekom\Accontrol\Repositories\PermissionRepository $permissionRepository
     * 
     * @return void
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this ->resource    = config('accontrol.permission.resource_name');
        $this ->repository  = $permissionRepository;
    }
}