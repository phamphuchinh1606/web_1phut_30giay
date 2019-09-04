<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\Material;
use App\Models\OrderCancel;
use App\Models\OrderCheckIn;
use App\Models\OrderCheckOut;
use App\Models\StockDaily;
use App\Models\Unit;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class MaterialRepository extends BaseRepository
{
    public function __construct(Material $model)
    {
        $this->model = $model;
    }

    public function selectAll()
    {
        $unitTableName = Unit::getTableName();
        $materialTableName = Material::getTableName();
        return $this->model::join($unitTableName,"$unitTableName.id","$materialTableName.unit_id")
            ->select("$materialTableName.*","$unitTableName.unit_name")->get();
    }

    public function selectShowAll(){
        $unitTableName = Unit::getTableName();
        $materialTableName = Material::getTableName();
        return $this->model::join($unitTableName,"$unitTableName.id","$materialTableName.unit_id")
            ->where("$materialTableName.is_show_input",'1')
            ->select("$materialTableName.*","$unitTableName.unit_name")->get();
    }

    public function getAllByFormInput($branchId, $date = null){
        $unitTableName = Unit::getTableName();
        $materialTableName = Material::getTableName();
        $orderCheckInTableName = OrderCheckIn::getTableName();
        $orderCheckInMoveTableName = OrderCheckIn::getTableName()."Move";
        $orderCheckOutTableName = OrderCheckOut::getTableName();
        $orderCheckOutMoveTableName = OrderCheckOut::getTableName()."Move";
        $orderCancelTableName = OrderCancel::getTableName();
        $stockFirstDailyTableName = StockDaily::getTableName()."First";
        $stockDailyTableName = StockDaily::getTableName();
        return $this->model::join($unitTableName,"$unitTableName.id","$materialTableName.unit_id")
            ->leftjoin($orderCheckInTableName,function ($join) use ($orderCheckInTableName, $materialTableName,$branchId,$date){
                $join->on("$orderCheckInTableName.material_id","$materialTableName.id")
                    ->where("$orderCheckInTableName.branch_id",$branchId)
                    ->where("$orderCheckInTableName.order_check_in_type",OrderCheckIn::CHECK_IN_TYPE);
                if(isset($date)){
                    $join->where("$orderCheckInTableName.check_in_date",$date->format('y-m-d'));
                }
            })
            ->leftjoin("$orderCheckInTableName as $orderCheckInMoveTableName",function ($join) use ($orderCheckInMoveTableName, $materialTableName,$branchId,$date){
                $join->on("$orderCheckInMoveTableName.material_id","$materialTableName.id")
                    ->where("$orderCheckInMoveTableName.branch_id",$branchId)
                    ->where("$orderCheckInMoveTableName.order_check_in_type",OrderCheckIn::MOVE_IN_TYPE);
                if(isset($date)){
                    $join->where("$orderCheckInMoveTableName.check_in_date",$date->format('y-m-d'));
                }
            })
            ->leftjoin($orderCheckOutTableName,function ($join) use ($orderCheckOutTableName, $materialTableName,$branchId,$date){
                $join->on("$orderCheckOutTableName.material_id","$materialTableName.id")
                    ->where("$orderCheckOutTableName.branch_id",$branchId)
                    ->where("$orderCheckOutTableName.order_check_out_type",OrderCheckOut::CHECK_OUT_TYPE);
                if(isset($date)){
                    $join->where('check_out_date',$date->format('y-m-d'));
                }
            })
            ->leftjoin("$orderCheckOutTableName as $orderCheckOutMoveTableName",function ($join) use ($orderCheckOutMoveTableName, $materialTableName,$branchId,$date){
                $join->on("$orderCheckOutMoveTableName.material_id","$materialTableName.id")
                    ->where("$orderCheckOutMoveTableName.branch_id",$branchId)
                    ->where("$orderCheckOutMoveTableName.order_check_out_type",OrderCheckOut::MOVE_OUT_TYPE);
                if(isset($date)){
                    $join->where("$orderCheckOutMoveTableName.check_out_date",$date->format('Y-m-d'));
                }
            })
            ->leftjoin("$stockDailyTableName as $stockFirstDailyTableName",function ($join) use ($stockFirstDailyTableName, $materialTableName,$branchId,$date){
                $join->on("$stockFirstDailyTableName.material_id","$materialTableName.id")
                    ->where("$stockFirstDailyTableName.branch_id",$branchId);
                if(isset($date)){
                    $join->where("$stockFirstDailyTableName.stock_date",DateTimeHelper::addDay($date,-1,'Y-m-d'));
                }
            })
            ->leftjoin($stockDailyTableName,function ($join) use ($stockDailyTableName, $materialTableName,$branchId,$date){
                $join->on("$stockDailyTableName.material_id","$materialTableName.id")
                    ->where("$stockDailyTableName.branch_id",$branchId);
                if(isset($date)){
                    $join->where("$stockDailyTableName.stock_date",$date->format('y-m-d'));
                }
            })
            ->leftjoin($orderCancelTableName,function ($join) use ($orderCancelTableName, $materialTableName,$branchId,$date){
                $join->on("$orderCancelTableName.material_id","$materialTableName.id")
                    ->where("$orderCancelTableName.branch_id",$branchId);
                if(isset($date)){
                    $join->where("$orderCancelTableName.cancel_date",$date->format('y-m-d'));
                }
            })
            ->where("$materialTableName.is_show_input",1)
            ->select("$materialTableName.*","$unitTableName.unit_name",
                \DB::raw("IFNULL($orderCheckInTableName.price,$materialTableName.price) as price"),
                "$orderCheckInTableName.qty as qty_in","$orderCheckInTableName.amount as amount_in","$orderCheckInTableName.price as amount_price","$orderCheckInTableName.check_in_date",
                "$orderCheckInMoveTableName.qty as qty_in_move",
                "$orderCheckOutTableName.qty as qty_out",
                "$orderCheckOutMoveTableName.qty as qty_out_move",
                "$orderCancelTableName.qty as qty_cancel",
                \DB::raw("IFNULL($stockFirstDailyTableName.qty,0) as qty_first"),
                "$stockDailyTableName.qty as qty_last")
            ->get();
    }

}
