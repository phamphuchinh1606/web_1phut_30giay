<?php

namespace App\Repositories\Eloquents;

use App\Models\Role;
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

}
