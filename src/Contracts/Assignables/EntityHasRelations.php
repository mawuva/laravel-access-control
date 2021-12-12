<?php

namespace Mawuekom\Accontrol\Contracts\Assignables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface EntityHasRelations
{
    /**
     * Entity belongs to many actions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function actions(): BelongsToMany;

    /**
     * Count roles to which permission belongs to.
     *
     * @return int
     */
    public function getActionsCountAttribute(): int;

    /**
     * Entity belongs to many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions(): HasMany;

    /**
     * Count users to which permission belongs to.
     *
     * @return int
     */
    public function getPermissionsCountAttribute(): int;
}