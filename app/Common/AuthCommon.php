<?php

namespace App\Common;

use Illuminate\Support\Facades\Auth;

class AuthCommon{
    public const AUTH_GUARD_ADMIN = "web";
    public const AUTH_GUARD_EMPLOYEE = "employee";

    public static function AuthEmployee(){
        return Auth::guard(Constant::AUTH_GUARD_EMPLOYEE);
    }

    public static function AuthAdmin(){
        return Auth::guard(Constant::AUTH_GUARD_ADMIN);
    }

    public static function AuthEmployeeAssignBranches(){
        $user = Auth::guard(Constant::AUTH_GUARD_EMPLOYEE)->user();
        return $user->employee_branches;
    }
}
