<?php
namespace App\Services;

use App\Helpers\DateTimeHelper;
use App\Models\AssignEmployeeSaleCartSmall;
use App\Models\OrderCancel;
use App\Models\SettingOfDay;
use App\Repositories\Eloquents\AssignEmployeeSaleCartSmallRepository;
use App\Repositories\Eloquents\BranchRepository;
use App\Repositories\Eloquents\EmployeeBranchRepository;
use App\Repositories\Eloquents\EmployeeDailyRepository;
use App\Repositories\Eloquents\EmployeeRepository;
use App\Repositories\Eloquents\EmployeeTimeKeepingRepository;
use App\Repositories\Eloquents\FinanceRepository;
use App\Repositories\Eloquents\MaterialRepository;
use App\Repositories\Eloquents\MaterialTypeRepository;
use App\Repositories\Eloquents\OrderBillRepository;
use App\Repositories\Eloquents\OrderCancelRepository;
use App\Repositories\Eloquents\OrderCheckInRepository;
use App\Repositories\Eloquents\OrderCheckOutRepository;
use App\Repositories\Eloquents\PaymentBillRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\RolePermissionScreenRepository;
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Eloquents\SaleCartSmallRepository;
use App\Repositories\Eloquents\SaleRepository;
use App\Repositories\Eloquents\ScreenRepository;
use App\Repositories\Eloquents\SettingOfDayRepository;
use App\Repositories\Eloquents\SettingRepository;
use App\Repositories\Eloquents\StockDailyRepository;
use App\Repositories\Eloquents\SupplierRepository;
use App\Repositories\Eloquents\UnitRepository;
use App\Repositories\Eloquents\UserBranchRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\UserRoleRepository;
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
    protected $assignEmployeeSaleCartSmallRepository;
    protected $roleRepository;
    protected $screenRepository;
    protected $rolePermissionScreenRepository;
    protected $userRepository;
    protected $userBranchRepository;
    protected $userRoleRepository;
    protected $settingRepository;
    protected $financeRepository;
    protected $branchRepository;

    public function __construct(MaterialRepository $materialRepository, MaterialTypeRepository $materialTypeRepository, UnitRepository $unitRepository,
                OrderCheckInRepository $orderCheckInRepository, OrderCheckOutRepository $orderCheckOutRepository, OrderCancelRepository $orderCancelRepository,
                OrderBillRepository $orderBillRepository,
                StockDailyRepository $stockDailyRepository, SaleRepository $saleRepository, ProductRepository $productRepository,
                EmployeeRepository $employeeRepository, EmployeeDailyRepository $employeeDailyRepository, EmployeeTimeKeepingRepository $employeeTimeKeepingRepository,
                PaymentBillRepository $paymentBillRepository, SupplierRepository $supplierRepository, SettingOfDayRepository $settingOfDayRepository,
                SaleCartSmallRepository $saleCartSmallRepository, EmployeeBranchRepository $employeeBranchRepository,
                AssignEmployeeSaleCartSmallRepository $assignEmployeeSaleCartSmallRepository, RoleRepository $roleRepository ,ScreenRepository $screenRepository,
                RolePermissionScreenRepository $rolePermissionScreenRepository, UserRepository $userRepository, UserBranchRepository $userBranchRepository,
                UserRoleRepository $userRoleRepository, SettingRepository $settingRepository, FinanceRepository $financeRepository, BranchRepository $branchRepository)
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
        $this->assignEmployeeSaleCartSmallRepository = $assignEmployeeSaleCartSmallRepository;
        $this->roleRepository = $roleRepository;
        $this->screenRepository = $screenRepository;
        $this->rolePermissionScreenRepository = $rolePermissionScreenRepository;
        $this->userRepository = $userRepository;
        $this->userBranchRepository = $userBranchRepository;
        $this->userRoleRepository = $userRoleRepository;
        $this->settingRepository = $settingRepository;
        $this->financeRepository = $financeRepository;
        $this->branchRepository = $branchRepository;
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
