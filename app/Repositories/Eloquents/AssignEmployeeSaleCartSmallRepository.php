<?php


namespace App\Repositories\Eloquents;

use App\Repositories\Base\BaseRepository;
use App\Models\AssignEmployeeSaleCartSmall;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class AssignEmployeeSaleCartSmallRepository extends BaseRepository
{
    public function __construct(AssignEmployeeSaleCartSmall $model)
    {
        $this->model = $model;
    }
}
