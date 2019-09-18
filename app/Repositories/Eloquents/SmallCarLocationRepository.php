<?php

namespace App\Repositories\Eloquents;

use App\Models\SmallCarLocation;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SmallCarLocationRepository extends BaseRepository
{
    public function __construct(SmallCarLocation $model)
    {
        $this->model = $model;
    }

}
