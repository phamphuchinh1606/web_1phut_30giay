<?php

namespace App\Repositories\Eloquents;

use App\Models\Sale;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SaleRepository extends BaseRepository
{
    public function __construct(Sale $model)
    {
        $this->model = $model;
    }

}
