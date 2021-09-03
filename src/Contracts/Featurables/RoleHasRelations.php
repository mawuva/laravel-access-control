<?php

namespace Accontrol\Contracts\Featurables;

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
     * @param int|Permission $permission
     * 
     * @return int|bool
     */
    public function attachPermission($permission): int|bool;

    /**
     * Detach permission from role
     *
     * @param int|Permission $permission
     * 
     * @return int|bool
     */
    public function detachPermission($permission): int;

    /**
     * Detach all permissions from role
     * 
     * @return int|bool
     */
    public function detachAllPermissions(): int;

    /**
     * Sync permissions for role
     *
     * @param array|Permission[]|\Illuminate\Database\Eloquent\Collection $permissions
     * 
     * @return array
     */
    public function syncPermissions($permissions): array;
}