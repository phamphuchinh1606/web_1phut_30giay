<?php

namespace App\Repositories\Eloquents;

use App\Common\Constant;
use App\Common\RoleConstant;
use App\Models\UserRole;
use App\User;
use App\Repositories\Base\BaseRepository;
use function foo\func;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function selectAll()
    {
        return $this->model::where('delete_flg', Constant::DELETE_FLG_OFF)->orderBy('id')->get();
    }

    public function selectListUser($differentRoleId = RoleConstant::ROLE_TYPE_ADMIN_CODE){
        $query = $this->model::where('delete_flg', Constant::DELETE_FLG_OFF);
        if(isset($differentRoleId)){
            $query->whereIn('id',function ($query) use ($differentRoleId){
                $query->select('user_id')
                    ->from(UserRole::getTableName())
                    ->where('role_id','<>',$differentRoleId);
            });
        }
        return $query->orderBy('id')->get();
    }

}
