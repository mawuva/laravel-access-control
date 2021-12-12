<?php

namespace Mawuekom\Accontrol\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Accontrol\DataTransferObjects\EntityDTO;
use Mawuekom\Accontrol\Events\EntityWasCreated;

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
        $new = true;

        $entity = data_helpers(config('accontrol.entity.model')) ->getModelInstance($id);
        
        if ($entity ->{config('accontrol.entity.table.primary_key')} !== null) {
            $new = false;
        }
        
        $entity ->name         = $entityDTO ->name;
        $entity ->slug         = ($entityDTO ->slug !== null) ? $entityDTO ->slug : $entityDTO ->name;
        $entity ->model        = $entityDTO ->model;
        $entity ->description  = $entityDTO ->description;

        $entity ->save();

        if ($new) {
            event(new EntityWasCreated($entity));
        }

        return $entity;
    }
}