<?php

namespace App\Repositories\Eloquents;

use App\Helpers\DateTimeHelper;
use App\Models\Finance;
use App\Models\OrderBill;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class OrderBillRepository extends BaseRepository
{
    public function __construct(OrderBill $model)
    {
        $this->model = $model;
    }

    public function sumRealAmountByMonth($branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('bill_date','>=', $firstDate)
            ->where('bill_date','<=', $lastDate)
            ->sum('real_amount');
    }

    public function getOrderBillByMonth($branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        return $this->model::where('branch_id',$branchId)
            ->where('bill_date','>=', $firstDate)
            ->where('bill_date','<=', $lastDate)
            ->get();
    }

    public function getOrderBillRelationFinanceByMonth($branchId, $date){
        if(is_string($date)) $date = DateTimeHelper::dateFromString($date);
        $firstDate = DateTimeHelper::startOfMonth($date,'Y-m-d');
        $lastDate = DateTimeHelper::endOfMonth($date,'Y-m-d');
        $tableFinanceName = Finance::getTableName();
        $tableOrderBillName = OrderBill::getTableName();
        return $this->model::leftjoin("$tableFinanceName","$tableFinanceName.order_bill_id","$tableOrderBillName.id")
            ->where("$tableOrderBillName.branch_id",$branchId)
            ->where("$tableOrderBillName.bill_date",'>=', $firstDate)
            ->where("$tableOrderBillName.bill_date",'<=', $lastDate)
            ->select("$tableOrderBillName.*","$tableFinanceName.id as finance_id","$tableFinanceName.date_daily","$tableFinanceName.amount_in as finance_amount_in")
            ->get();
    }

}
