<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Services\CheckInService;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    protected $checkInService;

    public function __construct(CheckInService $checkInService)
    {
        $this->checkInService = $checkInService;
    }

    public function daily(Request $request){
        $currentDate = DateTimeHelper::now();
        $branchId = 1;
        $result = $this->checkInService->getCheckInByMonth($branchId,$currentDate);
        return $this->viewAdmin('checkin.check_in_daily',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'infoDays' => $result['infoDays'],
            'suppliers' => $result['suppliers']
        ]);
    }
}
