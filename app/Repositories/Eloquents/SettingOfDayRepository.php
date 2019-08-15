<?php

namespace App\Repositories\Eloquents;

use App\Models\SettingOfDay;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SettingOfDayRepository extends BaseRepository
{
    public function __construct(SettingOfDay $model)
    {
        $this->model = $model;
    }

}
