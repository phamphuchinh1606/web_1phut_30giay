<?php

namespace App\Repositories\Eloquents;

use App\Models\Role;
use App\Models\RoleType;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class RoleRepository extends BaseRepository
{
    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function getRoleUser(){
        return $this->model::where('role_type_id',RoleType::ROLE_TYPE_USER)->get();
    }

    public function getRoleAdmin(){
        return $this->model::where('role_type_id',RoleType::ROLE_TYPE_ADMIN)->get();
    }

}
