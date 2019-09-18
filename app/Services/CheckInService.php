<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class CheckInService extends BaseService {

    public function getCheckInByMonth($branchId, $date){
        $infoDays = DateTimeHelper::parseMonthToArrayDay($date);
        $weeks = DateTimeHelper::parseWeekToArray($date);
        $suppliers = $this->supplierRepository->selectAll();
        $checkInAmountMonth = $this->orderCheckInRepository->getCheckInByMonth($branchId, $date);
        $checkInAddAmountMonth = $this->orderCheckInRepository->getCheckInAddByMonth($branchId,$date);

        $arrayCheckInDaily = ArrayHelper::parseListObjectToArrayKey($checkInAmountMonth, array('supplier_id','check_in_date'));
        $arrayCheckInAddDaily = ArrayHelper::parseListObjectToArrayKey($checkInAddAmountMonth, array('check_in_date'));
        foreach ($weeks as $week){
            $sumTotalAmount = 0;
            foreach ($suppliers as $supplier){
                $totalAmount = 0;
                $totalQty = 0;
                foreach ($week->date_array as $dateWeek) {
                    $keyDate = $dateWeek->format('Y-m-d');
                    $key = $supplier->id.'_'.$keyDate;
                    if(isset($arrayCheckInDaily[$key])){
                        $totalAmount+= $arrayCheckInDaily[$key]->total_amount;
                        $totalQty+= $arrayCheckInDaily[$key]->total_qty;
                    }
                    if(Supplier::SUPPLIER_1P_30S_ID == $supplier->id){
                        if(isset($arrayCheckInAddDaily[$keyDate])){
                            $totalAmount+= $arrayCheckInAddDaily[$keyDate]->total_amount;
                            $totalQty+= $arrayCheckInAddDaily[$keyDate]->total_qty;
                            if(isset($arrayCheckInDaily[$key])){
                                $arrayCheckInDaily[$key]->total_amount+= $arrayCheckInAddDaily[$keyDate]->total_amount;
                                $arrayCheckInDaily[$key]->total_qty+= $arrayCheckInAddDaily[$keyDate]->total_qty;
                            }
                        }
                    }
                }
                eval('$week->total_amount_'.$supplier->id.'=$totalAmount;');
                eval('$week->total_qty_'.$supplier->id.'=$totalQty;');
                $sumTotalAmount+= $totalAmount;
            }
            $week->sum_total_amount = $sumTotalAmount;
        }

        foreach ($infoDays as $day) {
            $keyDate = $day->date->format('Y-m-d');
            foreach ($suppliers as $supplier){
                $key = $supplier->id.'_'.$keyDate;
                $supplierItem = new \StdClass();
                $supplierItem->total_amount = 0;
                $supplierItem->total_qty = 0;
                if(isset($arrayCheckInDaily[$key])){
                    $supplierItem = $arrayCheckInDaily[$key];
                }
                $supplierItem->supplier_id = $supplier->id;
                $day->suppliers[] = $supplierItem;
            }
            foreach ($weeks as $week){
                if($week->week_of_thing == $day->week_of_thing){
                    $day->week = $week;
                }
            }
        }
        $result['infoDays'] = $infoDays;
        $result['suppliers'] = $suppliers;
        return $result;
    }
}
