<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use App\Models\OrderCheckIn;
use App\Models\SettingApp;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class DashboardService extends BaseService {

    public function monthDashboard($branchId, $date){
        $settingApp = $this->settingRepository->findByKey(['branch_id' => $branchId]);
        if(!isset($settingApp)){
            $settingApp = new SettingApp();
            $settingApp->percent_shipping = 0;
            $settingApp->rent_amount = 0;
        }
        $dashboard = new \StdClass();
        $dashboard->sum_real_amount = $this->orderBillRepository->sumRealAmountByMonth($branchId,$date);
        $dashboard->sum_check_in_1p30s_amount = $this->orderCheckInRepository->amountByMonth($branchId,$date, OrderCheckIn::CHECK_IN_TYPE, Supplier::SUPPLIER_1P_30S_ID);
        $dashboard->sum_check_in_1p30s_add_amount = $this->orderCheckInRepository->amountByMonth($branchId,$date, OrderCheckIn::arrayTypeCheckInCharge(), Supplier::SUPPLIER_1P_30S_ID);
        $dashboard->sum_check_in_1p30s_amount_charge = $this->orderCheckInRepository->amountByMonth($branchId,$date, OrderCheckIn::arrayTypeCheckInMoneyCharge(), Supplier::SUPPLIER_1P_30S_ID);
        $dashboard->sum_check_in_rock_amount = $this->orderCheckInRepository->amountByMonth($branchId,$date, OrderCheckIn::CHECK_IN_TYPE, Supplier::SUPPLIER_ROCK_ID);
        $dashboard->sum_shipping_amount = round($dashboard->sum_check_in_1p30s_amount_charge * $settingApp->percent_shipping);
        $dashboard->sum_time_kipping_amount = $this->employeeTimeKeepingRepository->getTotalSalaryByMonth($branchId,$date);
        $dashboard->sum_payment_bill_amount = $this->paymentBillRepository->getTotalAmountByMonth($branchId,$date);
        $dashboard->sum_cash_hourse_amount = $settingApp->rent_amount;

        $dashboard->real_profit_amount = $dashboard->sum_real_amount - $dashboard->sum_check_in_1p30s_amount - $dashboard->sum_check_in_1p30s_add_amount - $dashboard->sum_check_in_rock_amount - $dashboard->sum_shipping_amount
                - $dashboard->sum_time_kipping_amount - $dashboard->sum_payment_bill_amount - $dashboard->sum_cash_hourse_amount;
        if($dashboard->real_profit_amount < 0){
            $dashboard->real_profit_amount_badge = 'badge-danger';
        }else if($dashboard->real_profit_amount > 0){
            $dashboard->real_profit_amount_badge = 'badge-primary';
        }else{
            $dashboard->real_profit_amount_badge = 'badge-primary';
        }
        return $dashboard;
    }

}
