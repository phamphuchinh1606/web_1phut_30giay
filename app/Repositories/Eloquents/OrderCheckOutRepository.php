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

    public function getOrderCheckOutByMaterial($branchIds, $materialIds, $date){
        if(!is_array($branchIds)) $branchIds = [$branchIds];
        if(!is_array($materialIds)) $materialIds = [$materialIds];
        return $this->model::whereIn('branch_id',$branchIds)
            ->whereIn('material_id',$materialIds)
            ->where('check_out_date',$date)
            ->get();
    }

}
