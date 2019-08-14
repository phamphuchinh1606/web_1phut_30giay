<?php

namespace App\Repositories\Eloquents;

use App\Models\Supplier;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SupplierRepository extends BaseRepository
{
    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }

}
