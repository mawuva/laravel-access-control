<?php

namespace Accontrol\Contracts\Featurables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany;

    /**
     * Count users to which permission belongs to.
     *
     * @return int
     */
    public function getPermissionsCountAttribute(): int;
}