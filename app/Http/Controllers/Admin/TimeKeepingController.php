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
    private $timeKeepingService;

    public function __construct(TimeKeepingService $timeKeepingService)
    {
        $this->timeKeepingService = $timeKeepingService;
    }

    public function index(){
        $currentDate = DateTimeHelper::now();
        $branchId = 1;
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
        $resultQty = $this->timeKeepingService->updateTimeKeeping($request->all());
        return response()->json($resultQty);
    }
}
