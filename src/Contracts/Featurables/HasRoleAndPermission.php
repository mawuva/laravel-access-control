<?php

namespace Mawuekom\Accontrol\Contracts\Featurables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface HasRoleAndPermission
{
    /*
    |--------------------------------------------------------------------------
    | HasRole methods
    |--------------------------------------------------------------------------
    */

    /**
     * User belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany;

    /**
     * Get all roles as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles(): Collection;

    /**
     * Check if the user has a role or roles.
     *
     * @param int|string|array $role
     * @param bool             $all
     *
     * @return bool
     */
    public function hasRole($role, $all = false): bool;

    /**
     * Check if the user has at least one of the given roles.
     *
     * @param int|string|array $role
     *
     * @return bool
     */
    public function hasOneRole($role): bool;

    /**
     * Check if the user has all roles.
     *
     * @param int|string|array $role
     *
     * @return bool
     */
    public function hasAllRoles($role): bool;

    /**
     * Check if the user has role.
     *
     * @param int|string $role
     *
     * @return bool
     */
    public function checkRole($role): bool;

    /**
     * Attach role to a user.
     *
     * @param int|Role $role
     *
     * @return null|bool
     */
    public function attachRole($role): null|bool;

    /**
     * Detach role from a user.
     *
     * @param int|Role $role
     *
     * @return int
     */
    public function detachRole($role): int;

    /**
     * Detach all roles from a user.
     *
     * @return int
     */
    public function detachAllRoles(): int;

    /**
     * Sync roles for a user.
     *
     * @param array|Role[]|Collection $roles
     *
     * @return array
     */
    public function syncRoles($roles): int;

    /**
     * Get role level of a user.
     *
     * @return int
     */
    public function level();

    /**
     * Get all permissions from roles.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function rolePermissions(): Builder;

    /*
    |--------------------------------------------------------------------------
    | HasPermission methods
    |--------------------------------------------------------------------------
    */

    /**
     * User belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userPermissions(): BelongsToMany;

    /**
     * Get all roles as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions(): Collection;

    /**
     * Check if the user has a permission or permissions.
     *
     * @param int|string|array $permission
     * @param bool             $all
     *
     * @return bool
     */
    public function hasPermission($permission, $all = false): bool;

    /**
     * Check if the user has at least one of the given permissions.
     *
     * @param int|string|array $permission
     *
     * @return bool
     */
    public function hasOnePermission($permission): bool;

    /**
     * Check if the user has all permissions.
     *
     * @param int|string|array $permission
     *
     * @return bool
     */
    public function hasAllPermissions($permission): bool;

    /**
     * Check if the user has a permission.
     *
     * @param int|string $permission
     *
     * @return bool
     */
    public function checkPermission($permission): bool;

    /**
     * Attach permission to a user.
     *
     * @param int|Permission $permission
     *
     * @return null|bool
     */
    public function attachPermission($permission);

    /**
     * Detach permission from a user.
     *
     * @param int|Permission $permission
     *
     * @return int
     */
    public function detachPermission($permission);

    /**
     * Detach all permissions from a user.
     *
     * @return int
     */
    public function detachAllPermissions();

    /**
     * Sync permissions for a user.
     *
     * @param array|Permission[]|Collection $permissions
     *
     * @return array
     */
    public function syncPermissions($permissions);

    /*
    |--------------------------------------------------------------------------
    | Others methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the user is allowed to manipulate with entity.
     */
    public function allowed();
}