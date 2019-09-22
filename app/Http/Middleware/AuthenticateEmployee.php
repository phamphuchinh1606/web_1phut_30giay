<?php

namespace App\Http\Middleware;

use App\Common\Constant;
use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\BranchRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class AuthenticateEmployee extends Middleware
{

    protected $branchRepository;

    public function __construct(Auth $auth, BranchRepository $branchRepository)
    {
        parent::__construct($auth);
        $this->branchRepository = $branchRepository;
    }

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

    public function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                $branchId = SessionHelper::getSelectedBranchId();
                if(!isset($branchId)){
                    $branch = $this->branchRepository->find(1);
                    SessionHelper::setSelectedBranchId($branch->id);
                    SessionHelper::setSelectedBranchName($branch->branch_name);
                }
                return $this->auth->shouldUse($guard);
            }
        }
        throw new AuthenticationException(
            'Unauthenticated.', $guards, $this->redirectTo($request)
        );
    }
}
