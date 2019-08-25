<?php

namespace App\Repositories\Eloquents;

use App\Models\Permission;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class PermissionRepository extends BaseRepository
{
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

}
