<?php

namespace Mawuekom\Accontrol\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mawuekom\Accontrol\Http\Resources\Collections\ActionCollection;
use Mawuekom\Accontrol\Http\Resources\Collections\PermissionCollection;

class EntityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request): array
    {
        $uuidColumn         = config('accontrol.uuids.column');
        $entitiesTablePK    = config('accontrol.entity.table.primary_key');

        $dataID = (uuid_is_enabled_and_has_column())
                    ? ['_id'    => $this ->{$uuidColumn}]
                    : ['id'     => $this ->{$entitiesTablePK}];

        $id = (uuid_is_enabled_and_has_column())
                    ? $this ->{$uuidColumn}
                    : $this ->{$entitiesTablePK};

        $data = [
            'name'          => $this ->name,
            'slug'          => $this ->slug,
            'description'   => $this ->description,
            'model'         => $this ->model,
            'links'         => [
                'show'      => url('entities/'.$id),
                'update'    => url('entities/'.$id.'/update'),
                'delete'    => url('entities/'.$id.'/delete'),
            ],
            'actions'       => new ActionCollection($this ->whenLoaded('actions')),
            'permissions'   => new PermissionCollection($this ->whenLoaded('permissions')),
        ];

        return array_merge($dataID, $data);
    }
}