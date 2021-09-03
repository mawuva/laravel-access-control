<?php

namespace Mawuekom\Accontrol\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Mawuekom\Accontrol\Http\Resources\Collections\PermissionCollection;

class RoleResource extends JsonResource
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
        $rolesTablePK    = config('accontrol.role.table.primary_key');

        $dataID = (uuid_is_enabled_and_has_column())
                    ? ['_id'    => $this ->{$uuidColumn}]
                    : ['id'     => $this ->{$rolesTablePK}];

        $id = (uuid_is_enabled_and_has_column())
                    ? $this ->{$uuidColumn}
                    : $this ->{$rolesTablePK};

        $data = [
            'name'          => $this ->name,
            'slug'          => $this ->slug,
            'description'   => $this ->description,
            'level'         => $this ->level,
            'links'         => [
                'show'      => url('roles/'.$id),
                'update'    => url('roles/'.$id.'/update'),
                'delete'    => url('roles/'.$id.'/delete'),
            ],
            'permissions'   => new PermissionCollection($this ->whenLoaded('permissions')),
        ];

        return array_merge($dataID, $data);
    }
}