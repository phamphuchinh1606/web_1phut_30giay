<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use App\Models\OrderBill;
use App\Models\Sale;
use App\Models\SaleCardSmall;
use Illuminate\Support\Facades\DB;

class SaleReportService extends BaseService {

    public function getSaleReport($branchId, $date){
        $infoDays = DateTimeHelper::parseMonthToArrayDay($date);
        $weeks = DateTimeHelper::parseWeekToArray($date);
        $products = $this->productRepository->selectAll();
        $sumAmountByMonth = $this->saleRepository->sumAmountSaleByMonth($branchId,$date);
        $saleMonths = $this->saleRepository->getSaleByMonth($branchId,$date);
        $orderBills = $this->orderBillRepository->getOrderBillByMonth($branchId,$date);
        $employeeDailies = $this->employeeDailyRepository->getAmountTotalByMonth($branchId,$date);
        $orderCheckInDailies = $this->orderCheckInRepository->getTotalAmountByMonth($branchId,$date);
        $paymentBillDailies = $this->paymentBillRepository->getAmountByMonth($branchId,$date);

        $arraySaleMonth = ArrayHelper::parseListObjectToArrayKey($saleMonths,array('product_id','sale_date'));

        $arraySumAmount = ArrayHelper::parseListObjectToArrayKey($sumAmountByMonth,'sale_date');

        $arrayOrderBill = ArrayHelper::parseListObjectToArrayKey($orderBills, 'bill_date');

        $arrayEmployeeDaily = ArrayHelper::parseListObjectToArrayKey($employeeDailies, 'date_daily');

        $arrayCheckInDaily = ArrayHelper::parseListObjectToArrayKey($orderCheckInDailies, 'check_in_date');

        $arrayPaymentBillDaily = ArrayHelper::parseListObjectToArrayKey($paymentBillDailies, 'bill_date');

        foreach ($weeks as $week){
            $sumRealAmount = 0;
            $sumEmployeeTimeKeepingAmount = 0;
            $sumCheckInAmount = 0;
            $sumPaymentBill = 0;
            foreach ($week->date_array as $dateWeek){
                $keyDate = $dateWeek->format('Y-m-d');
                $orderBill = new OrderBill();
                if(isset($arrayOrderBill[$keyDate])){
                    $orderBill = $arrayOrderBill[$keyDate];
                }
                $sumRealAmount+= $orderBill->real_amount;

                //Set Employee Time
                if(isset($arrayEmployeeDaily[$keyDate])){
                    $sumEmployeeTimeKeepingAmount+= $arrayEmployeeDaily[$keyDate]->total_amount;
                }

                //Set Check In
                if(isset($arrayCheckInDaily[$keyDate])){
                    $sumCheckInAmount+= $arrayCheckInDaily[$keyDate]->total_amount;
                }

                //Set Payment Bill
                if(isset($arrayPaymentBillDaily[$keyDate])){
                    $sumPaymentBill+= $arrayPaymentBillDaily[$keyDate]->total_amount;
                }
            }
            $week->sum_real_amount = $sumRealAmount;
            $week->sum_time_keeping_amount = $sumEmployeeTimeKeepingAmount;
            $week->sum_check_in_amount = $sumCheckInAmount;
            $week->sum_payment_bill_amount = $sumPaymentBill;
            $week->sum_profit_amount = $sumRealAmount - ($sumEmployeeTimeKeepingAmount + $sumCheckInAmount + $sumPaymentBill);
        }

        foreach ($infoDays as $day){
            $keyDate = $day->date->format('Y-m-d');
            foreach ($products as $product){
                $key = $product->id.'_'.$keyDate;
                $saleProduct = new Sale();
                if(isset($arraySaleMonth[$key])){
                    $saleProduct = $arraySaleMonth[$key];
                }
                $day->sale_products[] = $saleProduct;
            }
            $sumAmount = isset($arraySumAmount[$keyDate]) ? $arraySumAmount[$keyDate] : null;
            if(isset($sumAmount)){
                $day->sum_qty = $sumAmount->sum_qty;
                $day->sum_amount = $sumAmount->sum_amount;
            }else{
                $day->sum_qty = 0;
                $day->sum_amount = 0;
            }
            $orderBill = new OrderBill();
            if(isset($arrayOrderBill[$keyDate])){
                $orderBill = $arrayOrderBill[$keyDate];
            }
            $day->real_amount = $orderBill->real_amount;
            $day->lack_amount = $orderBill->lack_amount;

            foreach ($weeks as $week){
                if($week->week_of_thing == $day->week_of_thing){
                    $day->week = $week;
                }
            }
        }
        $result['products'] = $products;
        $result['infoDays'] = $infoDays;
        return $result;
    }

    public function getSaleCartSmall($branchId, $date){
        $infoDays = DateTimeHelper::parseMonthToArrayDay($date);
        $employees = $this->employeeRepository->getEmployeeSaleSmall($branchId);
        $saleCartSmalls = $this->saleCartSmallRepository->getSaleSmallByMonth($branchId,$date);
        $sumSaleCartSmall = $this->saleCartSmallRepository->getSumSaleSmallByMonth($branchId,$date);

        $arraySaleCardSmall = ArrayHelper::parseListObjectToArrayKey($saleCartSmalls,array('employee_id','sale_date'));
        $arraySumSaleCardSmall = ArrayHelper::parseListObjectToArrayKey($sumSaleCartSmall,array('employee_id','sale_date'));

        foreach ($infoDays as $day) {
            $keyDate = $day->date->format('Y-m-d');
            foreach ($employees as $employee){
                $key = $employee->id.'_'.$keyDate;
                $saleCardSmall = new SaleCardSmall();
                $saleCardSmall->employee_id = $employee->id;
                if(isset($arraySaleCardSmall[$key])){
                    $saleCardSmall = $arraySaleCardSmall[$key];
                }
                if(isset($arraySumSaleCardSmall[$key])){
                    $saleCardSmall->sum_qty = $arraySumSaleCardSmall[$key]->sum_qty;
                    $saleCardSmall->sum_qty_target = $arraySumSaleCardSmall[$key]->sum_qty_target;
                    $saleCardSmall->sum_bonus_amount = $arraySumSaleCardSmall[$key]->sum_bonus_amount;
                }else{
                    $saleCardSmall->sum_qty = 0;
                    $saleCardSmall->sum_qty_target = 0;
                    $saleCardSmall->sum_bonus_amount = 0;
                }
                $day->employee_sale_card_smalls[] = $saleCardSmall;
            }
        }


        $result['employees'] = $employees;
        $result['infoDays'] = $infoDays;
        return $result;
    }

    public function updateSaleCartSmall($values){
        $inputName = $values['name'];
        $inputValue = $values['value'];
        $dailyDate = $values['date'];
        $employeeId = $values['employee_id'];
        $branchId = 1;

        $target = 20;
        $step = 5;
        $stepAmount = [1000,2000,2000,2000,2000,2000,2000,2000,2000,2000];
        $qtyTarget = $inputValue - $target;
        $bonusAmount = 0;
        for ($i = 1; $i <= ($qtyTarget/$step) + 1 ; $i++){
            $qtyStep = $step;
            if($qtyTarget < $step * $i){
                $qtyStep = $qtyTarget -  $step * ($i-1);
            }
            $bonusAmount+= $stepAmount[$i-1]  * $qtyStep;
        }
        $qtyTarget = $qtyTarget < 0 ? 0 : $qtyTarget;
        $updateValues = array(
            'qty' => $inputValue,
            'qty_target' => $qtyTarget,
            'bonus_amount' => $bonusAmount
        );
        $whereValues = array(
            'branch_id' => $branchId,
            'sale_date' => $dailyDate,
            'employee_id' => $employeeId
        );

        $saleCartSmall = $this->saleCartSmallRepository->updateOrCreate($updateValues, $whereValues);
        $result['qty_target'] = AppHelper::formatMoney($qtyTarget);
        $result['bonus_amount'] = AppHelper::formatMoney($bonusAmount);
        $result['employee_id'] = $employeeId;
        return $result;
    }

}
