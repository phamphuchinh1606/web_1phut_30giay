<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
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

    public function getList($branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
                ->where('bill_date', '>=' , $firstDate)
                ->where('bill_date', '<=', $lastDate)
                ->orderBy('bill_date')->get();
    }

}
