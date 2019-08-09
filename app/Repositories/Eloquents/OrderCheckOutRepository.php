<?php

namespace App\Repositories\Eloquents;

use App\Models\OrderCheckOut;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class OrderCheckOutRepository extends BaseRepository
{
    public function __construct(OrderCheckOut $model)
    {
        $this->model = $model;
    }

    public function getTotalAmountByDate($branchId,$date){
        if(!is_string($date)) $date = $date->format('Y-m-d');
        return $this->model::where('branch_id',$branchId)->where('check_out_date',$date)->sum('amount');
    }

}
