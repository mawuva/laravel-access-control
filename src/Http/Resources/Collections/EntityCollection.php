<?php

namespace Mawuekom\Accontrol\Http\Resources\Collections;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Mawuekom\Accontrol\Http\Resources\EntityResource;

class EntityCollection extends ResourceCollection
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
            'data' => EntityResource::collection($this ->collection),
            'meta' => [
                'total' => $this->collection->count(),
                'links' => [
                    'index' => url('entities'),
                    'store' => url('entities'),
                ],
            ]
        ];
    }
}