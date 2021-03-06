<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use App\Models\Material;
use App\Models\OrderCancel;
use App\Models\OrderCheckIn;
use App\Models\OrderCheckOut;
use App\Models\Product;
use App\Models\SettingOfDay;
use App\Models\StockDaily;
use App\Models\Supplier;
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
use App\Repositories\Eloquents\PrepareMaterialRepository;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Eloquents\RolePermissionScreenRepository;
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Eloquents\SaleCartSmallRepository;
use App\Repositories\Eloquents\SaleRepository;
use App\Repositories\Eloquents\ScreenRepository;
use App\Repositories\Eloquents\SettingOfDayRepository;
use App\Repositories\Eloquents\SettingRepository;
use App\Repositories\Eloquents\SmallCarLocationOfDayRepository;
use App\Repositories\Eloquents\SmallCarLocationRepository;
use App\Repositories\Eloquents\SmallCarMaterialRepository;
use App\Repositories\Eloquents\SmallCarProductRepository;
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
        SettingRepository $settingRepository,
        FinanceRepository $financeRepository,
        BranchRepository $branchRepository,
        PrepareMaterialRepository $prepareMaterialRepository,
        SmallCarLocationRepository $smallCarLocationRepository,
        SmallCarProductRepository $smallCarProductRepository,
        SmallCarMaterialRepository $smallCarMaterialRepository,
        SmallCarLocationOfDayRepository $smallCarLocationOfDayRepository,
        TimeKeepingService $timeKeepingService
    ) {
        parent::__construct($materialRepository, $materialTypeRepository, $unitRepository, $orderCheckInRepository,
            $orderCheckOutRepository, $orderCancelRepository, $orderBillRepository, $stockDailyRepository,
            $saleRepository, $productRepository, $employeeRepository, $employeeDailyRepository,
            $employeeTimeKeepingRepository, $paymentBillRepository, $supplierRepository, $settingOfDayRepository,
            $saleCartSmallRepository, $employeeBranchRepository, $assignEmployeeSaleCartSmallRepository,
            $roleRepository, $screenRepository, $rolePermissionScreenRepository, $userRepository, $userBranchRepository,
            $userRoleRepository, $settingRepository, $financeRepository, $branchRepository, $prepareMaterialRepository,
            $smallCarLocationRepository, $smallCarProductRepository, $smallCarMaterialRepository,
            $smallCarLocationOfDayRepository);
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
                    $amountIn = $qtyIn * $inputPrice;
                    $valueUpdatePrice = array('qty'=> $qtyIn,'price' => $inputPrice, 'amount' => $amountIn);
                    $wheres = array_merge($wheres,['check_in_date' => $dailyDate, 'order_check_in_type' => OrderCheckIn::CHECK_IN_TYPE]);
                    $this->orderCheckInRepository->updateOrCreate($valueUpdatePrice,$wheres);
                    $resultQty = array_merge($resultQty,['amount_in' =>  AppHelper::formatMoney($amountIn),
                        'price' => $inputPrice,
                        'price_str' => AppHelper::formatMoney($inputPrice)
                        ]);
                    break;
                case 'qty_in':
                    $material = $this->materialRepository->find($materialId);
                    if(isset($material)){
                        $wheres = array_merge($wheres,['check_in_date' => $dailyDate, 'order_check_in_type' => OrderCheckIn::CHECK_IN_TYPE]);
                        $this->orderCheckInRepository->updateOrCreate($valueUpdate,$wheres);
                        $resultQty = array_merge($resultQty,['amount_in' => AppHelper::formatMoney($valueUpdate['amount'])]);
                    }
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
                        $arrayValue = array_merge($values,[
                            'date' => $lastDay,
                            'name' => 'qty_first',
                        ]);
                        $this->updateInputDaily($arrayValue, false);

                        $wheres = array_merge($wheres,['stock_date' => $dailyDate]);
                        $this->stockDailyRepository->updateOrCreate($valueUpdate,$wheres);
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
            $totalAmountCheckIn = $this->orderCheckInRepository->getTotalAmountByDate($branchId,$dailyDate, OrderCheckIn::CHECK_IN_TYPE);
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
                if(isset($checkOut->id)){
                    $checkOut['qty'] = $checkOut->qty - $stockDailyFirst->qty + $inputValue;
                }
                break;
            case 'qty_last':
                $checkOut['qty'] = $checkOut->qty + $stockDaily->qty - $inputValue;
                break;
        }
        if($inputName != 'qty_first' ||  isset($checkOut->id)){
            $checkOut->amount = $checkOut->qty * $checkOut->price;
            $this->orderCheckOutRepository->updateModel($checkOut);
            //update Sale
            if($materialId < 5 && $inputName != 'price'){
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
                    $totalAmount = $this->saleRepository->sumAmountSale($branchId,$dailyDate);
                    $totalQty = $this->saleRepository->sumQtySale($branchId,$dailyDate);
                    $orderBill = $this->orderBillRepository->findByKey(array('bill_date' => $dailyDate,'branch_id' => $branchId));
                    $realAmount = 0;
                    if(isset($orderBill)){
                        $realAmount = $orderBill->real_amount;
                    }
                    $this->orderBillRepository->updateOrCreate(array('total_amount' => $totalAmount,'lack_amount' => $totalAmount - $realAmount),array('bill_date' => $dailyDate,'branch_id' => $branchId));
                    $resultQty['total_amount'] = AppHelper::formatMoney($totalAmount);
                    $resultQty['total_qty'] = AppHelper::formatMoney($totalQty);
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
                $whereValues = array('branch_id' => $branchId,'sale_date' => $dailyDate, 'product_id' => $productId);
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
                $totalQty = $this->saleRepository->sumQtySale($branchId,$dailyDate);
                $orderBill = $this->orderBillRepository->findByKey(array('bill_date' => $dailyDate,'branch_id' => $branchId));
                $realAmount = 0;
                if(isset($orderBill)){
                    $realAmount = $orderBill->real_amount;
                }
                $this->orderBillRepository->updateOrCreate(array('total_amount' => $totalAmount,'lack_amount' => $totalAmount - $realAmount),array('bill_date' => $dailyDate,'branch_id' => $branchId));

                $resultQty['total_amount'] = AppHelper::formatMoney($totalAmount);
                $resultQty['total_qty'] = AppHelper::formatMoney($totalQty);
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
                $sumTotal = $this->employeeDailyRepository->sumTotalDaily($branchId,$dailyDate);
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
                $values['branch_id'] = $branchId;
                $this->timeKeepingService->updateTimeKeeping($values, false);
            }
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
        return $resultQty;
    }

    public function updateOfDay($branchId,$date){
        if(!is_string($date)){
            $date = DateTimeHelper::dateFormat($date,'Y-m-d');
        }
        try{
            DB::beginTransaction();
            $this->settingOfDayRepository->updateOrCreate(['note' => 'Nghĩ không bán'],array(
                'branch_id' => $branchId,
                'type_day' => SettingOfDay::TYPE_OFF_DAY,
                'date_off' => $date
            ));
            $firstDay =  DateTimeHelper::addDay($date,-1,'Y-m-d');
            $stockDailyLasts = $this->stockDailyRepository->getByKey(['branch_id' => $branchId, 'stock_date' => $firstDay]);

            foreach ($stockDailyLasts as $stockDaily){
                $this->stockDailyRepository->updateOrCreate(
                    [
                        'qty' => $stockDaily->qty,
                        'price' => $stockDaily->price,
                        'amount' => $stockDaily->amount
                    ],
                    [
                        'branch_id' => $branchId,
                        'stock_date' => $date,
                        'material_id' => $stockDaily->material_id
                    ]
                );
            }

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }

    public function getPrepareMaterial($branchId, $date){
        $materialIds = [11,12,13,16];
        $materials = $this->materialRepository->getPrepareMaterial($materialIds);
        $branches = $this->branchRepository->selectAll();

        $settingBranches = $this->settingRepository->selectAll();
        $branchIds = ArrayHelper::toArrayListObject($branches,'id');
        $mapSettingBranch = ArrayHelper::parseListObjectToArrayKey($settingBranches,'branch_id');

        $productPrepareMaterials = $this->productRepository->getProductPrepareMaterial($branchIds,$date);

        $mapProductPrepareMaterial = ArrayHelper::parseListObjectToArrayKey($productPrepareMaterials,['branch_id','product_id']);
        $products = $this->productRepository->selectAll();
        foreach ($products as $product){
            $totalQtyPrepare = 0;
            $totalQtyCheckOut = 0;
            $itemPrepareMaterials = [];
            foreach ($branches as $branch){
                $key = $branch->id . '_' . $product->id;
                $itemPrepareMaterial = new \stdClass();
                $itemPrepareMaterial->branch_id = $branch->id;
                if(isset($mapProductPrepareMaterial[$key])){
                    $productPrepareMaterial = $mapProductPrepareMaterial[$key];
                    if(isset($productPrepareMaterial->qty_prepare)){
                        $itemPrepareMaterial->qty_prepare = isset($productPrepareMaterial->qty_prepare) ? $productPrepareMaterial->qty_prepare : $productPrepareMaterial->qty_out;
                    }else if($product->id == Product::PRODUCT_HAMBURGER_CHICKEN_ID){
                        $settingBranch = $mapSettingBranch[$branch->id];
                        $itemPrepareMaterial->qty_prepare = isset($settingBranch->ham_chicken_num) ? $settingBranch->ham_chicken_num : 0;
                    }else if($product->id == Product::PRODUCT_PITA_CHICKEN_ID){
                        $settingBranch = $mapSettingBranch[$branch->id];
                        $itemPrepareMaterial->qty_prepare = isset($settingBranch->pita_chicken_num) ? $settingBranch->pita_chicken_num : 0;
                    }else{
                        $itemPrepareMaterial->qty_prepare = isset($productPrepareMaterial->qty_prepare) ? $productPrepareMaterial->qty_prepare : $productPrepareMaterial->qty_out;
                    }
                    $itemPrepareMaterial->qty_check_out = $productPrepareMaterial->qty_out;
                }else{
                    $itemPrepareMaterial->qty_prepare = 0;
                    $itemPrepareMaterial->qty_check_out = 0;
                }
                $totalQtyPrepare+= $itemPrepareMaterial->qty_prepare;
                $totalQtyCheckOut+= $itemPrepareMaterial->qty_check_out;
                $itemPrepareMaterials[$branch->id] = $itemPrepareMaterial;
            }
            $product->prepare_materials = $itemPrepareMaterials;
            $product->total_qty_prepare = $totalQtyPrepare;
            $product->total_qty_check_out = $totalQtyCheckOut;
        }

        $mapProduct = ArrayHelper::parseListObjectToArrayKey($products,'id');
        $mapTotalQtyMaterial = [
            Material::MATERIAL_CHICKEN_ID => [Product::PRODUCT_HAMBURGER_CHICKEN_ID,Product::PRODUCT_PITA_CHICKEN_ID],
            Material::MATERIAL_MEAT_ID => [Product::PRODUCT_HAMBURGER_ID,Product::PRODUCT_PITA_ID],
            Material::MATERIAL_EGG_ID => [Product::PRODUCT_HAMBURGER_ID,Product::PRODUCT_SANDWICH_ID,Product::PRODUCT_PITA_ID],
            Material::MATERIAL_SAUSAGE_ID => [Product::PRODUCT_HOT_DOG_ID]
        ];
        $mapTotalQtyChicken= [];
        foreach ($materials as $material){
            $itemPrepareMaterials = [];
            $productIds = $mapTotalQtyMaterial[$material->id];
            $totalBranchQty = 0;
            $material->prepare_qty_ham =  0;
            $material->prepare_qty_pita = 0;
            $material->prepare_qty_sandwich = 0;
            $material->prepare_qty_total = 0;
            foreach ($branches as $branch){
                $item = new \StdClass();
                $item->branch_id = $branch->id;
                $item->branch_name = $branch->branch_name;
                $totalQty = 0;
                $totalQtyHam = 0;
                $totalQtyPita = 0;
                $totalQtySandwich= 0;
                foreach ($productIds as $productId) {
                    $product = $mapProduct[$productId];

                    if (isset($product->prepare_materials[$branch->id])) {
                        $totalQty += $product->prepare_materials[$branch->id]->qty_prepare;
                        switch ($productId){
                            case Product::PRODUCT_HAMBURGER_ID:
                                $totalQtyHam+= $product->prepare_materials[$branch->id]->qty_prepare;
                            break;
                            case Product::PRODUCT_PITA_ID:
                                $totalQtyPita+= $product->prepare_materials[$branch->id]->qty_prepare;
                                break;
                            case Product::PRODUCT_SANDWICH_ID:
                                $totalQtySandwich+= $product->prepare_materials[$branch->id]->qty_prepare;
                                break;
                        }
                    }
                }
                if($material->id == Material::MATERIAL_CHICKEN_ID){
                    $mapTotalQtyChicken[$branch->id] = $totalQty;
                }

                if($material->id == Material::MATERIAL_MEAT_ID && isset($mapTotalQtyChicken[$branch->id])){
                    $totalQty-= $mapTotalQtyChicken[$branch->id];
                }
                if($material->id == Material::MATERIAL_EGG_ID){
                    $item->total_qty_hàm = $totalQtyHam;
                    $item->total_qty_pita = $totalQtyPita;
                    $item->total_qty_sandwich = $totalQtySandwich;

                    $item->prepare_qty_ham =  round($totalQtyHam/2);
                    $item->prepare_qty_pita = round($totalQtyPita/2);
                    $item->prepare_qty_sandwich = round(($totalQtySandwich/2) / 2);
                    $item->prepare_qty_total = $item->prepare_qty_ham + $item->prepare_qty_pita + $item->prepare_qty_sandwich;

                    $material->prepare_qty_ham+=  $item->prepare_qty_ham;
                    $material->prepare_qty_pita+= $item->prepare_qty_pita;
                    $material->prepare_qty_sandwich+= $item->prepare_qty_sandwich;
                    $material->prepare_qty_total+= $item->prepare_qty_total;

                }

                $item->qty_material = $totalQty;
                $itemPrepareMaterials[$branch->id] = $item;
                $totalBranchQty+= $totalQty;
            }
            $material->prepare_materials = $itemPrepareMaterials;
            $material->total_qty_material = $totalBranchQty;
            $material->total_part_qty_material_ = 0;
            $material->total_part_qty_material_remainder = 0;
            switch ($material->id){
                case Material::MATERIAL_CHICKEN_ID:
                    $material->total_part_qty_material = (int)$totalBranchQty/5;
                    $material->total_part_qty_material_remainder = (int)$totalBranchQty%5;
                    break;
                case Material::MATERIAL_MEAT_ID:
                    $material->total_part_qty_material = (int)($totalBranchQty/15);
                    $material->total_part_qty_material_remainder = (int)$totalBranchQty%15;
                    break;
                case Material::MATERIAL_SAUSAGE_ID:
                    $material->total_part_qty_material = (int)($totalBranchQty/13);
                    $material->total_part_qty_material_remainder = (int)$totalBranchQty%13;
                    break;
            }
        }
        $result['materials'] = $materials;
        $result['branches'] = $branches;
        $result['products'] = $products;
        return $result;
    }

    public function updatePrepareMaterial($values){
        $branchId = $values['branch_id'];
        $date = $values['last_date'];
        $productId = $values['product_id'];
        $inputName = $values['name'];
        $inputValue = $values['value'];
        if(!is_string($date)){
            $date = DateTimeHelper::dateFormat($date,'Y-m-d');
        }
        try {
            DB::beginTransaction();
            $wheres = [
                'branch_id' => $branchId,
                'date_daily' => $date,
                'product_id' => $productId
            ];
            $valueUpdates = [
                'qty' => $inputValue
            ];
            $this->prepareMaterialRepository->updateOrCreate($valueUpdates,$wheres);
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }
}
