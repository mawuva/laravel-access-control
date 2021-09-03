<?php

namespace Mawuekom\Accontrol\Contracts\Featurables;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface ActionHasRelations
{
    /**
     * Action belongs to many entities.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function entities(): BelongsToMany;

    /**
     * Count roles to which permission belongs to.
     *
     * @return int
     */
    public function getEntitiesCountAttribute(): int;

    /**
     * Action belongs to many permissions.
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