<?php

namespace Mawuekom\Accontrol\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mawuekom\Accontrol\Http\Resources\ActionResource;
use Mawuekom\Accontrol\Http\Resources\Collections\RoleCollection;
use Mawuekom\Accontrol\Http\Resources\EntityResource;

class PermissionResource extends JsonResource
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
        $permissionsTablePK    = config('accontrol.permission.table.primary_key');

        $dataID = (uuid_is_enabled_and_has_column())
                    ? ['_id'    => $this ->{$uuidColumn}]
                    : ['id'     => $this ->{$permissionsTablePK}];

        $id = (uuid_is_enabled_and_has_column())
                    ? $this ->{$uuidColumn}
                    : $this ->{$permissionsTablePK};

        $data = [
            'name'          => $this ->name,
            'slug'          => $this ->slug,
            'description'   => $this ->description,
            'links'         => [
                'show'      => url('permissions/'.$id),
                'update'    => url('permissions/'.$id.'/update'),
                'delete'    => url('permissions/'.$id.'/delete'),
            ],
            'entity'        => new EntityResource($this ->whenLoaded('entity')),
            'action'        => new ActionResource($this ->whenLoaded('action')),
            'roles'         => new RoleCollection($this ->whenLoaded('roles')),
        ];

        return array_merge($dataID, $data);
    }
}