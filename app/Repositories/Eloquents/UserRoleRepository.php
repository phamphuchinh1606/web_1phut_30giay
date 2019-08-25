<?php

namespace App\Repositories\Eloquents;

use App\Models\UserRole;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class UserRoleRepository extends BaseRepository
{
    public function __construct(UserRole $model)
    {
        $this->model = $model;
    }

}
