<?php

namespace App\Repositories\Eloquents;

use App\Models\Role;
use App\Models\RolePermissionScreen;
use App\Models\Screen;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class ScreenRepository extends BaseRepository
{
    public function __construct(Screen $model)
    {
        $this->model = $model;
    }

    public function selectAll()
    {
        return $this->model::orderBy('screen_type')->orderBy('screen_id')->get();
    }

    public function getScreenByRole($roleId = null){
        $query = $this->model::whereRaw("1=1");
        if(isset($roleId)){
            $tableRolePermissionScreenName = RolePermissionScreen::getTableName();
            $query->whereNotIn('screen_id',function($query) use ($tableRolePermissionScreenName, $roleId){
                $query->select('screen_id')
                    ->from($tableRolePermissionScreenName)
                    ->where('role_id', $roleId);
            });
        }
        return $query->orderBy('screen_type')->orderBy('screen_id')->get();
    }

    public function getScreenParentIsNull(){
        return $this->model::whereNotNull('screen_parent_id')->orderBy('screen_type')->get();
    }

    public function getScreenAdmin(){
        return $this->model::where('screen_type', Screen::SCREEN_TYPE_ADMIN)->get();
    }

    public function getScreenEmployee(){
        return $this->model::where('screen_type', Screen::SCREEN_TYPE_EMPLOYEE)->get();
    }
}
