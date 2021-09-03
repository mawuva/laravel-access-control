<?php

namespace Accontrol\Featurables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait ActionHasRelations
{
    /**
     * Action belongs to many entities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function entities(): BelongsToMany
    {
        $entity_model = config('accontrol.entity.model');
        $permissions_table = config('accontrol.permission.table.name');
        $permissions_table_action_fk = config('accontrol.permission.table.action_foreign_key');
        $permissions_table_entity_fk = config('accontrol.permission.table.entity_foreign_key');

        return $this ->belongsToMany($entity_model, $permissions_table, $permissions_table_action_fk, $permissions_table_entity_fk) 
                     ->withTimestamps();
    }

    /**
     * Count roles to which permission belongs to.
     *
     * @return int
     */
    public function getEntitiesCountAttribute(): int
    {
        return $this ->entities() ->count();
    }

    /**
     * Action belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions(): HasMany
    {
        $permission_model = config('accontrol.permission.model');
        $permissions_table_action_fk = config('accontrol.permission.table.action_foreign_key');
        $actions_table_pk = config('accontrol.action.table.name');

        return $this ->hasMany($permission_model, $permissions_table_action_fk, $actions_table_pk)
                     ->withTimestamps();
    }

    /**
     * Count users to which permission belongs to.
     *
     * @return int
     */
    public function getPermissionsCountAttribute(): int
    {
        return $this ->permissions() ->count();
    }
}