<?php

namespace Mawuekom\Accontrol\Featurables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait RoleHasRelations
{
    /**
     * Role belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        $permission_model = config('accontrol.permission.model');
        $permission_role_table = config('accontrol.permission_role.table.name');
        $permission_role_table_role_fk = config('accontrol.permission_role.table.role_foreign_key');
        $permission_role_table_permission_fk = config('accontrol.permission_role.table.permission_foreign_key');

        return $this ->belongsToMany($permission_model, $permission_role_table, $permission_role_table_role_fk, $permission_role_table_permission_fk) 
                     ->withTimestamps();
    }

    /**
     * Count permissions to which role belongs to.
     *
     * @return int
     */
    public function getPermissionsCountAttribute(): int
    {
        return $this ->permissions() ->count();
    }

    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        $user_model = config('accontrol.user.model');
        $role_user_table = config('accontrol.role_user.table.name');
        $role_user_table_role_fk = config('accontrol.role_user.table.role_foreign_key');
        $role_user_table_user_fk = config('accontrol.role_user.table.user_foreign_key');

        return $this ->belongsToMany($user_model, $role_user_table, $role_user_table_role_fk, $role_user_table_user_fk) 
                     ->withTimestamps();
    }

    /**
     * Count users to which role belongs to.
     *
     * @return int
     */
    public function getUsersCountAttribute(): int
    {
        return $this ->users() ->count();
    }

    /**
     * Attach permission to role
     *
     * @param int|Permission $permission
     * 
     * @return int|bool
     */
    public function attachPermission($permission): int|bool
    {
        return (!$this ->permissions() ->get() ->contains($permission))
                ? $this ->permissions() ->attach($permission) 
                : true;
    }

    /**
     * Detach permission from role
     *
     * @param int|Permission $permission
     * 
     * @return int|bool
     */
    public function detachPermission($permission): int
    {
        return $this ->permissions() ->detach($permission);
    }

    /**
     * Detach all permissions from role
     * 
     * @return int|bool
     */
    public function detachAllPermissions(): int
    {
        return $this ->permissions() ->detach();
    }

    /**
     * Sync permissions for role
     *
     * @param array|Permission[]|\Illuminate\Database\Eloquent\Collection $permissions
     * 
     * @return array
     */
    public function syncPermissions($permissions): array
    {
        return $this ->permissions() ->sync($permissions);
    }
}