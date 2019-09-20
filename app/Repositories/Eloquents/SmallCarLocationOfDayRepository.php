<?php

namespace App\Repositories\Eloquents;

use App\Models\SmallCarLocationOfDay;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SmallCarLocationOfDayRepository extends BaseRepository
{
    public function __construct(SmallCarLocationOfDay $model)
    {
        $this->model = $model;
    }
}
