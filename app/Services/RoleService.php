<?php
namespace App\Services;

use App\Common\Constant;
use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use Illuminate\Support\Facades\DB;

class RoleService extends BaseService {

    public function getScreenAll(){
        $listScreen = $this->screenRepository->selectAll();
        $screens = [];
        foreach ($listScreen as $screen){
            $screens[$screen->screen_type][] = $screen;
        }
        return $screens;
    }

    public function update($values){
        $roleId = $values['id'];
        $screenId = $values['screen_id'];

        $assignPermission = $values['assign_permission'];
        $role = $this->roleRepository->find($roleId);
        if(isset($role)){
            try{
                $permissions = $this->rolePermissionScreenRepository->getByKey(array('role_id' => $roleId, 'screen_id' => $screenId));
                foreach ($permissions as $permission){
                    $this->rolePermissionScreenRepository->deleteLogic([
                        'role_id' => $permission->role_id,
                        'screen_id' => $permission->screen_id,
                        'permission_id' => $permission->permission_id,
                    ]);
                }
                $permissions = $values['permission'];
                if(isset($permissions)){
                    foreach ($permissions as $permissionId){
                        $this->rolePermissionScreenRepository->create([
                            'role_id' => $roleId,
                            'screen_id' => $screenId,
                            'permission_id' => $permissionId,
                            'assign_code' => $assignPermission
                        ]);
                    }
                }
            }catch (\Exception $ex){
                dd($ex);
            }

        }

    }

}
