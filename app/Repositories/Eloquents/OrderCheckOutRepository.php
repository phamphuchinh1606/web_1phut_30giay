<?php

namespace App\Repositories\Eloquents;

use App\Models\OrderCheckOut;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class OrderCheckOutRepository extends BaseRepository
{
    public function __construct(OrderCheckOut $model)
    {
        $this->model = $model;
    }

}
