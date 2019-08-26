<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\EmployeeRole;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class EmployeeRoleRepository extends BaseRepository
{
    public function __construct(EmployeeRole $model)
    {
        $this->model = $model;
    }

}
