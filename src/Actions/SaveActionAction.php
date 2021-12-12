<?php

namespace Mawuekom\Accontrol\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Accontrol\DataTransferObjects\ActionDTO;

class SaveActionAction
{
    /**
     * Execute action
     *
     * @param \Mawuekom\Accontrol\DataTransferObjects\ActionDTO $actionDTO
     * @param int|string|null $id
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute(ActionDTO $actionDTO, $id = null): Model
    {
        $action = data_helpers(config('accontrol.action.model')) ->getModelInstance($id);
        
        $action ->name                          = $actionDTO ->name;
        $action ->slug                          = ($actionDTO ->slug !== null) ? $actionDTO ->slug : $actionDTO ->name;
        $action ->description                   = $actionDTO ->description;
        $action ->available_for_all_entities    = ($actionDTO ->available_for_all_entities !== null) ? $actionDTO ->available_for_all_entities : 0;

        $action ->save();

        return $action;
    }
}