<?php

namespace Mawuekom\Accontrol\Exceptions;

use Mawuekom\Accontrol\Exceptions\AccessDeniedException;

class RoleDeniedException extends AccessDeniedException
{
    /**
     * Create a new role denied exception instance.
     *
     * @param string $role
     */
    public function __construct($role)
    {
        $this->message = sprintf(trans('accontrol::entity.messages.do_not_have_required_role'), $role);
    }
}