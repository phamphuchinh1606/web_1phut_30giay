<?php
namespace App\Services;

use App\Models\OrderCancel;
use App\Repositories\Eloquents\EmployeeDailyRepository;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\EmployeeTimeKeepingRepository;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\OrderBillRepository;
use App\Repositories\Eloquents\OrderCancelRepository;
use App\Repositories\Eloquents\OrderCheckInRepository;
use App\Repositories\Eloquents\OrderCheckOutRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\SaleRepository;
use App\Repositories\Eloquents\StockDailyRepository;
use App\Repositories\Eloquents\UnitRepository;

class BaseService {

    protected $materialRepository;
    protected $materialTypeRepository;
    protected $unitRepository;
    protected $orderCheckInRepository;
    protected $orderCheckOutRepository;
    protected $orderCancelRepository;
    protected $orderBillRepository;
    protected $stockDailyRepository;
    protected $saleRepository;
    protected $productRepository;
    protected $employeeRepository;
    protected $employeeDailyRepository;
    protected $employeeTimeKeepingRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, UnitRepository $unitRepository,
                OrderCheckInRepository $orderCheckInRepository, OrderCheckOutRepository $orderCheckOutRepository, OrderCancelRepository $orderCancelRepository,
                OrderBillRepository $orderBillRepository,
                StockDailyRepository $stockDailyRepository, SaleRepository $saleRepository, ProductRepository $productRepository,
                EmployeeRepository $employeeRepository, EmployeeDailyRepository $employeeDailyRepository, EmployeeTimeKeepingRepository $employeeTimeKeepingRepository)
    {
        $this->materialRepository = $materialRepository;
        $this->materialTypeRepository = $materialTypeRepository;
        $this->unitRepository = $unitRepository;
        $this->orderCheckInRepository = $orderCheckInRepository;
        $this->orderCheckOutRepository = $orderCheckOutRepository;
        $this->orderCancelRepository = $orderCancelRepository;
        $this->orderBillRepository = $orderBillRepository;
        $this->stockDailyRepository = $stockDailyRepository;
        $this->saleRepository = $saleRepository;
        $this->productRepository = $productRepository;
        $this->employeeRepository = $employeeRepository;
        $this->employeeDailyRepository = $employeeDailyRepository;
        $this->employeeTimeKeepingRepository = $employeeTimeKeepingRepository;
    }


}
