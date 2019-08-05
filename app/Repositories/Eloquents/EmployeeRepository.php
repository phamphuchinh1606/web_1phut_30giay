<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Base\BaseRepository;
use App\Models\Employee;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class EmployeeRepository extends BaseRepository
{
    public function __construct(Employee $model)
    {
        $this->model = $model;
    }
}
