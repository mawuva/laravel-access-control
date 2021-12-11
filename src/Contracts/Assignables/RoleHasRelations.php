<?php

namespace Mawuekom\Accontrol\Contracts\Assignables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface RoleHasRelations
{
    /**
     * Role belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany;

    /**
     * Count permissions to which role belongs to.
     *
     * @return int
     */
    public function getPermissionsCountAttribute(): int;

    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany;

    /**
     * Count users to which role belongs to.
     *
     * @return int
     */
    public function getUsersCountAttribute(): int;

    /**
     * Attach permission to role
     *
     * @param int|\Mawuekom\Accontrol\Models\Permission|mixed $permission
     * 
     * @return int|bool
     */
    public function attachPermission($permission);

    /**
     * Detach permission from role
     *
     * @param int|\Mawuekom\Accontrol\Models\Permission|mixed $permission
     * 
     * @return int|bool
     */
    public function detachPermission($permission);

    /**
     * Detach all permissions from role
     * 
     * @return int|bool
     */
    public function detachAllPermissions();

    /**
     * Sync permissions for role
     *
     * @param array|\Mawuekom\Accontrol\Models\Permission[]|\Illuminate\Database\Eloquent\Collection|mixed $permissions
     * 
     * @return array
     */
    public function syncPermissions($permissions);
}