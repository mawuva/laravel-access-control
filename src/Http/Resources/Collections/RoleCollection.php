<?php

namespace Mawuekom\Accontrol\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Mawuekom\Accontrol\Http\Resources\RoleResource;

class RoleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => RoleResource::collection($this ->collection),
            'meta' => [
                'total' => $this->collection->count(),
                'links' => [
                    'index' => url('roles'),
                    'store' => url('roles'),
                ],
            ]
        ];
    }
}