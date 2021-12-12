<?php

namespace Mawuekom\Accontrol;

use Illuminate\Database\Eloquent\Model;

class Accontrol
{
    /**
     * Resolve entity permissions
     *
     * @param string|int|\Illuminate\Database\Eloquent\Model $entity
     *
     * @return void
     */
    public function resolveEntityPermissions(Model $entity)
    {
        $actions = config('accontrol.action.model')::where('available_for_all_entities', 1) ->get(['id', 'name', 'slug']);

        foreach ($actions as $action) {
            $checkPermission = config('accontrol.permission.model')::where(['action_id' => $action->id, 'entity_id' => $entity->id]) 
                                ->first(['id']);
            
            $newPermissionItem = config('accontrol.permission.model')::where('slug', '=', $action ->slug.'-'.$entity ->slug)->first(['id']);

            if ($checkPermission === null && $newPermissionItem === null) {
                config('accontrol.permission.model')::create([
                    'name'          => ucwords('Can '.$action ->name.' '.$entity ->name),
                    'slug'          => $action ->slug.'-'.$entity ->slug,
                    'description'   => ucfirst('Can '.$action ->name.' '.$entity ->name),
                    'action_id'     => $action ->id,
                    'entity_id'     => $entity ->id,
                ]);
            }
        }
    }

    /**
     * Resolve action permissions
     *
     * @param \Illuminate\Database\Eloquent\Model $action
     *
     * @return void
     */
    public function resolveActionPermissions(Model $action)
    {
        if ($action ->available_for_all_entities === 1) {
            $entities = config('accontrol.entity.model')::all(['id', 'name', 'slug']);

            foreach ($entities as $entity) {
                $checkPermission = config('accontrol.permission.model')::where(['action_id' => $action->id, 'entity_id' => $entity->id]) 
                                ->first(['id']);

                $newPermissionItem = config('accontrol.permission.model')::where('slug', '=', $action ->slug.'-'.$entity ->slug)
                                ->first(['id']);

                if ($checkPermission === null && $newPermissionItem === null) {
                    config('accontrol.permission.model')::create([
                        'name'          => ucwords('Can '.$action ->name.' '.$entity ->name),
                        'slug'          => $action ->slug.'-'.$entity ->slug,
                        'description'   => ucfirst('Can '.$action ->name.' '.$entity ->name),
                        'action_id'     => $action ->id,
                        'entity_id'     => $entity ->id,
                    ]);
                }
            }
        }
    }
}
