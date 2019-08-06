<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\OrderCheckInRepository;
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

    private $productRepository;

    private $orderCheckInRepository;

    private $saleRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, EmployeeRepository $employeeRepository,
        ProductRepository $productRepository, OrderCheckInRepository $orderCheckInRepository, MaterialService $materialService, SaleRepository $saleRepository)
    {
        $this->materialService = $materialService;
        $this->materialRepository = $materialRepository;
        $this->materialTypeRepository = $materialTypeRepository;
        $this->employeeRepository = $employeeRepository;
        $this->productRepository = $productRepository;
        $this->orderCheckInRepository = $orderCheckInRepository;
        $this->saleRepository = $saleRepository;
    }

    public function index(){
        $currentDate = DateTimeHelper::now();
        $materialTypes = $this->materialTypeRepository->selectAll();
        $materials = $this->materialRepository->getAllByFormInput($currentDate);
        $employees = $this->employeeRepository->getEmployeeByBranch(1);
        $products = $this->productRepository->selectProductMergeSales($currentDate);
        $sales = $this->saleRepository->findByKey(array('sale_date' => $currentDate->format('Y-m-d')));
        return $this->viewAdmin('input.input_daily',[
            'currentDate' => $currentDate,
            'materialTypes' => $materialTypes,
            'materials' => $materials,
            'employees' => $employees,
            'products' => $products,
            'sales' => $sales
        ]);
    }

    public function updateDaily(Request $request){
        $resultQty = $this->materialService->updateInputDaily($request->all());
        return response()->json($resultQty);
    }
}
