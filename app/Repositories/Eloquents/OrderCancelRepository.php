<?php

namespace App\Repositories\Eloquents;

use App\Models\OrderCancel;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class OrderCancelRepository extends BaseRepository
{
    public function __construct(OrderCancel $model)
    {
        $this->model = $model;
    }

}
