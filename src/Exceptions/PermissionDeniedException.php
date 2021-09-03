<?php

namespace Mawuekom\Accontrol\Exceptions;

use Mawuekom\Accontrol\Exceptions\AccessDeniedException;

class PermissionDeniedException extends AccessDeniedException
{
    /**
     * Create a new permission denied exception instance.
     *
     * @param string $permission
     */
    public function __construct($permission)
    {
        $this->message = sprintf(trans('accontrol::messages.do_not_have_required_permission'), $permission);
    }
}