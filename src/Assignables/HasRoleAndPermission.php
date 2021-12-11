<?php

namespace Mawuekom\Accontrol\Assignables;

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
        $roleModel = config('accontrol.role.model');
        $roleUserTable = config('accontrol.role_user.table.name');
        $roleUserTableUserFK = config('accontrol.role_user.table.user_foreign_key');
        $roleUserTableRoleFK = config('accontrol.role_user.table.role_foreign_key');

        return $this ->belongsToMany($roleModel, $roleUserTable, $roleUserTableUserFK, $roleUserTableRoleFK);
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
     * @param int|\Mawuekom\Accontrol\Models\Role|mixed $role
     *
     * @return null|bool
     */
    public function attachRole($role)
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
     * @param int|\Mawuekom\Accontrol\Models\Role|mixed $role
     *
     * @return int
     */
    public function detachRole($role)
    {
        $this->roles = null;

        return $this->roles()->detach($role);
    }

    /**
     * Detach all roles from a user.
     *
     * @return int
     */
    public function detachAllRoles()
    {
        $this->roles = null;

        return $this->roles()->detach();
    }

    /**
     * Sync roles for a user.
     *
     * @param array|\Mawuekom\Accontrol\Models\Permission[]|\Illuminate\Database\Eloquent\Collection|mixed $roles
     *
     * @return array
     */
    public function syncRoles($roles)
    {
        $this->roles = null;

        return $this->roles()->sync($roles);
    }

    /**
     * Get role level of a user.
     *
     * @return int
     */
    public function level()
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
        $roleInheritance                        = config('accontrol.role_inheritance');

        $permissionModel                        = app(config('accontrol.permission.model'));
        $permissionsTable                       = config('accontrol.permission.table.name');
        $permissionsTablePK                     = config('accontrol.permission.table.primary_key');

        $permissionRoleTable                    = config('accontrol.permission_role.table.name');
        $permissionRoleTablePermissionFK        = config('accontrol.permission_role.table.permission_foreign_key');
        $permissionRoleTableRoleFK              = config('accontrol.permission_role.table.role_foreign_key');

        $rolesTable                             = config('accontrol.role.table.name');
        $rolesTablePK                           = config('accontrol.role.table.primary_key');

        if (!$permissionModel instanceof Model) {
            throw new InvalidArgumentException('[roles.models.permission] must be an instance of \Illuminate\Database\Eloquent\Model');
        }

        if ($roleInheritance) {
            return $permissionModel
                    ::select([$permissionsTable.'.*', $permissionRoleTable.'.created_at as pivot_created_at', $permissionRoleTable.'.updated_at as pivot_updated_at'])
                    ->join($permissionRoleTable, $permissionRoleTable.'.'.$permissionRoleTablePermissionFK, '=', $permissionsTable.'.'.$permissionsTablePK)
                    ->join($rolesTable, $rolesTable.'.'.$rolesTablePK, '=', $permissionRoleTable.'.'.$permissionRoleTableRoleFK)
                    ->whereIn($rolesTable.'.'.$rolesTablePK, $this->getRoles()->pluck($rolesTablePK)->toArray())
                    ->orWhere($rolesTable.'.level', '<', $this->level())
                    ->groupBy([$permissionsTable.'.'.$permissionsTablePK, $permissionsTable.'.name', $permissionsTable.'.slug', $permissionsTable.'.description', /*$permissionsTable.'.model',*/ $permissionsTable.'.created_at', $permissionsTable.'.updated_at', $permissionsTable.'.deleted_at', 'pivot_created_at', 'pivot_updated_at']);
        }

        else {
            return $permissionModel
                    ::select([$permissionsTable.'.*', $permissionRoleTable.'.created_at as pivot_created_at', $permissionRoleTable.'.updated_at as pivot_updated_at'])
                    ->join($permissionRoleTable, $permissionRoleTable.'.'.$permissionRoleTablePermissionFK, '=', $permissionsTable.'.'.$permissionsTablePK)
                    ->join($rolesTable, $rolesTable.'.'.$rolesTablePK, '=', $permissionRoleTable.'.'.$permissionRoleTableRoleFK)
                    ->whereIn($rolesTable.'.'.$rolesTablePK, $this->getRoles()->pluck($rolesTablePK)->toArray())
                    ->groupBy([$permissionsTable.'.'.$permissionsTablePK, $permissionsTable.'.name', $permissionsTable.'.slug', $permissionsTable.'.description', /*$permissionsTable.'.model',*/ $permissionsTable.'.created_at', $permissionsTable.'.updated_at', $permissionsTable.'.deleted_at', 'pivot_created_at', 'pivot_updated_at']);
        }
    }

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
    public function userPermissions(): BelongsToMany
    {
        $permissionModel = config('accontrol.permission.model');
        $permissionUserTable = config('accontrol.permission_user.table.name');
        $permissionUserTableUserFK = config('accontrol.permission_user.table.user_foreign_key');
        $permissionUserTablePermissionFK = config('accontrol.permission_user.table.permission_foreign_key');

        return $this ->belongsToMany($permissionModel, $permissionUserTable, $permissionUserTableUserFK, $permissionUserTablePermissionFK);
    }

    /**
     * Get all roles as collection.
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
     * @param int|\Mawuekom\Accontrol\Models\Permission|mixed $permission
     *
     * @return null|bool
     */
    public function attachPermission($permission)
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
     * @param int|\Mawuekom\Accontrol\Models\Permission|mixed $permission
     *
     * @return int
     */
    public function detachPermission($permission)
    {
        $this->permissions = null;

        return $this->userPermissions()->detach($permission);
    }

    /**
     * Detach all permissions from a user.
     *
     * @return int
     */
    public function detachAllPermissions()
    {
        $this->permissions = null;

        return $this->userPermissions()->detach();
    }

    /**
     * Sync permissions for a user.
     *
     * @param array|\Mawuekom\Accontrol\Models\Permission[]|\Illuminate\Database\Eloquent\Collection|mixed $permissions
     *
     * @return array
     */
    public function syncPermissions($permissions)
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
     *
     * @param string $providedPermission
     * @param \Illuminate\Database\Eloquent\Model  $entity
     * @param bool   $owner
     * @param string $ownerColumn
     *
     * @return bool
     */
    public function allowed($providedPermission, Model $entity, $owner = true, $ownerColumn = 'user_id')
    {
        if ($this->isPretendEnabled()) {
            return $this->pretend('allowed');
        }

        if ($owner === true && $entity->{$ownerColumn} == $this->id) {
            return true;
        }

        return $this->isAllowed($providedPermission, $entity);
    }

    /**
     * Check if the user is allowed to manipulate with provided entity.
     *
     * @param string $providedPermission
     * @param \Illuminate\Database\Eloquent\Model  $entity
     *
     * @return bool
     */
    protected function isAllowed($providedPermission, Model $entity)
    {
        foreach ($this->getPermissions() as $permission) {
            if ($permission->model != '' && get_class($entity) == $permission->model
                && ($permission->id == $providedPermission || $permission->slug === $providedPermission)
            ) {
                return true;
            }
        }

        return false;
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

    /*public function callMagic($method, $parameters)
    {
        if (starts_with($method, 'is')) {
            return $this->hasRole(snake_case(substr($method, 2), config('roles.separator')));
        } elseif (starts_with($method, 'can')) {
            return $this->hasPermission(snake_case(substr($method, 3), config('roles.separator')));
        } elseif (starts_with($method, 'allowed')) {
            return $this->allowed(snake_case(substr($method, 7), config('roles.separator')), $parameters[0], (isset($parameters[1])) ? $parameters[1] : true, (isset($parameters[2])) ? $parameters[2] : 'user_id');
        }

        return parent::__call($method, $parameters);
    }

    public function __call($method, $parameters)
    {
        return $this->callMagic($method, $parameters);
    }*/
}