<?php

namespace App\Repositories\Eloquents;

use App\Models\Material;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class MaterialRepository extends BaseRepository
{
    public function __construct(Material $model)
    {
        $this->model = $model;
    }

}
