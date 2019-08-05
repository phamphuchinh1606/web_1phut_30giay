<?php

namespace App\Repositories\Eloquents;

use App\Models\OrderCheckIn;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class OrderCheckInRepository extends BaseRepository
{
    public function __construct(OrderCheckIn $model)
    {
        $this->model = $model;
    }

}
