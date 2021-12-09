<?php

namespace Mawuekom\Accontrol\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Mawuekom\Accontrol\Exceptions\PermissionDeniedException;

class VerifyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request    $request
     * @param \Closure   $next
     * @param int|string $permission
     *
     * @throws \Mawuekom\Accontrol\Exceptions\PermissionDeniedException
     * @throws \Illuminate\Auth\AuthenticationException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        if (auth() || auth('admin')) {
            $user = (auth('admin') ->user() !== null) ? auth('admin') ->user() : auth() ->user();

            if ($user() ->hasPermission($permission)) {
                return $next($request);
            }

            throw new PermissionDeniedException($permission);
        }

        throw new AuthenticationException();
    }
}