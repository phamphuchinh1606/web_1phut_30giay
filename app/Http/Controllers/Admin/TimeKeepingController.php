<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Models\EmployeeDaily;
use App\Models\EmployeeTimeKeeping;
use App\Repositories\Eloquents\EmployeeDailyRepository;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\EmployeeTimeKeepingRepository;
use App\Services\TimeKeepingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeKeepingController extends Controller
{
    private $timeKeepingService;
    private $employeeRepository;

    public function __construct(TimeKeepingService $timeKeepingService, EmployeeRepository $employeeRepository)
    {
        $this->timeKeepingService = $timeKeepingService;
        $this->employeeRepository = $employeeRepository;
    }

    public function index(){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $result = $this->timeKeepingService->getTimeKeeping($branchId, $currentDate);
        return $this->viewAdmin('timekeeping.time_keeping',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'employees' => $result['employees'],
            'infoDays' => $result['infoDays'],
            'arrayEmployeeDaily' => $result['arrayEmployeeDaily'],
            'totalSalaryAmount' => $result['totalSalaryAmount']
        ]);
    }

    public function updateTimeKeeping(Request $request){
        $value = $request->all();
        if(!isset($value['branch_id'])) $value['branch_id'] = SessionHelper::getSelectedBranchId();
        $resultQty = $this->timeKeepingService->updateTimeKeeping($value);
        return response()->json($resultQty);
    }

    public function printViewTimeKeeping($id, Request $request){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $result = $this->timeKeepingService->getTimeKeeping($branchId, $currentDate,$id);
        $employees = $result['employees'];
//        $employee = $this->employeeRepository->find($id);
        if(count($employees) > 0) $employee = $employees[0];
        return $this->viewAdmin('timekeeping.print_view_time_keeping',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'employees' => $result['employees'],
            'employee' => $employee,
            'infoDays' => $result['infoDays'],
            'arrayEmployeeDaily' => $result['arrayEmployeeDaily'],
            'totalSalaryAmount' => $result['totalSalaryAmount']
        ]);
    }
}
