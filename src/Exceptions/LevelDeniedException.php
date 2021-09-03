<?php

namespace Mawuekom\Accontrol\Exceptions;

use Mawuekom\Accontrol\Exceptions\AccessDeniedException;

class LevelDeniedException extends AccessDeniedException
{
    /**
     * Create a new level denied exception instance.
     *
     * @param string $level
     */
    public function __construct($level)
    {
        $this->message = sprintf(trans('accontrol::messages.do_not_have_required_level'), $level);
    }
}