<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use App\Models\OrderBill;
use App\Models\Sale;
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

}
