<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Services\SaleReportService;
use Illuminate\Http\Request;

class SaleCartSmallController extends Controller
{
    private $saleReportService;

    public function __construct(SaleReportService $saleReportService)
    {
        $this->saleReportService = $saleReportService;
    }

    public function index(){
        $branchId = 1;
        $currentDate = DateTimeHelper::now();
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
