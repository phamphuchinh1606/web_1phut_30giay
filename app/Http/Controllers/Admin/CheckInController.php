<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Services\CheckInService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckInController extends Controller
{
    protected $checkInService;

    public function __construct(CheckInService $checkInService)
    {
        $this->checkInService = $checkInService;
    }

    public function daily(Request $request){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $result = $this->checkInService->getCheckInByMonth($branchId,$currentDate);
        return $this->viewAdmin('checkin.check_in_daily',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'infoDays' => $result['infoDays'],
            'suppliers' => $result['suppliers']
        ]);
    }
}
