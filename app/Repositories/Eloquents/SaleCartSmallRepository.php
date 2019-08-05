<?php

namespace App\Repositories\Eloquents;

use App\Models\SaleCardSmall;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SaleCartSmallRepository extends BaseRepository
{
    public function __construct(SaleCardSmall $model)
    {
        $this->model = $model;
    }

}
