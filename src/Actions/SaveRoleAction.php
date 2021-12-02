<?php

namespace Mawuekom\Accontrol\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Accontrol\DataTransferObjects\RoleDTO;
use Mawuekom\Accontrol\Facades\Accontrol;

class SaveRoleAction
{
    /**
     * Execute action
     *
     * @param \Mawuekom\Accontrol\DataTransferObjects\RoleDTO $roleDTO
     * @param int|string|null $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(RoleDTO $roleDTO, $id = null): Model
    {
        $role = data_helpers(config('accontrol.role.model')) ->getModelInstance($id);
        
        $role ->name         = $roleDTO ->name;
        $role ->slug         = ($roleDTO ->slug !== null) ? $roleDTO ->slug : $roleDTO ->name;
        $role ->description  = $roleDTO ->description;
        $role ->level        = $roleDTO ->level;

        $role ->save();

        return $role;
    }
}