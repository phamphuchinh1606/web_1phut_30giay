<?php

namespace App\Repositories\Eloquents;

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

    public function getAllByFormInput($date = null){
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
            ->leftjoin($orderCheckInTableName,function ($join) use ($orderCheckInTableName, $materialTableName,$date){
                $join->on("$orderCheckInTableName.material_id","$materialTableName.id")
                    ->where("$orderCheckInTableName.order_check_in_type",OrderCheckIn::CHECK_IN_TYPE);
                if(isset($date)){
                    $join->where("$orderCheckInTableName.check_in_date",$date->format('y-m-d'));
                }
            })
            ->leftjoin("$orderCheckInTableName as $orderCheckInMoveTableName",function ($join) use ($orderCheckInMoveTableName, $materialTableName,$date){
                $join->on("$orderCheckInMoveTableName.material_id","$materialTableName.id")
                    ->where("$orderCheckInMoveTableName.order_check_in_type",OrderCheckIn::MOVE_IN_TYPE);
                if(isset($date)){
                    $join->where("$orderCheckInMoveTableName.check_in_date",$date->format('y-m-d'));
                }
            })
            ->leftjoin($orderCheckOutTableName,function ($join) use ($orderCheckOutTableName, $materialTableName,$date){
                $join->on("$orderCheckOutTableName.material_id","$materialTableName.id")
                ->where("$orderCheckOutTableName.order_check_out_type",OrderCheckOut::CHECK_OUT_TYPE);
                if(isset($date)){
                    $join->where('check_out_date',$date->format('y-m-d'));
                }
            })
            ->leftjoin("$orderCheckOutTableName as $orderCheckOutMoveTableName",function ($join) use ($orderCheckOutMoveTableName, $materialTableName,$date){
                $join->on("$orderCheckOutMoveTableName.material_id","$materialTableName.id")
                ->where("$orderCheckOutMoveTableName.order_check_out_type",OrderCheckOut::MOVE_OUT_TYPE);
                if(isset($date)){
                    $join->where("$orderCheckOutMoveTableName.check_out_date",$date->format('y-m-d'));
                }
            })
            ->leftjoin("$stockDailyTableName as $stockFirstDailyTableName",function ($join) use ($stockFirstDailyTableName, $materialTableName,$date){
                $join->on("$stockFirstDailyTableName.material_id","$materialTableName.id");
                if(isset($date)){
                    $join->where("$stockFirstDailyTableName.stock_date",$date->format('y-m-d'));
                }
            })
            ->leftjoin($stockDailyTableName,function ($join) use ($stockDailyTableName, $materialTableName,$date){
                $join->on("$stockDailyTableName.material_id","$materialTableName.id");
                if(isset($date)){
                    $join->where("$stockDailyTableName.stock_date",$date->format('y-m-d'));
                }
            })
            ->leftjoin($orderCancelTableName,function ($join) use ($orderCancelTableName, $materialTableName,$date){
                $join->on("$orderCancelTableName.material_id","$materialTableName.id");
                if(isset($date)){
                    $join->where("$orderCancelTableName.cancel_date",$date->format('y-m-d'));
                }
            })
            ->select("$materialTableName.*","$unitTableName.unit_name",
                "$orderCheckInTableName.qty as qty_in","$orderCheckInTableName.amount as amount_in","$orderCheckInTableName.price as amount_price","$orderCheckInTableName.check_in_date",
                "$orderCheckInMoveTableName.qty as qty_in_move",
                "$orderCheckOutTableName.qty as qty_out",
                "$orderCheckOutMoveTableName.qty as qty_out_move",
                "$orderCancelTableName.qty as qty_cancel",
                "$stockFirstDailyTableName.qty as qty_first",
                "$stockDailyTableName.qty as qty_last")
            ->get();
    }

}
