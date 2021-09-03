<?php

namespace Mawuekom\Accontrol\Repositories;

use Mawuekom\RepositoryLayer\BaseApiRepository;

class PermissionRepository extends BaseApiRepository
{
    public function model()
    {
        return config('accontrol.permission.model');
    }

    /**
     * Determine the columns on which the search will be done
     */
    public function searchFields(): array
    {
        return ['name', 'slug'];
    }
    
    /**
     * Columns on which filterig will be done
     */
    public function filters(): array
    {
        return ['name', 'slug'];
    }

    /**
     * Determine by which property the results collection will be ordered
     */
    public function sorts(): array
    {
        return [];
    }

    /**
     * Determine the relation that will be load on the resulting model   collection
     */
    public function collectionRelation(): array
    {
        return ['entity', 'action'];
    }

    /**
     * Determine the relation that will be load on the resulting model resource
     */
    public function resourceRelation(): array
    {
        return ['entity', 'action', 'roles', 'users'];
    }

    /**
     * Define a couple fields that will be fetch to reduce the overall size of your SQL query
     */
    public function fields(): array
    {
        return [];
    }
}