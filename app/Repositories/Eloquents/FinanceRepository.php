<?php

namespace App\Repositories\Eloquents;

use App\Models\Finance;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class FinanceRepository extends BaseRepository
{
    public function __construct(Finance $model)
    {
        $this->model = $model;
    }

}
