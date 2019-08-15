<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Repositories\Eloquents\EmployeeDailyRepository;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\OrderBillRepository;
use App\Repositories\Eloquents\OrderCheckInRepository;
use App\Repositories\Eloquents\OrderCheckOutRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\SaleRepository;
use App\Services\MaterialService;
use Illuminate\Http\Request;

class InputDailyController extends Controller
{
    private $materialService;

    private $materialRepository;

    private $materialTypeRepository;

    private $employeeRepository;

    private $employeeDailyRepository;

    private $productRepository;

    private $orderCheckInRepository;

    private $orderCheckOutRepository;

    private $saleRepository;

    private $orderBillRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, EmployeeRepository $employeeRepository,
        ProductRepository $productRepository, OrderCheckInRepository $orderCheckInRepository, MaterialService $materialService, SaleRepository $saleRepository,
        OrderBillRepository $orderBillRepository, EmployeeDailyRepository $employeeDailyRepository, OrderCheckOutRepository $orderCheckOutRepository)
    {
        $this->materialService = $materialService;
        $this->materialRepository = $materialRepository;
        $this->materialTypeRepository = $materialTypeRepository;
        $this->employeeRepository = $employeeRepository;
        $this->employeeDailyRepository = $employeeDailyRepository;
        $this->productRepository = $productRepository;
        $this->orderCheckInRepository = $orderCheckInRepository;
        $this->orderCheckOutRepository = $orderCheckOutRepository;
        $this->saleRepository = $saleRepository;
        $this->orderBillRepository = $orderBillRepository;
    }

    public function index($date = null, Request $request){
        if(isset($date)) $currentDate = DateTimeHelper::dateFromString($date);
        else $currentDate = DateTimeHelper::now();
        $branchId = 1;
        $infoDays = DateTimeHelper::getArrayDateByCurrentDate(DateTimeHelper::now());
        $materialTypes = $this->materialTypeRepository->selectAll();
        $materials = $this->materialRepository->getAllByFormInput($currentDate);
        $employees = $this->employeeRepository->getEmployeeDaily($branchId,$currentDate);
        $sumEmployeeTotal = $this->employeeDailyRepository->sumTotalDaily($branchId,$currentDate);
        $products = $this->productRepository->selectProductMergeSales($currentDate);
        $sales = $this->saleRepository->findByKey(array('branch_id' => $branchId,'sale_date' => $currentDate->format('Y-m-d')));
        $orderBill = $this->orderBillRepository->findByKeyOrCreate(array('branch_id' => $branchId,'bill_date' => $currentDate->format('Y-m-d')));
        $totalAmountCheckIn = $this->orderCheckInRepository->getTotalAmountByDate($branchId,$currentDate);
        $totalAmountCheckOut = $this->orderCheckOutRepository->getTotalAmountByDate($branchId,$currentDate);
        return $this->viewAdmin('input.input_daily',[
            'currentDate' => $currentDate,
            'branchId' => $branchId,
            'infoDays' => $infoDays,
            'materialTypes' => $materialTypes,
            'materials' => $materials,
            'employees' => $employees,
            'sumEmployeeTotal' => $sumEmployeeTotal,
            'products' => $products,
            'sales' => $sales,
            'orderBill' => $orderBill,
            'totalAmountCheckIn' => $totalAmountCheckIn,
            'totalAmountCheckOut' => $totalAmountCheckOut
        ]);
    }

    public function updateDaily(Request $request){
        $resultQty = $this->materialService->updateInputDaily($request->all());
        return response()->json($resultQty);
    }

    public function updateSale(Request $request){
        $resultQty = $this->materialService->updateSale($request->all());
        return response()->json($resultQty);
    }

    public function updateBill(Request $request){
        $resultQty = $this->materialService->updateBill($request->all());
        return response()->json($resultQty);
    }

    public function updateEmployee(Request $request){
        $resultQty = $this->materialService->updateEmployee($request->all());
        return response()->json($resultQty);
    }
}
