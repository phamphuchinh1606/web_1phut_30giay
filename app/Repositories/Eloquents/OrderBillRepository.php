<?php

namespace App\Repositories\Eloquents;

use App\Models\OrderBill;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class OrderBillRepository extends BaseRepository
{
    public function __construct(OrderBill $model)
    {
        $this->model = $model;
    }

}
