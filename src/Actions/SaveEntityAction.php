<?php

namespace Mawuekom\Accontrol\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Accontrol\DataTransferObjects\EntityDTO;

class SaveEntityAction
{
    /**
     * Execute action
     *
     * @param \Mawuekom\Accontrol\DataTransferObjects\EntityDTO $entityDTO
     * @param int|string|null $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(EntityDTO $entityDTO, $id = null): Model
    {
        $entity = data_helpers(config('accontrol.entity.model')) ->getModelInstance($id);
        
        $entity ->name         = $entityDTO ->name;
        $entity ->slug         = ($entityDTO ->slug !== null) ? $entityDTO ->slug : $entityDTO ->name;
        $entity ->model        = $entityDTO ->model;
        $entity ->description  = $entityDTO ->description;

        $entity ->save();

        return $entity;
    }
}