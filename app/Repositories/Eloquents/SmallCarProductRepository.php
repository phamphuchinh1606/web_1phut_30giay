<?php

namespace App\Repositories\Eloquents;

use App\Models\SmallCarProduct;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SmallCarProductRepository extends BaseRepository
{
    public function __construct(SmallCarProduct $model)
    {
        $this->model = $model;
    }

}
