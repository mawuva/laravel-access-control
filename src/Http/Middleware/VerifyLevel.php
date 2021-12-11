<?php

namespace Mawuekom\Accontrol\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Mawuekom\Accontrol\Exceptions\LevelDeniedException;

class VerifyLevel
{
    /**
     * Handle an incoming request.
     *
     * @param Request  $request
     * @param \Closure $next
     * @param int      $level
     *
     * @throws \Mawuekom\Accontrol\Exceptions\LevelDeniedException
     * @throws \Illuminate\Auth\AuthenticationException
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $level)
    {
        if (auth() || auth('admin')) {
            $user = (auth('admin') ->user() !== null) ? auth('admin') ->user() : auth() ->user();

            if ($user()->level() >= $level) {
                return $next($request);
            }

            throw new LevelDeniedException($level);
        }

        throw new AuthenticationException();
    }
}