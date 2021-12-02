<?php

namespace Mawuekom\Accontrol\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Accontrol\DataTransferObjects\PermissionDTO;

class SavepermissionAction
{
    /**
     * Execute action
     *
     * @param \Mawuekom\Accontrol\DataTransferObjects\PermissionDTO $permissionDTO
     * @param int|string|null $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(PermissionDTO $permissionDTO, $id = null): Model
    {
        $permission = data_helpers(config('accontrol.permission.model')) ->getModelInstance($id);
        
        $permission ->name         = $permissionDTO ->name;
        $permission ->slug         = ($permissionDTO ->slug !== null) ? $permissionDTO ->slug : $permissionDTO ->name;
        $permission ->description  = $permissionDTO ->description;

        $permission ->save();

        return $permission;
    }
}