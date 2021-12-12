<?php

namespace Mawuekom\Accontrol\Assignables;

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
        $entityModel                = config('accontrol.entity.model');
        $permissionsTable           = config('accontrol.permission.table.name');
        $permissionsTableActionFK   = config('accontrol.permission.table.action_foreign_key');
        $permissionsTableEntityFK   = config('accontrol.permission.table.entity_foreign_key');

        return $this ->belongsToMany($entityModel, $permissionsTable, $permissionsTableActionFK, $permissionsTableEntityFK);
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
        $permissionModel            = config('accontrol.permission.model');
        $permissionsTableActionFK   = config('accontrol.permission.table.action_foreign_key');
        $actionsTablePK             = config('accontrol.action.table.name');

        return $this ->hasMany($permissionModel, $permissionsTableActionFK, $actionsTablePK);
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