<?php

namespace App\Repositories\Eloquents;

use App\Models\PaymentBill;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class PaymentBillRepository extends BaseRepository
{
    public function __construct(PaymentBill $model)
    {
        $this->model = $model;
    }

}
