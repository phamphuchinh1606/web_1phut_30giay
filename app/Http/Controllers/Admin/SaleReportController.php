<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Models\Sale;
use App\Repositories\Eloquents\EmployeeTimeKeepingRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\SaleRepository;
use App\Services\SaleReportService;
use Illuminate\Http\Request;

class SaleReportController extends Controller
{
    private $saleReportService;


    public function __construct(SaleReportService $saleReportService)
    {
        $this->saleReportService = $saleReportService;
    }

    public function index(Request $request){
        $currentDate = DateTimeHelper::now();
        $branchId = 1;
        $result =  $this->saleReportService->getSaleReport($branchId,$currentDate);
        return $this->viewAdmin('saleReport.sale_report',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'products' => $result['products'],
            'infoDays' => $result['infoDays'],
        ]);
    }
}
