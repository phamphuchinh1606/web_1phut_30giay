<?php

namespace App\Http\Middleware;

use App\Common\Constant;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class AuthenticateEmployee extends Middleware
{
    /** redirectTo
     * @param $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = array(Constant::AUTH_GUARD_EMPLOYEE);
        $this->authenticate($request, $guards);
        return $next($request);
    }
}
