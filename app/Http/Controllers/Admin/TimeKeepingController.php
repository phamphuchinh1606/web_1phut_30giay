<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Models\EmployeeDaily;
use App\Models\EmployeeTimeKeeping;
use App\Repositories\Eloquents\EmployeeDailyRepository;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\EmployeeTimeKeepingRepository;
use App\Services\TimeKeepingService;
use Illuminate\Http\Request;

class TimeKeepingController extends Controller
{
    private $employeeRepository;
    private $employeeDailyRepository;
    private $employeeTimeKeepingRepository;
    private $timeKeepingService;

    public function __construct(EmployeeRepository $employeeRepository, EmployeeDailyRepository $employeeDailyRepository,
                    EmployeeTimeKeepingRepository $employeeTimeKeepingRepository, TimeKeepingService $timeKeepingService)
    {
        $this->employeeRepository = $employeeRepository;
        $this->employeeDailyRepository = $employeeDailyRepository;
        $this->employeeTimeKeepingRepository = $employeeTimeKeepingRepository;
        $this->timeKeepingService = $timeKeepingService;
    }

    public function index(){
        $currentDate = DateTimeHelper::now();
        $branchId = 1;
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
        return $this->viewAdmin('timekeeping.time_keeping',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'employees' => $employees,
            'infoDays' => $infoDays,
            'arrayEmployeeDaily' => $arrayEmployeeDaily,
            'totalSalaryAmount' => $totalSalaryAmount
        ]);
    }

    public function updateTimeKeeping(Request $request){
        $resultQty = $this->timeKeepingService->updateTimeKeeping($request->all());
        return response()->json($resultQty);
    }
}
