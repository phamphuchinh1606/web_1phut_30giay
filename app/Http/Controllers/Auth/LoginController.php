<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
        $email = $request->email;
        $password = $request->password;
        $remember = false;

        if (Auth::attempt(['email' => $email, 'password' => $password, 'user_type_id' => 1,'delete_is' => 0], $remember)) {
            if(Auth::check()){
                SessionHelper::setSelectedBranchId(1);
                SessionHelper::setSelectedMonth(DateTimeHelper::now());
            }
            return redirect()->route('admin.home');
        }else{
            return redirect()->route('admin.login')->withErrors('Tài khoản hoặc mật khẩu không đúng. Vui lòng nhập lại!');
        }
    }
}
