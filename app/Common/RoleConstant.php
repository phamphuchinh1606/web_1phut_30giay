<?php

namespace App\Common;

class RoleConstant{
    public const ROLE_TYPE_ADMIN_CODE = 1;
    public const ROLE_TYPE_ADMIN_NAME = "Admin";
    public const ROLE_TYPE_USER_CODE = 2;
    public const ROLE_TYPE_USER_NAME = "User";
    public const ROLE_TYPE_ROOT = 99;

    public const SCREEN_TYPE_ADMIN_CODE = 1;
    public const SCREEN_TYPE_ADMIN_NAME = "Admin";
    public const SCREEN_TYPE_USER_CODE = 1;
    public const SCREEN_TYPE_USER_NAME = "User";

    public const PERMISSION_VIEW_ID = "1";
    public const PERMISSION_INSERT_ID = "2";
    public const PERMISSION_UPDATE_ID = "3";
    public const PERMISSION_DELETE_ID = "4";

    public const ASSIGN_PERMISSION_ALL_ID = "1";
    public const ASSIGN_PERMISSION_BRANCH_ASSIGN_ID = "2";
    public const ASSIGN_PERMISSION_BRANCH_LOGIN_ID = "3";

    public static function screenTypeName($screenTypeId){
        switch ($screenTypeId){
            case self::SCREEN_TYPE_ADMIN_CODE:
                return self::SCREEN_TYPE_ADMIN_NAME;
                break;
            case self::SCREEN_TYPE_USER_CODE:
                return self::SCREEN_TYPE_USER_NAME;
                break;
        }
        return "";
    }

}
