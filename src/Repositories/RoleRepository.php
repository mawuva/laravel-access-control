<?php

namespace Mawuekom\Accontrol\Repositories;

use Mawuekom\Repository\Eloquent\BaseRepository;
use Mawuekom\Repository\Logics\QueryLogic;

class RoleRepository extends BaseRepository
{
    use QueryLogic;

    /**
     * Get the model on which works
     * 
     * @return Model|string
     */
    public function model()
    {
        return config('accontrol.role.model');
    }

    /**
     * Get the columns on which the search will be done
     * 
     * @return array
     */
    public function searchableFields()
    {
        return ['name', 'slug', 'level'];
    }

    /**
     * Columns on which filterig will be done
     * 
     * @return array
     */
    public function filterableFields(): array
    {
        return ['name', 'slug', 'level'];
    }

    /**
     * Determine by which property the results collection will be ordered
     * 
     * @return array
     */
    public function sortableFields(): array
    {
        return ['name', 'slug', 'level', 'created_at'];
    }

    /**
     * Determine the relation that will be load on the resulting model
     * 
     * @return array
     */
    public function includableRelations(): array
    {
        return ['users'];
    }

    /**
     * Define a couple fields that will be fetch to reduce the overall size of your SQL query
     * 
     * @return array
     */
    public function selectableFields(): array
    {
        return ['name', 'slug', 'level'];
    }
}