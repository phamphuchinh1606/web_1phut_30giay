<?php

namespace App\Repositories\Eloquents;

use App\Models\SettingApp;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SettingRepository extends BaseRepository
{
    public function __construct(SettingApp $model)
    {
        $this->model = $model;
    }

}
