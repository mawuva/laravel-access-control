<?php

namespace Mawuekom\Accontrol\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Mawuekom\Accontrol\Exceptions\PermissionDeniedException;

class VerifyPermission
{
    /**
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request    $request
     * @param \Closure   $next
     * @param int|string $permission
     *
     * @throws \Mawuekom\Accontrol\Exceptions\PermissionDeniedException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if ($this->auth->check() && $this->auth->user()->hasPermission($permission)) {
            return $next($request);
        }

        throw new PermissionDeniedException($permission);
    }
}