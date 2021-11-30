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
        $role = ($id !== null)
                        ? Accontrol::getEntityById(config('accontrol.role.slug'), $id)
                        : app(config('accontrol.role.model'));
        
        $role ->name         = $roleDTO ->name;
        $role ->slug         = ($roleDTO ->slug !== null) ? $roleDTO ->slug : $roleDTO ->name;
        $role ->description  = $roleDTO ->description;
        $role ->level        = $roleDTO ->level;

        $role ->save();

        return $role;
    }
}