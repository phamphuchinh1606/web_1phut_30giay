<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SessionHelper;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $dashboard = $this->dashboardService->monthDashboard($branchId,$currentDate);
        return $this->viewAdmin('home.index',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'dashboard' => $dashboard
        ]);
    }
}
