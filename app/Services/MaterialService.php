<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\DateTimeHelper;
use App\Models\OrderCancel;
use App\Models\OrderCheckIn;
use App\Models\OrderCheckOut;
use App\Models\StockDaily;
use App\Repositories\Eloquents\AssignEmployeeSaleCartSmallRepository;
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
use App\Repositories\Eloquents\RolePermissionScreenRepository;
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Eloquents\SaleCartSmallRepository;
use App\Repositories\Eloquents\SaleRepository;
use App\Repositories\Eloquents\ScreenRepository;
use App\Repositories\Eloquents\SettingOfDayRepository;
use App\Repositories\Eloquents\StockDailyRepository;
use App\Repositories\Eloquents\SupplierRepository;
use App\Repositories\Eloquents\UnitRepository;
use App\Repositories\Eloquents\UserBranchRepository;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Eloquents\UserRoleRepository;
use Illuminate\Support\Facades\DB;

class MaterialService extends BaseService {

    private $timeKeepingService;

    public function __construct(
        MaterialRepository $materialRepository,
        MaterialTypeRepository $materialTypeRepository,
        UnitRepository $unitRepository,
        OrderCheckInRepository $orderCheckInRepository,
        OrderCheckOutRepository $orderCheckOutRepository,
        OrderCancelRepository $orderCancelRepository,
        OrderBillRepository $orderBillRepository,
        StockDailyRepository $stockDailyRepository,
        SaleRepository $saleRepository,
        ProductRepository $productRepository,
        EmployeeRepository $employeeRepository,
        EmployeeDailyRepository $employeeDailyRepository,
        EmployeeTimeKeepingRepository $employeeTimeKeepingRepository,
        PaymentBillRepository $paymentBillRepository,
        SupplierRepository $supplierRepository,
        SettingOfDayRepository $settingOfDayRepository,
        SaleCartSmallRepository $saleCartSmallRepository,
        EmployeeBranchRepository $employeeBranchRepository,
        AssignEmployeeSaleCartSmallRepository $assignEmployeeSaleCartSmallRepository,
        RoleRepository $roleRepository,
        ScreenRepository $screenRepository,
        RolePermissionScreenRepository $rolePermissionScreenRepository,
        UserRepository $userRepository,
        UserBranchRepository $userBranchRepository,
        UserRoleRepository $userRoleRepository,
        TimeKeepingService $timeKeepingService
    ) {
        parent::__construct($materialRepository, $materialTypeRepository, $unitRepository, $orderCheckInRepository,
            $orderCheckOutRepository, $orderCancelRepository, $orderBillRepository, $stockDailyRepository,
            $saleRepository, $productRepository, $employeeRepository, $employeeDailyRepository,
            $employeeTimeKeepingRepository, $paymentBillRepository, $supplierRepository, $settingOfDayRepository,
            $saleCartSmallRepository, $employeeBranchRepository, $assignEmployeeSaleCartSmallRepository,
            $roleRepository, $screenRepository, $rolePermissionScreenRepository, $userRepository, $userBranchRepository,
            $userRoleRepository);
        $this->timeKeepingService = $timeKeepingService;
    }

    public function loadDataFormInput(){
        $materialTypes = $this->materialTypeRepository->selectAll();
        $materials = $this->materialRepository->selectAll();
        dd($materials);
    }

    public function updateInputDaily($values, $isTransaction = true){
        $inputName = $values['name'];
        $inputValue = $values['value'];
        $inputPrice = $values['price'];
        $dailyDate = $values['date'];
        $materialId = $values['material_id'];
        $lastDay = DateTimeHelper::addDay($dailyDate,1,'Y-m-d');
        $branchId = $values['branch_id'];
        $valueUpdate = array('qty' => $inputValue, 'price' => $inputPrice, 'amount' => $inputValue*$inputPrice);
        $wheres = array(
            'material_id' => $materialId,
            'branch_id' => $branchId
        );
        try{
            if($isTransaction) DB::beginTransaction();
            $resultQty = $this->calculatorStock($branchId,$dailyDate,$materialId,$inputName,$inputValue,$inputPrice);
            switch ($inputName){
                case 'price':
                    $qtyIn = isset($values['qty_in']) && !empty($values['qty_in']) ? $values['qty_in'] : 0;
                    $valueUpdatePrice = array('qty'=> $qtyIn,'price' => $inputPrice, 'amount' => $qtyIn * $inputPrice);
                    $wheres = array_merge($wheres,['check_in_date' => $dailyDate, 'order_check_in_type' => OrderCheckIn::CHECK_IN_TYPE]);
                    $this->orderCheckInRepository->updateOrCreate($valueUpdatePrice,$wheres);
                    break;
                case 'qty_in':
                    $wheres = array_merge($wheres,['check_in_date' => $dailyDate, 'order_check_in_type' => OrderCheckIn::CHECK_IN_TYPE]);
                    $this->orderCheckInRepository->updateOrCreate($valueUpdate,$wheres);
                    $resultQty = array_merge($resultQty,['amount_in' => AppHelper::formatMoney($valueUpdate['amount'])]);
                    break;
                case 'qty_in_move':
                    $wheres = array_merge($wheres,['check_in_date' => $dailyDate, 'order_check_in_type' => OrderCheckIn::MOVE_IN_TYPE]);
                    $this->orderCheckInRepository->updateOrCreate($valueUpdate,$wheres);
                    break;
                case 'qty_out':
                    $wheres = array_merge($wheres,['check_out_date' => $dailyDate, 'order_check_out_type' => OrderCheckOut::CHECK_OUT_TYPE]);
                    $this->orderCheckOutRepository->updateOrCreate($valueUpdate,$wheres);
                    break;
                case 'qty_out_move':
                    $wheres = array_merge($wheres,['check_out_date' => $dailyDate, 'order_check_out_type' => OrderCheckOut::MOVE_OUT_TYPE]);
                    $this->orderCheckOutRepository->updateOrCreate($valueUpdate,$wheres);
                    break;
                case 'qty_cancel':
                    $wheres = array_merge($wheres,['cancel_date' => $dailyDate]);
                    $this->orderCancelRepository->updateOrCreate($valueUpdate,$wheres);
                    break;
                case 'qty_first':
                    if($this->checkDateIsOfDay($branchId,$dailyDate)){
                        if($this->checkDateIsOfDay($branchId,$lastDay)){
                            $arrayValue = array_merge($values,[
                                'date' => $lastDay,
                                'name' => 'qty_last',
                            ]);
                            $this->updateInputDaily($arrayValue, false);
                        }else{
                            $wheres = array_merge($wheres,['stock_date' => $dailyDate]);
                            $this->stockDailyRepository->updateOrCreate($valueUpdate,$wheres);
                        }
                    }
                    break;
                case 'qty_last':
                    $arrayValue = array_merge($values,[
                        'date' => $lastDay,
                        'name' => 'qty_first',
                    ]);
                    $this->updateInputDaily($arrayValue, false);

                    $wheres = array_merge($wheres,['stock_date' => $dailyDate]);
                    $this->stockDailyRepository->updateOrCreate($valueUpdate,$wheres);
                    break;
            }
            $totalAmountCheckIn = $this->orderCheckInRepository->getTotalAmountByDate($branchId,$dailyDate);
            $totalAmountCheckOut = $this->orderCheckOutRepository->getTotalAmountByDate($branchId,$dailyDate);
            $resultQty = array_merge($resultQty,[$inputName => $inputValue,
                'total_amount_check_in' => AppHelper::formatMoney($totalAmountCheckIn),
                'total_amount_check_out' => AppHelper::formatMoney($totalAmountCheckOut)]);
            if($isTransaction) DB::commit();
            return $resultQty;
        }catch (\Exception $ex){
            if($isTransaction) DB::rollBack();
            if($isTransaction) dd($ex);
            else throw $ex;
        }
        return [];
    }

    private function calculatorStock($branchId, $dailyDate,$materialId, $inputName, $inputValue,$inputPrice){
        $wheres = array(
            'branch_id' => $branchId,
            'material_id' => $materialId,
            'check_in_date' => $dailyDate,
            'check_out_date' => $dailyDate,
            'cancel_date' => $dailyDate,
            'stock_date' => $dailyDate
        );
        $yesterday = DateTimeHelper::addDay($dailyDate,-1,'Y-m-d');
        $checkIn = $this->orderCheckInRepository->findByKey(array_merge($wheres,['order_check_in_type' => OrderCheckIn::CHECK_IN_TYPE]));
        $checkInMove = $this->orderCheckInRepository->findByKey(array_merge($wheres,['order_check_in_type' => OrderCheckIn::MOVE_IN_TYPE]));
        $checkOut = $this->orderCheckOutRepository->findByKey(array_merge($wheres,['order_check_out_type' => OrderCheckOut::CHECK_OUT_TYPE]));
        $checkOutMove = $this->orderCheckOutRepository->findByKey(array_merge($wheres,['order_check_out_type' => OrderCheckOut::MOVE_OUT_TYPE]));
        $orderCancel = $this->orderCancelRepository->findByKey($wheres);
        $stockDaily = $this->stockDailyRepository->findByKey($wheres);
        $stockDailyFirst = $this->stockDailyRepository->findByKey(array_merge($wheres,['stock_date' => $yesterday]));
        if(!isset($stockDailyFirst)) {
            $stockDailyFirst = new StockDaily();
            $stockDailyFirst->qty = 0;
        }
        $resultQty = array();
        if(!isset($checkOut)){
            $checkOut = new OrderCheckOut();
            $checkOut->branch_id = $branchId;
            $checkOut->material_id = $materialId;
            $checkOut->check_out_date = $dailyDate;
            $checkOut->order_check_out_type = OrderCheckOut::CHECK_OUT_TYPE;
            $checkOut->qty = $stockDailyFirst->qty;
            $checkOut->price = $inputPrice;
        }
        if(!isset($checkIn)) {
            $checkIn = new OrderCheckIn();
            $checkIn->qty = 0;
        }
        if(!isset($checkInMove)) {
            $checkInMove = new OrderCheckIn();
            $checkInMove->qty = 0;
        }
        if(!isset($checkOutMove)) {
            $checkOutMove = new OrderCheckOut();
            $checkOutMove->qty = 0;
        }
        if(!isset($orderCancel)) {
            $orderCancel = new OrderCancel();
            $orderCancel->qty = 0;
        }
        if(!isset($stockDaily)) {
            $stockDaily = new StockDaily();
            $stockDaily->qty = 0;
        }
        switch ($inputName){
            case 'qty_in':
                $checkOut['qty'] = $checkOut->qty - $checkIn->qty + $inputValue;
                break;
            case 'qty_in_move':
                $checkOut['qty'] = $checkOut->qty - $checkInMove->qty + $inputValue;
                break;
            case 'qty_out':
                break;
            case 'qty_out_move':
                $checkOut['qty'] = $checkOut->qty + $checkOutMove->qty - $inputValue;
                break;
            case 'qty_cancel':
                $checkOut['qty'] = $checkOut->qty + $orderCancel->qty - $inputValue;
                break;
            case 'qty_first':
                if(isset($stockDaily->id)){
                    $checkOut['qty'] = $checkOut->qty - $stockDailyFirst->qty + $inputValue;
                }
                break;
            case 'qty_last':
                $checkOut['qty'] = $checkOut->qty + $stockDaily->qty - $inputValue;
                break;
        }
        if($inputName != 'qty_first' ||  isset($stockDaily->id)){
            $checkOut->amount = $checkOut->qty * $checkOut->price;
            $this->orderCheckOutRepository->updateModel($checkOut);
            //update Sale
            if($materialId < 5){
                $product = $this->productRepository->find($materialId);
                if(isset($product)){
                    $productTheSame = $this->productRepository->findByKey(array('product_the_same_id' => $product->id));
                    $productTheSameQty = 0;
                    if(isset($productTheSame)) {
                        $saleTheSame = $this->saleRepository->findByKey(array('branch_id' => $branchId,'sale_date' => $dailyDate, 'product_id' => $productTheSame->id));
                        if(isset($saleTheSame)) $productTheSameQty = $saleTheSame->qty;
                    }
                    $whereValues = array('branch_id' => $branchId,'sale_date' => $dailyDate, 'product_id' => $materialId);
                    $qtyProduct = ($checkOut->qty / $product->part_num) - $productTheSameQty;
                    $valueUpdate = array('qty' => $qtyProduct, 'price' => $product->price, 'amount' => $qtyProduct * $product->price);
                    $this->saleRepository->updateOrCreate($valueUpdate,$whereValues);
                    $resultQty['product_id'] = $product->id;
                    $resultQty['product_qty'] = $qtyProduct;
                    $resultQty['product_amount'] = AppHelper::formatMoney($qtyProduct * $product->price);

                    //Update Bill Order
                    $totalAmount = $this->saleRepository->sumAmountSale(1,$dailyDate);
                    $orderBill = $this->orderBillRepository->findByKey(array('bill_date' => $dailyDate,'branch_id' => $branchId));
                    $realAmount = 0;
                    if(isset($orderBill)){
                        $realAmount = $orderBill->real_amount;
                    }
                    $this->orderBillRepository->updateOrCreate(array('total_amount' => $totalAmount,'lack_amount' => $totalAmount - $realAmount),array('bill_date' => $dailyDate,'branch_id' => $branchId));
                    $resultQty['total_amount'] = AppHelper::formatMoney($totalAmount);
                    $resultQty['lack_amount'] = AppHelper::formatMoney($totalAmount - $realAmount);
                }
            }
            $resultQty = array_merge($resultQty,array(
                'qty_in' => isset($checkIn->qty) ? $checkIn->qty : 0,
                'amount_in' => isset($checkIn->amount) ? AppHelper::formatMoney($checkIn->amount) : 0,
                'qty_in_move' => isset($checkInMove->qty) ? $checkInMove->qty : 0,
                'qty_out' => isset($checkOut->qty) ? $checkOut->qty : 0,
                'amount_out' => isset($checkOut->amount) ? $checkOut->amount : 0,
                'qty_out_move' => isset($checkOutMove->qty) ? $checkOutMove->qty : 0,
                'qty_cancel' => isset($orderCancel->qty) ? $orderCancel->qty : 0,
                'qty_last' => isset($stockDaily->qty) ? $stockDaily->qty : 0,
                'qty_first' => isset($stockDailyFirst->qty) ? $stockDailyFirst->qty : 0
            ));
        }
        return $resultQty;
    }

    public function updateSale($values){
        $inputValue = $values['value'];
        $productId = $values['product_id'];
        $dailyDate = $values['date'];
        $productTheSameId = $values['product_the_same_id'];
        $branchId = $values['branch_id'];
        $product = $this->productRepository->find($productId);
        $resultQty = [];
        if(isset($product)){
            try{
                DB::beginTransaction();
                $whereValues = array('sale_date' => $dailyDate, 'product_id' => $productId);
                $saleItem = $this->saleRepository->findByKey($whereValues);
                if(!isset($saleItem)){
                    $saleItem = new \StdClass();
                    $saleItem->qty = 0;
                }
                $productTheSame = $this->productRepository->find($productTheSameId);
                if(isset($productTheSame)){
                    $whereValues = array('branch_id' => $branchId,'sale_date' => $dailyDate, 'product_id' => $productTheSameId);
                    $saleTheSame = $this->saleRepository->findByKey($whereValues);
                    if(isset($saleTheSame)){
                        $saleTheSame->qty = $saleTheSame->qty + $saleItem->qty - $inputValue;
                        $saleTheSame->amount = $saleTheSame->qty * $saleTheSame->price;
                        $this->saleRepository->updateModel($saleTheSame);
                        $resultQty['product_the_same_qty'] = $saleTheSame->qty;
                        $resultQty['product_the_same_amount'] = AppHelper::formatMoney($saleTheSame->amount);
                    }else{
                        $valueUpdate = array('qty' => -1*$inputValue, 'price' => $productTheSame->price, 'amount' => -1*$inputValue*$productTheSame->price);
                        $this->saleRepository->updateOrCreate($valueUpdate,$whereValues);
                        $resultQty['product_the_same_qty'] = -1*$inputValue;
                        $resultQty['product_the_same_amount'] = AppHelper::formatMoney(-1*$inputValue*$productTheSame->price);
                    }
                }

                $whereValues = array('branch_id' => $branchId,'sale_date' => $dailyDate, 'product_id' => $productId);
                $valueUpdate = array('qty' => $inputValue, 'price' => $product->price, 'amount' => $inputValue*$product->price);
                $this->saleRepository->updateOrCreate($valueUpdate,$whereValues);

                //Update bill order
                $totalAmount = $this->saleRepository->sumAmountSale($branchId,$dailyDate);
                $orderBill = $this->orderBillRepository->findByKey(array('bill_date' => $dailyDate,'branch_id' => $branchId));
                $realAmount = 0;
                if(isset($orderBill)){
                    $realAmount = $orderBill->real_amount;
                }
                $this->orderBillRepository->updateOrCreate(array('total_amount' => $totalAmount,'lack_amount' => $totalAmount - $realAmount),array('bill_date' => $dailyDate,'branch_id' => $branchId));

                $resultQty['total_amount'] = AppHelper::formatMoney($totalAmount);
                $resultQty['lack_amount'] = AppHelper::formatMoney($totalAmount - $realAmount);

                $resultQty['product_the_same_id'] = $productTheSameId;
                $resultQty['product_amount'] = AppHelper::formatMoney($inputValue*$product->price);
                DB::commit();
            }catch (\Exception $ex){
                DB::rollBack();
                dd($ex);
            }
        }
        return $resultQty;
    }

    public function updateBill($values){
        $inputValue = $values['value'];
        $dailyDate = $values['date'];
        $branchId = $values['branch_id'];
        $resultQty = [];
        try{
            DB::beginTransaction();
            $orderBill = $this->orderBillRepository->findByKey(array('bill_date' => $dailyDate,'branch_id' => $branchId));
            if(isset($orderBill)){
                $orderBill->real_amount = $inputValue;
                $orderBill['lack_amount'] = ($orderBill->total_amount - $inputValue);
                $this->orderBillRepository->updateModel($orderBill);
                $resultQty['lack_amount'] = AppHelper::formatMoney($orderBill->lack_amount);
            }else{
                $this->orderBillRepository->create(array('bill_date' => $dailyDate,'branch_id' => $branchId,'total_amount' => 0,'real_amount' => $inputValue, 'lack_amount' => -1*$inputValue));
                $resultQty['lack_amount'] = AppHelper::formatMoney(-1*$inputValue);
            }
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
        return $resultQty;
    }

    public function updateEmployee($values){
        $inputValue = $values['value'];
        $inputName = $values['name'];
        $dailyDate = $values['date'];
        $employeeId = $values['employee_id'];
        $branchId = $values['branch_id'];
        $resultQty = [];
        try{
            DB::beginTransaction();
            $employee = $this->employeeRepository->find($employeeId);
            if(isset($employee)){
                $whereValues = array('date_daily' => $dailyDate,'branch_id' => $branchId,'employee_id' => $employeeId);
                $valueUpdate = array($inputName => $inputValue,'price_first_hour' => $employee->price_first_hour,'price_last_hour' => $employee->price_first_hour);
                $this->employeeDailyRepository->updateOrCreate($valueUpdate,$whereValues);
                $sumTotal = $this->employeeDailyRepository->sumTotalDaily(1,$dailyDate);
                $sumTotalEmployee = $this->employeeDailyRepository->sumTotalAmountEmployeeDaily($branchId,$dailyDate,$employeeId);
                $resultQty = array_merge($resultQty,array(
                    'total_first_hour' => $sumTotal->first_hours_total,
                    'total_last_hour' => $sumTotal->last_hours_total,
                    'total_first_amount' => AppHelper::formatMoney($sumTotal->amount_first_total),
                    'total_last_amount' => AppHelper::formatMoney($sumTotal->amount_last_total),
                    'total_hour' => AppHelper::formatMoney($sumTotal->first_hours_total + $sumTotal->last_hours_total),
                    'total_amount' => AppHelper::formatMoney($sumTotal->amount_first_total + $sumTotal->amount_last_total),
                    'total_amount_employee' => AppHelper::formatMoney($sumTotalEmployee->total_amount_employee)
                ));
                $values = [];
                $values['month'] = DateTimeHelper::dateFormat($dailyDate,'Y-m');
                $values['employee_id'] = $employeeId;
                $this->timeKeepingService->updateTimeKeeping($values, false);
            }
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
        return $resultQty;
    }
}
