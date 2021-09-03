<?php

namespace Mawuekom\Accontrol\Featurables;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        $role_model = config('accontrol.role.model');
        $permission_role_table = config('accontrol.permission_role.table.name');
        $permission_role_table_permission_fk = config('accontrol.permission_role.table.permission_foreign_key');
        $permission_role_table_role_fk = config('accontrol.permission_role.table.role_foreign_key');

        return $this ->belongsToMany($role_model, $permission_role_table, $permission_role_table_permission_fk, $permission_role_table_role_fk) 
                     ->withTimestamps();
    }

    /**
     * Count roles to which permission belongs to.
     *
     * @return int
     */
    public function getRolesCountAttribute(): int
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
        $user_model = config('accontrol.user.model');
        $permission_user_table = config('accontrol.permission_user.table.name');
        $permission_user_table_permission_fk = config('accontrol.permission_user.table.permission_foreign_key');
        $permission_user_table_user_fk = config('accontrol.permission_user.table.user_foreign_key');

        return $this ->belongsToMany($user_model, $permission_user_table, $permission_user_table_permission_fk, $permission_user_table_user_fk) 
                     ->withTimestamps();
    }

    /**
     * Count users to which permission belongs to.
     *
     * @return int
     */
    public function getUsersCountAttribute(): int
    {
        return $this ->users() ->count();
    }

    /**
     * Permission belongs to entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity(): BelongsTo
    {
        $entity_model = config('accontrol.entity.model');
        $permissions_table_entity_fk = config('accontrol.permission.table.entity_foreign_key');
        $entities_table_pk = config('accontrol.entity.table.primary_key');

        return $this ->belongsTo($entity_model, $permissions_table_entity_fk, $entities_table_pk);
    }

    /**
     * Permission belongs to action
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function action(): BelongsTo
    {
        $action_model = config('accontrol.action.model');
        $permissions_table_entity_fk = config('accontrol.permission.table.entity_foreign_key');
        $actions_table_pk = config('accontrol.action.table.primary_key');

        return $this ->belongsTo($action_model, $permissions_table_entity_fk, $actions_table_pk);
    }
}