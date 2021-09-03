<?php

namespace Accontrol\Services;

use Accontrol\Contracts\Persistables\PermissionManager as PermissionManagerContract;
use Accontrol\Persistables\PermissionManager;
use Accontrol\Repositories\PermissionRepository;

class PermissionService implements PermissionManagerContract
{
    use PermissionManager;

    protected $resource;

    /**
     * @var \Accontrol\Repositories\PermissionRepository
     */
    protected $repository;

    /**
     * Create new service instance.
     *
     * @param \Accontrol\Repositories\PermissionRepository $permissionRepository
     * 
     * @return void
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this ->resource    = config('accontrol.permission.resource_name');
        $this ->repository  = $permissionRepository;
    }
}