<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use Illuminate\Support\Facades\DB;

class CheckInService extends BaseService {

    public function getCheckInByMonth($branchId, $date){
        $infoDays = DateTimeHelper::parseMonthToArrayDay($date);
        $weeks = DateTimeHelper::parseWeekToArray($date);
        $suppliers = $this->supplierRepository->selectAll();
        $checkInAmountMonth = $this->orderCheckInRepository->getCheckInByMonth($branchId, $date);

        $arrayCheckInDaily = ArrayHelper::parseListObjectToArrayKey($checkInAmountMonth, array('supplier_id','check_in_date'));

        foreach ($infoDays as $day) {
            $keyDate = $day->date->format('Y-m-d');
            foreach ($suppliers as $supplier){
                $key = $supplier->id.'_'.$keyDate;
                $supplier = new \StdClass();
                $supplier->total_amount = 0;
                if(isset($arrayCheckInDaily[$key])){
                    $supplier = $arrayCheckInDaily[$key];
                }
                $day->suppliers[] = $supplier;
            }
        }
        $result['infoDay'] = $infoDays;
        $result['suppliers'] = $suppliers;
        return $result;
    }
}
