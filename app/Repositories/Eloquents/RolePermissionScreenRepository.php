<?php

namespace App\Repositories\Eloquents;

use App\Models\Role;
use App\Models\RolePermissionScreen;
use App\Models\Screen;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class RolePermissionScreenRepository extends BaseRepository
{

    public function __construct(RolePermissionScreen $model)
    {
        $this->model = $model;
    }

    public function getRolePermissionGroupScreen($roleId){
        $results = $this->getByKey(array('role_id' => $roleId));
        $arrayResult = [];
        foreach ($results as $index => $item){
            if(isset($arrayResult[$item->screen_id])){
                $arrayResult[$item->screen_id]->permission_str.= '<br/>'.$item->permission->permission_name;
            }else{
                $item->permission_str = $item->permission->permission_name;
                $arrayResult[$item->screen_id] = $item;
            }
        }
        return $arrayResult;
    }

    public static function getRolePermissionCache(){
        $tableRoleName = Role::getTableName();
        $tableScreenName = Screen::getTableName();
        $tableRolePermissionName = RolePermissionScreen::getTableName();
        $listData = RolePermissionScreen::join($tableRoleName,"$tableRoleName.id","$tableRolePermissionName.role_id")
            ->join($tableScreenName,"$tableScreenName.screen_id","$tableRolePermissionName.screen_id")
            ->select([
                "$tableRolePermissionName.role_id",
                "$tableRolePermissionName.screen_id",
                "$tableRolePermissionName.permission_id",
                "$tableRolePermissionName.assign_code",
                "$tableScreenName.screen_name",
                "$tableScreenName.screen_url"
            ])->get();
        $rolePermissions = [];
        foreach ($listData as $data){
            if(isset($rolePermissions[$data->role_id])){
                if(isset($rolePermissions[$data->role_id][$data->permission_id])){
                    $rolePermissions[$data->role_id][$data->permission_id][] = $data;
                }else{
                    $rolePermissions[$data->role_id][$data->permission_id] = [$data];
                }
            }else{
                $rolePermissions[$data->role_id][$data->permission_id] = [$data];
            }
        }
        return $rolePermissions;
    }

}
