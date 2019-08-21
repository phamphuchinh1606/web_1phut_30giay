<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Helpers\SessionHelper;
use App\Services\SaleReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleCartSmallController extends Controller
{
    private $saleReportService;

    public function __construct(SaleReportService $saleReportService)
    {
        $this->saleReportService = $saleReportService;
    }

    public function index(){
        $currentDate = SessionHelper::getSelectedMonth();
        $branchId = SessionHelper::getSelectedBranchId();
        $result = $this->saleReportService->getSaleCartSmall($branchId,$currentDate);
        return $this->viewAdmin('saleCartSmall.sale_cart_small',[
            'branchId' => $branchId,
            'currentDate' => $currentDate,
            'employees' => $result['employees'],
            'infoDays' => $result['infoDays']
        ]);
    }

    public function updateSaleCartSmall(Request $request){
        $values = $request->all();
        $resultQty = $this->saleReportService->updateSaleCartSmall($values);
        return response()->json($resultQty);
    }
}
