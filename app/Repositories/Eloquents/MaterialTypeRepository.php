<?php

namespace App\Repositories\Eloquents;

use App\Models\MaterialType;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class MaterialTypeRepository extends BaseRepository
{
    public function __construct(MaterialType $model)
    {
        $this->model = $model;
    }

}
