<?php
namespace App\Services;

use App\Helpers\DateTimeHelper;
use App\Models\OrderCancel;
use App\Models\SettingOfDay;
use App\Repositories\Eloquents\EmployeeBranchRepository;
use App\Repositories\Eloquents\EmployeeDailyRepository;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\EmployeeTimeKeepingRepository;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\OrderBillRepository;
use App\Repositories\Eloquents\OrderCancelRepository;
use App\Repositories\Eloquents\OrderCheckInRepository;
use App\Repositories\Eloquents\OrderCheckOutRepository;
use App\Repositories\Eloquents\PaymentBillRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\SaleCartSmallRepository;
use App\Repositories\Eloquents\SaleRepository;
use App\Repositories\Eloquents\SettingOfDayRepository;
use App\Repositories\Eloquents\StockDailyRepository;
use App\Repositories\Eloquents\SupplierRepository;
use App\Repositories\Eloquents\UnitRepository;
use Symfony\Component\Mime\Header\DateHeader;

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
    protected $employeeBranchRepository;
    protected $employeeDailyRepository;
    protected $employeeTimeKeepingRepository;
    protected $paymentBillRepository;
    protected $supplierRepository;
    protected $settingOfDayRepository;
    protected $saleCartSmallRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, UnitRepository $unitRepository,
                OrderCheckInRepository $orderCheckInRepository, OrderCheckOutRepository $orderCheckOutRepository, OrderCancelRepository $orderCancelRepository,
                OrderBillRepository $orderBillRepository,
                StockDailyRepository $stockDailyRepository, SaleRepository $saleRepository, ProductRepository $productRepository,
                EmployeeRepository $employeeRepository, EmployeeDailyRepository $employeeDailyRepository, EmployeeTimeKeepingRepository $employeeTimeKeepingRepository,
                PaymentBillRepository $paymentBillRepository, SupplierRepository $supplierRepository, SettingOfDayRepository $settingOfDayRepository,
                SaleCartSmallRepository $saleCartSmallRepository, EmployeeBranchRepository $employeeBranchRepository)
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
        $this->employeeBranchRepository = $employeeBranchRepository;
        $this->employeeDailyRepository = $employeeDailyRepository;
        $this->employeeTimeKeepingRepository = $employeeTimeKeepingRepository;
        $this->paymentBillRepository = $paymentBillRepository;
        $this->supplierRepository = $supplierRepository;
        $this->settingOfDayRepository = $settingOfDayRepository;
        $this->saleCartSmallRepository = $saleCartSmallRepository;
    }

    public function checkDateIsOfDay($branchId, $date){
        $weekNo = DateTimeHelper::dateToWeekNo($date);
        $dayOfWeeks = $this->settingOfDayRepository->getByKey(array('branch_id' => $branchId, 'type_day' => SettingOfDay::TYPE_OFF_WEEK, 'week_no' => $weekNo));
        if(isset($dayOfWeeks) && count($dayOfWeeks) > 0) return true;

        $dayOfs = $this->settingOfDayRepository->getByKey(array('branch_id' => $branchId,
                            'type_day' => SettingOfDay::TYPE_OFF_DAY,
                            'date_off' => DateTimeHelper::dateFormat($date,'Y-m-d')));
        if(isset($dayOfs) && count($dayOfs) > 0) return true;

        return false;
    }

}
