<?php

namespace Mawuekom\Accontrol\Assignables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait EntityHasRelations
{
    /**
     * Entity belongs to many actions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actions(): BelongsToMany
    {
        $actionModel                = config('accontrol.action.model');
        $permissionsTable           = config('accontrol.permission.table.name');
        $permissionsTableEntityFK   = config('accontrol.permission.table.entity_foreign_key');
        $permissionsTableActionFK   = config('accontrol.permission.table.action_foreign_key');

        return $this ->belongsToMany($actionModel, $permissionsTable, $permissionsTableEntityFK, $permissionsTableActionFK);
    }

    /**
     * Count roles to which permission belongs to.
     *
     * @return int
     */
    public function getActionsCountAttribute(): int
    {
        return $this ->actions() ->count();
    }

    /**
     * Entity belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions(): HasMany
    {
        $permissionModel            = config('accontrol.permission.model');
        $permissionsTableEntityFK   = config('accontrol.permission.table.entity_foreign_key');
        $entitiesTablePK            = config('accontrol.entity.table.primary_key');

        return $this ->hasMany($permissionModel, $permissionsTableEntityFK, $entitiesTablePK);
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