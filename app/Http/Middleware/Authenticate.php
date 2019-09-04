<?php

namespace App\Http\Middleware;

use App\Common\Constant;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $guards = array(Constant::AUTH_GUARD_ADMIN);
        $this->authenticate($request, $guards);
        return $next($request);
    }
}
