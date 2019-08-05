<?php

namespace App\Repositories\Eloquents;

use App\Models\Unit;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class UnitRepository extends BaseRepository
{
    public function __construct(Unit $model)
    {
        $this->model = $model;
    }

}
