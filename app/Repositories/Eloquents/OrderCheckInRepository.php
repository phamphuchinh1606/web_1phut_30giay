<?php

namespace App\Repositories\Eloquents;

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

}
