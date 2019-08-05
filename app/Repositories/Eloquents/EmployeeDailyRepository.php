<?php

namespace App\Repositories\Eloquents;

use App\Models\EmployeeDaily;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class EmployeeDailyRepository extends BaseRepository
{
    public function __construct(ServiceApi $model)
    {
        $this->model = $model;
    }

}
