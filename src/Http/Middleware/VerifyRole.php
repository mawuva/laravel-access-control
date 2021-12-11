<?php

namespace Mawuekom\Accontrol\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Guard;
use Mawuekom\Accontrol\Exceptions\RoleDeniedException;

class VerifyRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request    $request
     * @param \Closure   $next
     * @param int|string $role
     *
     * @throws \Mawuekom\Accontrol\Exceptions\RoleDeniedException
     * @throws \Illuminate\Auth\AuthenticationException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (auth() || auth('admin')) {
            $user = (auth('admin') ->user() !== null) ? auth('admin') ->user() : auth() ->user();
            $roles = explode('|', $role);

            for ($i = 0; $i < count($roles); $i++) {
                if ($user()->hasRole($roles[$i])) {
                    return $next($request);
                }
            }

            throw new RoleDeniedException($role);
        }

        throw new AuthenticationException();
    }
}