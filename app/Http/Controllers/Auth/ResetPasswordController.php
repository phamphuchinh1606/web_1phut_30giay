<?php

namespace App\Http\Controllers\Auth;

use App\Common\AuthCommon;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function change_pass(){
        return view('admin.auth.change_pass');
    }

    public function updatePass(Request $request){
        $rules = array(
            'password_old' => 'required',
            'password' => 'required|string|confirmed',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->route('admin.change_pass')
                ->withErrors($validator)
                ->withInput();
        }

        $user = AuthCommon::AuthAdmin()->user();
        $result = Hash::check($request->password_old, $user->password);
        if($result){
            $user->password = bcrypt($request->password);
            $user->save();
            return view('admin.auth.change_pass',['info' => 'Thay đổi mật khẩu thành công!']);
        }else{
            $validator->errors()->add('password_old', 'Mật khẩu hiện tại không chính xác. Vui lòng nhập lại');
        }
        return redirect()->route('admin.change_pass')
            ->withErrors($validator)
            ->withInput();
    }
}
