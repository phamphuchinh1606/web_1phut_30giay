<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
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

    public function getSaleSmallByMonth($branchId,$date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('sale_date','>=',$firstDate)
            ->where('sale_date','<=',$lastDate)
            ->get();
    }

    public function getSumSaleSmallByMonth($branchId,$date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('sale_date','>=',$firstDate)
            ->where('sale_date','<=',$lastDate)
            ->groupBy('employee_id')
            ->selectRaw('employee_id,sum(qty) as sum_qty, sum(qty_target) as sum_qty_target, sum(bonus_amount) as sum_bonus_amount')
            ->get();
    }

}
