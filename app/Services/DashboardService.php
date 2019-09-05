<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use App\Models\OrderCheckIn;
use Illuminate\Support\Facades\DB;

class DashboardService extends BaseService {

    public function monthDashboard($branchId, $date){
        $dashboard = new \StdClass();
        $dashboard->sum_real_amount = $this->orderBillRepository->sumRealAmountByMonth($branchId,$date);
        $dashboard->sum_check_in_1p30s_amount = $this->orderCheckInRepository->amountByMonth($branchId,$date, OrderCheckIn::CHECK_IN_TYPE);
        $dashboard->sum_check_in_rock_amount = $this->orderCheckInRepository->amountByMonth($branchId,$date, OrderCheckIn::MOVE_IN_TYPE);
        $dashboard->sum_shipping_amount = round($dashboard->sum_check_in_1p30s_amount * 4 / 100);
        $dashboard->sum_time_kipping_amount = $this->employeeTimeKeepingRepository->getTotalSalaryByMonth($branchId,$date);
        $dashboard->sum_payment_bill_amount = $this->paymentBillRepository->getTotalAmountByMonth($branchId,$date);
        $dashboard->sum_cash_hourse_amount = 3300000;

        $dashboard->real_profit_amount = $dashboard->sum_real_amount - $dashboard->sum_check_in_1p30s_amount - $dashboard->sum_check_in_rock_amount - $dashboard->sum_shipping_amount
                - $dashboard->sum_time_kipping_amount - $dashboard->sum_payment_bill_amount - $dashboard->sum_cash_hourse_amount;
        if($dashboard->real_profit_amount < 0){
            $dashboard->real_profit_amount_badge = 'badge-danger';
        }else if($dashboard->real_profit_amount > 0){
            $dashboard->real_profit_amount_badge = 'badge-primary';
        }
        return $dashboard;
    }

}
