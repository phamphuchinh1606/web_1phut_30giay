<?php

namespace App\Repositories\Eloquents;

use App\Models\StockDaily;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class StockDailyRepository extends BaseRepository
{
    public function __construct(StockDaily $model)
    {
        $this->model = $model;
    }

}
