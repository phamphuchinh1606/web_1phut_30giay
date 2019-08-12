<?php
namespace App\Services;

use App\Helpers\AppHelper;
use Illuminate\Support\Facades\DB;

class TimeKeepingService extends BaseService {

    public function updateTimeKeeping($values){
        $inputValue = $values['value'];
        $inputName = $values['name'];
        $month = $values['month'];
        $employeeId = $values['employee_id'];
        $branchId = 1;
        $result = [];
        try{
            DB::beginTransaction();
            $whereValues = array('branch_id' => $branchId, 'month_date' => $month, 'employee_id' => $employeeId);
            $currentMonth = $month.'-01';
            $employeeSums = $this->employeeDailyRepository->getEmployeeOneTotalByMonth($branchId,$currentMonth,$employeeId);
            if(!isset($employeeSums)){
                $updateValues = array(
                    'total_first_hour' => 0,
                    'total_last_hour' => 0,
                    'total_first_amount' => 0,
                    'total_last_amount' => 0,
                    'total_amount' => 0,
                );
            }else{
                $updateValues = array(
                    'total_first_hour' => $employeeSums->total_first_hour,
                    'total_last_hour' => $employeeSums->total_last_hour,
                    'total_first_amount' => $employeeSums->total_first_amount,
                    'total_last_amount' => $employeeSums->total_last_amount,
                    'total_amount' => $employeeSums->total_first_amount + $employeeSums->total_last_amount,
                );
            }
            $updateValues = array_merge($updateValues, array($inputName => $inputValue));
            $updateValues = array_merge($updateValues, array(
                'salary_amount' => array('total_amount' ,'diligence_amount', 'allowance_amount','bonus_amount','extra_allowance_amount')
            ));
            $employeeTimeKeeping = $this->employeeTimeKeepingRepository->updateOrCreate($updateValues, $whereValues);
            $totalSalaryAmount = $this->employeeTimeKeepingRepository->getTotalSalaryByMonth($branchId,$currentMonth);
            if(isset($employeeTimeKeeping)){
                $result['salary_amount'] = AppHelper::formatMoney($employeeTimeKeeping->salary_amount);
            }else{
                $result['salary_amount'] = $inputValue + $updateValues['total_amount'];
            }
            $result['total_salary_amount'] = AppHelper::formatMoney($totalSalaryAmount);
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
        return $result;
    }
}
