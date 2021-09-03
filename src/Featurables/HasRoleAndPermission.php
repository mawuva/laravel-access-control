<?php

namespace Mawuekom\Accontrol\Featurables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use InvalidArgumentException;

trait HasRoleAndPermission
{
    /**
     * Property for caching roles.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $roles;

    /**
     * Property for caching permissions.
     *
     * @var \Illuminate\Database\Eloquent\Collection|null
     */
    protected $permissions;

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
    public function roles(): BelongsToMany
    {
        $role_model = config('accontrol.role.model');
        $role_user_table = config('accontrol.role_user.table.name');
        $role_user_table_user_fk = config('accontrol.role_user.table.user_foreign_key');
        $role_user_table_role_fk = config('accontrol.role_user.table.role_foreign_key');

        return $this ->belongsToMany($role_model, $role_user_table, $role_user_table_user_fk, $role_user_table_role_fk) 
                     ->withTimestamps();
    }

    /**
     * Get all roles as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles(): Collection
    {
        return (!$this ->roles) 
                ? $this ->roles = $this ->roles() ->get() 
                : $this ->roles;
    }

    /**
     * Check if the user has a role or roles.
     *
     * @param int|string|array $role
     * @param bool             $all
     *
     * @return bool
     */
    public function hasRole($role, $all = false): bool
    {
        return (!$all)
                ? $this->hasOneRole($role)
                : $this->hasAllRoles($role);
    }

    /**
     * Check if the user has at least one of the given roles.
     *
     * @param int|string|array $role
     *
     * @return bool
     */
    public function hasOneRole($role): bool
    {
        foreach ($this->getArrayFrom($role) as $role) {
            if ($this->checkRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all roles.
     *
     * @param int|string|array $role
     *
     * @return bool
     */
    public function hasAllRoles($role): bool
    {
        foreach ($this ->getArrayFrom($role) as $role) {
            if (!$this->checkRole($role)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user has role.
     *
     * @param int|string $role
     *
     * @return bool
     */
    public function checkRole($role): bool
    {
        return $this ->getRoles() ->contains(function ($value) use ($role) {
            return $role == $value->id || Str::is($role, $value->slug);
        });
    }

    /**
     * Attach role to a user.
     *
     * @param int|Role $role
     *
     * @return null|bool
     */
    public function attachRole($role): null|bool
    {
        if ($this->getRoles()->contains($role)) {
            return true;
        }

        $this->roles = null;

        return $this->roles()->attach($role);
    }

    /**
     * Detach role from a user.
     *
     * @param int|Role $role
     *
     * @return int
     */
    public function detachRole($role): int
    {
        $this->roles = null;

        return $this->roles()->detach($role);
    }

    /**
     * Detach all roles from a user.
     *
     * @return int
     */
    public function detachAllRoles(): int
    {
        $this->roles = null;

        return $this->roles()->detach();
    }

    /**
     * Sync roles for a user.
     *
     * @param array|Role[]|Collection $roles
     *
     * @return array
     */
    public function syncRoles($roles): array
    {
        $this->roles = null;

        return $this->roles()->sync($roles);
    }

    /**
     * Get role level of a user.
     *
     * @return int
     */
    public function level(): int
    {
        return ($role = $this->getRoles()->sortByDesc('level')->first()) 
                ? $role->level 
                : 0;
    }

    /**
     * Get all permissions from roles.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function rolePermissions(): Builder
    {
        $role_inheritance                       = config('accontrol.role_inheritance');

        $permission_model                       = app(config('accontrol.permission.model'));
        $permissions_table                      = config('accontrol.permission.table.name');
        $permissions_table_pk                   = config('accontrol.permission.table.primary_key');

        $permission_role_table                  = config('accontrol.permission_role.table.name');
        $permission_role_table_permission_fk    = config('accontrol.permission_role.table.permission_foreign_key');
        $permission_role_table_role_fk          = config('accontrol.permission_role.table.role_foreign_key');

        $roles_table                            = config('accontrol.role.table.name');
        $roles_table_pk                         = config('accontrol.role.table.primary_key');

        if (!$permission_model instanceof Model) {
            throw new InvalidArgumentException('[roles.models.permission] must be an instance of \Illuminate\Database\Eloquent\Model');
        }

        if ($role_inheritance) {
            return $permission_model
                    ::select([$permissions_table.'.*', $permission_role_table.'.created_at as pivot_created_at', $permission_role_table.'.updated_at as pivot_updated_at'])
                    ->join($permission_role_table, $permission_role_table.'.'.$permission_role_table_permission_fk, '=', $$permissions_table.'.'.$$permissions_table_pk)
                    ->join($roles_table, $roles_table.'.'.$roles_table_pk, '=', $permission_role_table.'.'.$permission_role_table_role_fk)
                    ->whereIn($roles_table.'.'.$roles_table_pk, $this->getRoles()->pluck($roles_table_pk)->toArray())
                    ->orWhere($roles_table.'.level', '<', $this->level())
                    ->groupBy([$permissions_table.'.'.$permissions_table_pk, $permissions_table.'.name', $permissions_table.'.slug', $permissions_table.'.description', $permissions_table.'.model', $permissions_table.'.created_at', $permissions_table.'.updated_at', $permissions_table.'.deleted_at', 'pivot_created_at', 'pivot_updated_at']);
        }

        else {
            return $permission_model
                    ::select([$permissions_table.'.*', $permission_role_table.'.created_at as pivot_created_at', $permission_role_table.'.updated_at as pivot_updated_at'])
                    ->join($permission_role_table, $permission_role_table.'.'.$permission_role_table_permission_fk, '=', $$permissions_table.'.'.$$permissions_table_pk)
                    ->join($roles_table, $roles_table.'.'.$roles_table_pk, '=', $permission_role_table.'.'.$permission_role_table_role_fk)
                    ->whereIn($roles_table.'.'.$roles_table_pk, $this->getRoles()->pluck($roles_table_pk)->toArray())
                    ->groupBy([$permissions_table.'.'.$permissions_table_pk, $permissions_table.'.name', $permissions_table.'.slug', $permissions_table.'.description', $permissions_table.'.model', $permissions_table.'.created_at', $permissions_table.'.updated_at', $permissions_table.'.deleted_at', 'pivot_created_at', 'pivot_updated_at']);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | HasPermission methods
    |--------------------------------------------------------------------------
    */

    /**
     * User belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userPermissions(): BelongsToMany
    {
        $permission_model = config('accontrol.permission.model');
        $permission_user_table = config('accontrol.permission_user.table.name');
        $permission_user_table_user_fk = config('accontrol.permission_user.table.user_foreign_key');
        $permission_user_table_permission_fk = config('accontrol.permission_user.table.permission_foreign_key');

        return $this ->belongsToMany($permission_model, $permission_user_table, $permission_user_table_user_fk, $permission_user_table_permission_fk) 
                     ->withTimestamps();
    }

    /**
     * Get all permission as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPermissions(): Collection
    {
        return (!$this ->permissions) 
                ? $this ->permissions = $this ->rolePermissions() ->get() ->merge($this ->userPermissions() ->get()) 
                : $this ->permissions;
    }

    /**
     * Check if the user has a permission or permissions.
     *
     * @param int|string|array $permission
     * @param bool             $all
     *
     * @return bool
     */
    public function hasPermission($permission, $all = false): bool
    {
        return (!$all) 
                ? $this->hasOnePermission($permission)
                : $this->hasAllPermissions($permission);
    }

    /**
     * Check if the user has at least one of the given permissions.
     *
     * @param int|string|array $permission
     *
     * @return bool
     */
    public function hasOnePermission($permission): bool
    {
        foreach ($this->getArrayFrom($permission) as $permission) {
            if ($this->checkPermission($permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the user has all permissions.
     *
     * @param int|string|array $permission
     *
     * @return bool
     */
    public function hasAllPermissions($permission): bool
    {
        foreach ($this->getArrayFrom($permission) as $permission) {
            if (!$this->checkPermission($permission)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if the user has a permission.
     *
     * @param int|string $permission
     *
     * @return bool
     */
    public function checkPermission($permission): bool
    {
        return $this->getPermissions()->contains(function ($value) use ($permission) {
            return $permission == $value->id || Str::is($permission, $value->slug);
        });
    }

    /**
     * Attach permission to a user.
     *
     * @param int|Permission $permission
     *
     * @return null|bool
     */
    public function attachPermission($permission): null|bool
    {
        if ($this->getPermissions()->contains($permission)) {
            return true;
        }

        $this->permissions = null;

        return $this->userPermissions()->attach($permission);
    }

    /**
     * Detach permission from a user.
     *
     * @param int|Permission $permission
     *
     * @return int
     */
    public function detachPermission($permission): int
    {
        $this->permissions = null;

        return $this->userPermissions()->detach($permission);
    }

    /**
     * Detach all permissions from a user.
     *
     * @return int
     */
    public function detachAllPermissions(): int
    {
        $this->permissions = null;

        return $this->userPermissions()->detach();
    }

    /**
     * Sync permissions for a user.
     *
     * @param array|Permission[]|Collection $permissions
     *
     * @return array
     */
    public function syncPermissions($permissions): array
    {
        $this->permissions = null;

        return $this->userPermissions()->sync($permissions);
    }

    /*
    |--------------------------------------------------------------------------
    | Others methods
    |--------------------------------------------------------------------------
    */

    /**
     * Check if the user is allowed to manipulate with entity.
     */
    public function allowed()
    {

    }

    /**
     * Get an array from argument.
     *
     * @param int|string|array $argument
     *
     * @return array
     */
    private function getArrayFrom($argument)
    {
        return (!is_array($argument)) 
                ? preg_split('/ ?[,|] ?/', $argument) 
                : $argument;
    }
}