<?php

namespace App\Http\Controllers\Employee;

use App\Common\AuthCommon;
use App\Common\PermissionRoleCommon;
use App\Enums\ScreenEnum;
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

    public function __construct(TimeKeepingService $timeKeepingService)
    {
        $this->timeKeepingService = $timeKeepingService;
    }

    public function index(){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $employeeId = PermissionRoleCommon::getPermissionUserOnBranch(AuthCommon::AuthEmployee()->user(), ScreenEnum::SCREEN_TIME_KEEPING_URL);
        $result = $this->timeKeepingService->getTimeKeeping($branchId, $currentDate,$employeeId);
        return $this->viewEmployee('timekeeping.time_keeping',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'employees' => $result['employees'],
            'infoDays' => $result['infoDays'],
            'arrayEmployeeDaily' => $result['arrayEmployeeDaily'],
            'totalSalaryAmount' => $result['totalSalaryAmount']
        ]);
    }

    public function updateTimeKeeping(Request $request){
        $resultQty = $this->timeKeepingService->updateTimeKeeping($request->all());
        return response()->json($resultQty);
    }
}
