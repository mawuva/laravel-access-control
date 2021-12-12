<?php

namespace Mawuekom\Accontrol\Actions;

use Illuminate\Database\Eloquent\Model;
use Mawuekom\Accontrol\DataTransferObjects\ActionDTO;
use Mawuekom\Accontrol\Events\ActionWasCreated;

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
        $new = true;

        $action = data_helpers(config('accontrol.action.model')) ->getModelInstance($id);

        if ($action ->{config('accontrol.action.table.primary_key')} !== null) {
            $new = false;
        }
        
        $action ->name                          = $actionDTO ->name;
        $action ->slug                          = ($actionDTO ->slug !== null) ? $actionDTO ->slug : $actionDTO ->name;
        $action ->description                   = $actionDTO ->description;
        $action ->available_for_all_entities    = ($actionDTO ->available_for_all_entities !== null) ? $actionDTO ->available_for_all_entities : 0;

        $action ->save();

        if ($new) {
            event(new ActionWasCreated($action));
        }

        return $action;
    }
}