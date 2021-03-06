<?php

namespace App\Http\Controllers\Auth;

use App\Common\Constant;
use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Http\Controllers\Controller;
use App\Repositories\Eloquents\BranchRepository;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class LoginEmployeeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    protected $branchRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BranchRepository $branchRepository)
    {
//        $this->middleware('guest')->except('logout');
        $this->branchRepository = $branchRepository;
    }

    public function showLoginForm()
    {
        return view('admin.auth.login_employee');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $email = $request->email;
        $password = $request->password;
        $remember = true;
        if ($this->guard()->attempt(['employee_login_id' => $email, 'password' => $password, 'delete_flg' => 0], $remember)) {
            if($this->guard()->check()){
                $employee = $this->guard()->user();
                $branchId = $employee->default_branch_id;
                if(!isset($branchId) && isset($employee->employee_branches) && count($employee->employee_branches) > 0){
                    $branchId = $employee->employee_branches[0]->branch_id;
                }
                $branch = $this->branchRepository->find($branchId);
                if(isset($branch)){
                    SessionHelper::setSelectedBranchId($branch->id);
                    SessionHelper::setSelectedBranchName($branch->branch_name);
                }
                SessionHelper::setSelectedMonth(DateTimeHelper::now());
            }
            return redirect()->route('home');
        }else{
            return redirect()->route('login')->withErrors('Tài khoản hoặc mật khẩu không đúng. Vui lòng nhập lại!');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard(Constant::AUTH_GUARD_EMPLOYEE);
    }
}
