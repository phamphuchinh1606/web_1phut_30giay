<?php

namespace App\Repositories\Eloquents;

use App\Models\PrepareMaterial;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class PrepareMaterialRepository extends BaseRepository
{
    public function __construct(PrepareMaterial $model)
    {
        $this->model = $model;
    }

}
