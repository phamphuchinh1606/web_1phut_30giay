<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\OrderCheckIn;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class OrderCheckInRepository extends BaseRepository
{
    public function __construct(OrderCheckIn $model)
    {
        $this->model = $model;
    }

    public function getCheckInToDay($date){
        return $this->model::where('check_in_date',$date->format('Y-d-m'))->get();
    }

    public function getTotalAmountByDate($branchId,$date){
        if(!is_string($date)) $date = $date->format('Y-m-d');
        return $this->model::where('branch_id',$branchId)->where('check_in_date',$date)->sum('amount');
    }

    public function getTotalAmountByMonth($branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('check_in_date','>=', $firstDate)
            ->where('check_in_date','<=', $lastDate)
            ->groupBy('check_in_date')
            ->selectRaw('check_in_date,sum(amount) as total_amount')
            ->get();
    }

}
