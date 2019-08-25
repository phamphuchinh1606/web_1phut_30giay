<?php

namespace App\Common;

class PermissionRoleCommon{
    public const DELETE_FLG_ON = 1;
    public const DELETE_FLG_OFF = 0;

    public static function assignPermissionList(){
        $assignList = [
            '1' => 'Tất Cả',
            '2' => 'Chi Nhánh được Assign',
            '3' => 'Chỉ User đang login'
        ];
        return $assignList;
    }

    public static function getAssignPermissionName($key){
        $assignList = [
            '1' => 'Tất Cả',
            '2' => 'Chi Nhánh được Assign',
            '3' => 'Chỉ User đang login'
        ];
        return $assignList[$key];
    }

}
