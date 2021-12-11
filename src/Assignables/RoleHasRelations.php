<?php

namespace Mawuekom\Accontrol\Assignables;

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
        $permissionModel = config('accontrol.permission.model');
        $permissionRoleTable = config('accontrol.permission_role.table.name');
        $permissionRoleTableRoleFK = config('accontrol.permission_role.table.role_foreign_key');
        $permissionRoleTablePermissionFK = config('accontrol.permission_role.table.permission_foreign_key');

        return $this ->belongsToMany($permissionModel, $permissionRoleTable, $permissionRoleTableRoleFK, $permissionRoleTablePermissionFK);
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
        $userModel = config('custom-user.user.model');
        $roleUserTable = config('accontrol.role_user.table.name');
        $roleUserTableRoleFK = config('accontrol.role_user.table.role_foreign_key');
        $roleUserTableUserFK = config('accontrol.role_user.table.user_foreign_key');

        return $this ->belongsToMany($userModel, $roleUserTable, $roleUserTableRoleFK, $roleUserTableUserFK);
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
     * @param int|\Mawuekom\Accontrol\Models\Permission|mixed $permission
     * 
     * @return int|bool
     */
    public function attachPermission($permission)
    {
        return (!$this ->permissions() ->get() ->contains($permission))
                ? $this ->permissions() ->attach($permission) 
                : true;
    }

    /**
     * Detach permission from role
     *
     * @param int|\Mawuekom\Accontrol\Models\Permission|mixed $permission
     * 
     * @return int|bool
     */
    public function detachPermission($permission)
    {
        return $this ->permissions() ->detach($permission);
    }

    /**
     * Detach all permissions from role
     * 
     * @return int|bool
     */
    public function detachAllPermissions()
    {
        return $this ->permissions() ->detach();
    }

    /**
     * Sync permissions for role
     *
     * @param array|\Mawuekom\Accontrol\Models\Permission[]|\Illuminate\Database\Eloquent\Collection|mixed $permissions
     * 
     * @return array
     */
    public function syncPermissions($permissions)
    {
        return $this ->permissions() ->sync($permissions);
    }
}