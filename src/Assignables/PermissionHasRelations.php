<?php

namespace Mawuekom\Accontrol\Assignables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait PermissionHasRelations
{
    /**
     * Permission belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        $roleModel = config('accontrol.role.model');
        $permissionRoleTable = config('accontrol.permission_role.table.name');
        $permissionRoleTablePermissionFK = config('accontrol.permission_role.table.permission_foreign_key');
        $permissionRoleTableRoleFK = config('accontrol.permission_role.table.role_foreign_key');

        return $this ->belongsToMany($roleModel, $permissionRoleTable, $permissionRoleTablePermissionFK, $permissionRoleTableRoleFK);
    }

    /**
     * Count roles to which permission belongs to.
     *
     * @return int
     */
    public function getRolesCountAttribute()
    {
        return $this ->roles() ->count();
    }

    /**
     * Permission belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        $userModel = config('custom-user.user.model');
        $permissionUserTable = config('accontrol.permission_user.table.name');
        $permissionUserTablePermissionFK = config('accontrol.permission_user.table.permission_foreign_key');
        $permissionUserTableUserFK = config('accontrol.permission_user.table.user_foreign_key');

        return $this ->belongsToMany($userModel, $permissionUserTable, $permissionUserTablePermissionFK, $permissionUserTableUserFK);
    }

    /**
     * Count users to which permission belongs to.
     *
     * @return int
     */
    public function getUsersCountAttribute()
    {
        return $this ->users() ->count();
    }
}