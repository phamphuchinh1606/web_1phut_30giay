<?php

namespace App\Common;
use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\SessionHelper;
use App\Repositories\Eloquents\RolePermissionScreenRepository;
use App\User;
use Cache;

class PermissionRoleCommon{

    public static function assignPermissionList(){
        $assignList = [
            RoleConstant::ASSIGN_PERMISSION_ALL_ID => 'Tất Cả',
            RoleConstant::ASSIGN_PERMISSION_BRANCH_ASSIGN_ID => 'Chi Nhánh được Assign',
            RoleConstant::ASSIGN_PERMISSION_BRANCH_LOGIN_ID => 'Chỉ User đang login'
        ];
        return $assignList;
    }

    public static function getAssignPermissionName($key){
        $assignList = [
            RoleConstant::ASSIGN_PERMISSION_ALL_ID => 'Tất Cả',
            RoleConstant::ASSIGN_PERMISSION_BRANCH_ASSIGN_ID => 'Chi Nhánh được Assign',
            RoleConstant::ASSIGN_PERMISSION_BRANCH_LOGIN_ID => 'Chỉ User đang login'
        ];
        return $assignList[$key];
    }

    public static function rolePermission(){
        $minutes = 30;
        Cache::flush();
        $rolePermission = Cache::remember("role_permission_screens",$minutes, function(){
            return RolePermissionScreenRepository::getRolePermissionCache();
        });
        return $rolePermission;
    }
    public static function checkViewMenuRoleUser($user, $menu){
        $listRolePermission = self::rolePermission();
        $userRoles = $user->user_roles;
        $mapUserBranch = ArrayHelper::parseListObjectToArrayKey($user->user_branches,'branch_id');
        foreach ($userRoles as $role){
            if(isset($listRolePermission[$role->role_id]) && isset($listRolePermission[$role->role_id][RoleConstant::PERMISSION_VIEW_ID])){
                $canViewScreens = $listRolePermission[$role->role_id][RoleConstant::PERMISSION_VIEW_ID];
                foreach ($canViewScreens as $rolePermission){
                    if($rolePermission->screen_url == $menu->menu_url){
                        switch ($rolePermission->assign_code){
                            case RoleConstant::ASSIGN_PERMISSION_ALL_ID:
                                return true;
                                break;
                            default:
                                return isset($mapUserBranch[SessionHelper::getSelectedBranchId()]);
                                break;
                        }
                        return false;
                    }
                }
            }
        }
        return false;
    }

    public static function checkRoleRoot($user){
        if(!isset($user)) return false;
        if($user instanceof User){
            $roles = $user->user_roles;
        }else{
            $roles = $user->employee_roles;
        }
        if(isset($roles)){
            foreach ($roles as $role){
                if($role->role->role_type_id == RoleConstant::ROLE_TYPE_ROOT) return true;
            }
        }
        return false;
    }

}
