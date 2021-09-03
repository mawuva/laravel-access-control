<?php

namespace Mawuekom\Accontrol\Contracts\Featurables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface PermissionHasRelations
{
    /**
     * Permission belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany;

    /**
     * Count roles to which permission belongs to.
     *
     * @return int
     */
    public function getRolesCountAttribute(): int;

    /**
     * Permission belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany;

    /**
     * Count users to which permission belongs to.
     *
     * @return int
     */
    public function getUsersCountAttribute(): int;
}