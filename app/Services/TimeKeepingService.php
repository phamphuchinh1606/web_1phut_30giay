<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\DateTimeHelper;
use App\Models\EmployeeDaily;
use Illuminate\Support\Facades\DB;

class TimeKeepingService extends BaseService {

    public function getTimeKeeping($branchId, $currentDate){
        $employees = $this->employeeRepository->getEmployeeByBranch($branchId);
        $employeeDailies = $this->employeeDailyRepository->getEmployeeByMonth($branchId,$currentDate);
        $employeeSums = $this->employeeDailyRepository->getEmployeeTotalByMonth($branchId,$currentDate);
        $employeeTimeKeepings = $this->employeeTimeKeepingRepository->getEmployeeTotalByMonth($branchId,$currentDate);
        $totalSalaryAmount = 0;
        foreach ($employees as $employee){
            foreach ($employeeSums as $employeeSum){
                if($employee->id == $employeeSum->employee_id){
                    $employee->total_first_hour = $employeeSum->total_first_hour;
                    $employee->total_last_hour = $employeeSum->total_last_hour;
                    $employee->total_first_amount = $employeeSum->total_first_amount;
                    $employee->total_last_amount = $employeeSum->total_last_amount;
                }
            }
            foreach ($employeeTimeKeepings as $employeeTimeKeeping){
                if($employee->id == $employeeTimeKeeping->employee_id){
                    $employee->diligence_amount  = $employeeTimeKeeping->diligence_amount ;
                    $employee->allowance_amount = $employeeTimeKeeping->allowance_amount;
                    $employee->bonus_amount = $employeeTimeKeeping->bonus_amount;
                    $employee->extra_allowance_amount  = $employeeTimeKeeping->extra_allowance_amount ;
                    $employee->salary_amount = $employeeTimeKeeping->salary_amount;
                }
            }
            $totalSalaryAmount+= $employee->salary_amount;
        }

        $arrayEmployeeDaily = [];
        foreach ($employeeDailies as $employeeDaily){
            $arrayEmployeeDaily[$employeeDaily->employee_id.'_'.$employeeDaily->date_daily] = $employeeDaily;
        }
        $infoDays = DateTimeHelper::parseMonthToArrayDay($currentDate);
        $daySumWeek = null;
        $totalWeekAmount = 0;
        foreach ($infoDays as $indexDay => $day){
            if($day->week_no == 1 || $indexDay == 0){
                if(isset($daySumWeek)){
                    $daySumWeek->total_week_amount =$totalWeekAmount;
                }
                $daySumWeek = $day;
                $totalWeekAmount = 0;
            }
            foreach ($employees as $index => $employee){
                $key = $employee->id.'_'.$day->date->format('Y-m-d');
                $employeeDaily = new EmployeeDaily();
                if(isset($arrayEmployeeDaily[$key])){
                    $employeeDaily = $arrayEmployeeDaily[$key];
                }
                $day->employeeDailies[] = $employeeDaily;
                $day->total_first_hour = (isset($day->total_first_hour) ? $day->total_first_hour : 0) + $employeeDaily->first_hours;
                $day->total_last_hour = (isset($day->total_last_hour) ? $day->total_last_hour : 0) + $employeeDaily->last_hours;
                $day->total_first_amount = (isset($day->total_first_amount) ? $day->total_first_amount : 0) + $employeeDaily->first_hours * $employeeDaily->price_first_hour;
                $day->total_last_amount = (isset($day->total_last_amount) ? $day->total_last_amount : 0) + $employeeDaily->last_hours * $employeeDaily->price_last_hour;
                $day->total_amount = $day->total_first_amount  + $day->total_last_amount;
            }
            $totalWeekAmount+= $day->total_amount;
        }
        if(isset($daySumWeek)){
            $daySumWeek->total_week_amount =$totalWeekAmount;
        }
        $result['employees'] = $employees;
        $result['infoDays'] = $infoDays;
        $result['arrayEmployeeDaily'] = $arrayEmployeeDaily;
        $result['totalSalaryAmount'] = $totalSalaryAmount;
        return $result;
    }

    public function updateTimeKeeping($values,$isTransaction = true){
        $inputValue = isset($values['value']) ? $values['value'] : null;
        $inputName = isset($values['name']) ? $values['name'] : null;
        $month = $values['month'];
        $employeeId = $values['employee_id'];
        $branchId = 1;
        $result = [];
        try{
            if($isTransaction) DB::beginTransaction();
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
            if(isset($inputName) && !empty($inputName)){
                $updateValues = array_merge($updateValues, array($inputName => $inputValue));
            }
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
            if($isTransaction) DB::commit();
        }catch (\Exception $ex){
            if($isTransaction) DB::rollBack();
            if($isTransaction) dd($ex);
            else throw $ex;
        }
        return $result;
    }
}
