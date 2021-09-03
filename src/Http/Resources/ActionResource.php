<?php

namespace Mawuekom\Accontrol\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mawuekom\Accontrol\Http\Resources\Collections\EntityCollection;
use Mawuekom\Accontrol\Http\Resources\Collections\PermissionCollection;

class ActionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
    {
        $uuidColumn             = config('accontrol.uuids.column');
        $actionsTablePK    = config('accontrol.action.table.primary_key');

        $dataID = (uuid_is_enabled_and_has_column())
                    ? ['_id'    => $this ->{$uuidColumn}]
                    : ['id'     => $this ->{$actionsTablePK}];

        $id = (uuid_is_enabled_and_has_column())
                    ? $this ->{$uuidColumn}
                    : $this ->{$actionsTablePK};

        $data = [
            'name'                          => $this ->name,
            'slug'                          => $this ->slug,
            'description'                   => $this ->description,
            'available_for_all_entities'    => $this ->available_for_all_entities,
            'links'                         => [
                'show'                      => url('actions/'.$id),
                'update'                    => url('actions/'.$id.'/update'),
                'delete'                    => url('actions/'.$id.'/delete'),
            ],
            'entities'                      => new EntityCollection($this ->whenLoaded('entities')),
            'permissions'                   => new PermissionCollection($this ->whenLoaded('permissions')),
        ];

        return array_merge($dataID, $data);
    }
}