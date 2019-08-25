<?php

namespace App\Repositories\Eloquents;

use App\Models\RolePermissionScreen;
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

}
