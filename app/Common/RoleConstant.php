<?php

namespace App\Common;

class RoleConstant{
    public const ROLE_TYPE_ADMIN_CODE = 1;
    public const ROLE_TYPE_ADMIN_NAME = "Admin";
    public const ROLE_TYPE_USER_CODE = 1;
    public const ROLE_TYPE_USER_NAME = "User";

    public const SCREEN_TYPE_ADMIN_CODE = 1;
    public const SCREEN_TYPE_ADMIN_NAME = "Admin";
    public const SCREEN_TYPE_USER_CODE = 1;
    public const SCREEN_TYPE_USER_NAME = "User";

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
