<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\Material;
use App\Models\OrderCheckIn;
use App\Models\Supplier;
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

    public function listCheckInByType($listType, $branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('check_in_date','>=', $firstDate)
            ->where('check_in_date','<=', $lastDate)
            ->whereIn('order_check_in_type',$listType)
            ->get();
    }

    public function getCheckInToDay($date){
        return $this->model::where('check_in_date',$date->format('Y-d-m'))->get();
    }

    public function getTotalAmountByDate($branchId,$date, $orderCheckInType = null){
        if(!is_string($date)) $date = $date->format('Y-m-d');
        $query = $this->model::where('branch_id',$branchId)->where('check_in_date',$date);
        if(isset($orderCheckInType)){
            $query->where('order_check_in_type',$orderCheckInType);
        }
        return $query->sum('amount');
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

    public function amountByMonth($branchId, $date, $orderCheckInType = null, $supplierId = null){
        if(!is_array($orderCheckInType)) $orderCheckInType = [$orderCheckInType];
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        $query = $this->model::where('branch_id',$branchId)->where('check_in_date','>=', $firstDate)
            ->where('check_in_date','<=', $lastDate);
        if(isset($orderCheckInType)){
            $query->whereIn('order_check_in_type',$orderCheckInType);
        }
        if(isset($supplierId)){
            $query->where(function ($query) use ($supplierId){
                $query->whereIn('material_id',function ($query) use ($supplierId){
                    $query->select('id')
                        ->from(Material::getTableName())
                        ->where('supplier_id',$supplierId);
                });
                $query->orWhereNull('material_id');
            });

        }
        return $query->sum('amount');
    }

    public function getCheckInByMonth($branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');

        $tableCheckInName = OrderCheckIn::getTableName();
        $tableMaterialName = Material::getTableName();
        $tableSupplierName = Supplier::getTableName();
        return $this->model::join($tableMaterialName,"$tableCheckInName.material_id","$tableMaterialName.id")
            ->join($tableSupplierName,"$tableMaterialName.supplier_id","$tableSupplierName.id")
            ->where("$tableCheckInName.branch_id",$branchId)
            ->where('check_in_date','>=', $firstDate)
            ->where('check_in_date','<=', $lastDate)
            ->where('order_check_in_type', OrderCheckIn::CHECK_IN_TYPE)
            ->groupBy("$tableMaterialName.supplier_id","check_in_date")
            ->selectRaw("$tableMaterialName.supplier_id,check_in_date,sum(amount) as total_amount, sum(qty) as total_qty")
            ->get();
    }

    public function getCheckInAddByMonth($branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');

        $tableCheckInName = OrderCheckIn::getTableName();
        return $this->model::where("$tableCheckInName.branch_id",$branchId)
            ->where('check_in_date','>=', $firstDate)
            ->where('check_in_date','<=', $lastDate)
            ->whereNull('material_id')
            ->whereIn('order_check_in_type', OrderCheckIn::arrayTypeCheckInCharge())
            ->groupBy("check_in_date")
            ->selectRaw("null as supplier_id,check_in_date,sum(amount) as total_amount, sum(qty) as total_qty")
            ->get();
    }

    public function getOrderCheckInByMaterial($branchIds, $materialIds){
        if(!is_array($branchIds)) $branchIds = [$branchIds];
        if(!is_array($materialIds)) $materialIds = [$materialIds];
        return $this->model::whereIn('branch_id',$branchIds)
            ->whereIn('material_id',$materialIds)
            ->get();
    }

}
