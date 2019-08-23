<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\SessionHelper;
use App\Services\DashboardService;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class HomeController extends Controller
{
    protected $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(){
        if(!\Illuminate\Support\Facades\Gate::allows('subs-only', Auth::user())){
            return "Ban khong co quyen";
        }
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
