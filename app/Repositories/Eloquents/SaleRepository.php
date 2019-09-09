<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
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

    public function sumAmountSale($branchId,$date){
        return $this->model::where('branch_id',$branchId)->where('sale_date',$date)->sum('amount');
    }

    public function sumQtySale($branchId,$date){
        return $this->model::where('branch_id',$branchId)->where('sale_date',$date)->sum('qty');
    }

    public function sumAmountSaleByMonth($branchId,$date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)->where('sale_date','>=',$firstDate)
            ->where('sale_date','<=',$lastDate)
            ->groupBy('sale_date')
            ->selectRaw('sale_date,sum(amount) as sum_amount , sum(qty) as sum_qty')->get();
    }

    public function getSaleByMonth($branchId,$date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
                ->where('sale_date','>=',$firstDate)
                ->where('sale_date','<=',$lastDate)
                ->get();
    }

}
