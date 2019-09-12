<?php
namespace App\Services;

use App\Common\Constant;
use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use Illuminate\Support\Facades\DB;

class FinanceService extends BaseService {

    public function getFinanceSaleAmount($branchId, $date){
        try{
            DB::beginTransaction();
            $orderBills = $this->orderBillRepository->getOrderBillRelationFinanceByMonth($branchId, $date);
            foreach ($orderBills as $orderBill){
                if(!isset($orderBill->date_daily) || empty($orderBill->date_daily)){
                    if($orderBill->real_amount > 0){
                        $this->financeRepository->create([
                            'branch_id' => $branchId,
                            'date_daily' => $orderBill->bill_date,
                            'amount_in' => $orderBill->real_amount,
                            'order_bill_id' => $orderBill->id,
                            'note' => 'Tiền Bán Hàng'
                        ]);
                    }
                }else if(isset($orderBill->date_daily) && !empty($orderBill->date_daily) && $orderBill->real_amount != $orderBill->finance_amount_in){
                    $this->financeRepository->updateById($orderBill->finance_id,[
                        'amount_in' => $orderBill->real_amount,
                    ]);
                }
            }
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }

    }

}
