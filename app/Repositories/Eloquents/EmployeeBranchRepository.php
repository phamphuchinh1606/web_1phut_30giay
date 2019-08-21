<?php


namespace App\Repositories\Eloquents;

use App\Repositories\Base\BaseRepository;
use App\Models\EmployeeBranch;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class EmployeeBranchRepository extends BaseRepository
{
    public function __construct(EmployeeBranch $model)
    {
        $this->model = $model;
    }
}
