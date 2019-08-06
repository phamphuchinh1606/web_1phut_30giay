<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateTimeHelper;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\OrderCheckInRepository;
use App\Repositories\Eloquents\ProductRepository;
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

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, EmployeeRepository $employeeRepository,
        ProductRepository $productRepository, OrderCheckInRepository $orderCheckInRepository, MaterialService $materialService)
    {
        $this->materialService = $materialService;
        $this->materialRepository = $materialRepository;
        $this->materialTypeRepository = $materialTypeRepository;
        $this->employeeRepository = $employeeRepository;
        $this->productRepository = $productRepository;
        $this->orderCheckInRepository = $orderCheckInRepository;
    }

    public function index(){
        $currentDate = DateTimeHelper::now();
        $materialTypes = $this->materialTypeRepository->selectAll();
        $materials = $this->materialRepository->getAllByFormInput($currentDate);
        $employees = $this->employeeRepository->getEmployeeByBranch(1);
        $products = $this->productRepository->selectAll();
        return $this->viewAdmin('input.input_daily',[
            'currentDate' => $currentDate,
            'materialTypes' => $materialTypes,
            'materials' => $materials,
            'employees' => $employees,
            'products' => $products
        ]);
    }

    public function updateDaily(Request $request){
        $this->materialService->updateInputDaily($request->all());
    }
}
