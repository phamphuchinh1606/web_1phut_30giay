<?php
namespace App\Services;

use App\Helpers\AppHelper;
use App\Helpers\DateTimeHelper;
use App\Models\OrderCancel;
use App\Models\OrderCheckIn;
use App\Models\OrderCheckOut;
use App\Models\StockDaily;
use Illuminate\Support\Facades\DB;

class MaterialService extends BaseService {

    public function loadDataFormInput(){
        $materialTypes = $this->materialTypeRepository->selectAll();
        $materials = $this->materialRepository->selectAll();
        dd($materials);
    }

    public function updateInputDaily($values){
        $inputName = $values['name'];
        $inputValue = $values['value'];
        $inputPrice = $values['price'];
        $dailyDate = $values['date'];
        $materialId = $values['material_id'];
        $valueUpdate = array('qty' => $inputValue, 'price' => $inputPrice, 'amount' => $inputValue*$inputPrice);
        $wheres = array(
            'material_id' => $materialId,
            'branch_id' => 1
        );
        try{
            DB::beginTransaction();
            $resultQty = $this->calculatorStock(1,$dailyDate,$materialId,$inputName,$inputValue);
            switch ($inputName){
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
                case 'qty_last':
                    $wheres = array_merge($wheres,['stock_date' => $dailyDate]);
                    $this->stockDailyRepository->updateOrCreate($valueUpdate,$wheres);
                    break;
            }
            $resultQty = array_merge($resultQty,[$inputName => $inputValue]);
            DB::commit();
            return $resultQty;
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
        return [];
    }

    private function calculatorStock($branchId, $dailyDate,$materialId, $inputName, $inputValue){
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
        $resultQty = array();
        if(!isset($checkOut)){
            $checkOut = new OrderCheckOut();
            $checkOut->branch_id = $branchId;
            $checkOut->material_id = $materialId;
            $checkOut->check_out_date = $dailyDate;
            $checkOut->order_check_out_type = OrderCheckOut::CHECK_OUT_TYPE;
            $checkOut->qty = 0;
            $checkOut->price = 0;
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
            case 'qty_last':
                $checkOut['qty'] = $checkOut->qty + $stockDaily->qty - $inputValue;
                break;
        }
        $checkOut->amount = $checkOut->qty * $checkOut->price;
        $this->orderCheckOutRepository->updateModel($checkOut);
        //update Sale
        if($materialId < 5){
            $product = $this->productRepository->find($materialId);
            if(isset($product)){
                $productTheSame = $this->productRepository->findByKey(array('product_the_same_id' => $product->id));
                $productTheSameQty = 0;
                if(isset($productTheSame)) {
                    $saleTheSame = $this->saleRepository->findByKey(array('branch_id' => 1,'sale_date' => $dailyDate, 'product_id' => $productTheSame->id));
                    if(isset($saleTheSame)) $productTheSameQty = $saleTheSame->qty;
                }
                $whereValues = array('branch_id' => 1,'sale_date' => $dailyDate, 'product_id' => $materialId);
                $qtyProduct = ($checkOut->qty / $product->part_num) - $productTheSameQty;
                $valueUpdate = array('qty' => $qtyProduct, 'price' => $product->price, 'amount' => $qtyProduct * $product->price);
                $this->saleRepository->updateOrCreate($valueUpdate,$whereValues);
                $resultQty['product_id'] = $product->id;
                $resultQty['product_qty'] = $qtyProduct;
                $resultQty['product_amount'] = AppHelper::formatMoney($qtyProduct * $product->price);

                //Update Bill Order
                $totalAmount = $this->saleRepository->sumAmountSale(1,$dailyDate);
                $orderBill = $this->orderBillRepository->findByKey(array('bill_date' => $dailyDate,'branch_id' => 1));
                $realAmount = 0;
                if(isset($orderBill)){
                    $realAmount = $orderBill->real_amount;
                }
                $this->orderBillRepository->updateOrCreate(array('total_amount' => $totalAmount,'lack_amount' => $totalAmount - $realAmount),array('bill_date' => $dailyDate,'branch_id' => 1));
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
        return $resultQty;
    }

    public function updateSale($values){
        $inputValue = $values['value'];
        $productId = $values['product_id'];
        $dailyDate = $values['date'];
        $productTheSameId = $values['product_the_same_id'];
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
                    $whereValues = array('branch_id' => 1,'sale_date' => $dailyDate, 'product_id' => $productTheSameId);
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

                $whereValues = array('branch_id' => 1,'sale_date' => $dailyDate, 'product_id' => $productId);
                $valueUpdate = array('qty' => $inputValue, 'price' => $product->price, 'amount' => $inputValue*$product->price);
                $this->saleRepository->updateOrCreate($valueUpdate,$whereValues);

                //Update bill order
                $totalAmount = $this->saleRepository->sumAmountSale(1,$dailyDate);
                $orderBill = $this->orderBillRepository->findByKey(array('bill_date' => $dailyDate,'branch_id' => 1));
                $realAmount = 0;
                if(isset($orderBill)){
                    $realAmount = $orderBill->real_amount;
                }
                $this->orderBillRepository->updateOrCreate(array('total_amount' => $totalAmount,'lack_amount' => $totalAmount - $realAmount),array('bill_date' => $dailyDate,'branch_id' => 1));

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
        $resultQty = [];
        try{
            DB::beginTransaction();
            $orderBill = $this->orderBillRepository->findByKey(array('bill_date' => $dailyDate,'branch_id' => 1));
            if(isset($orderBill)){
                $orderBill->real_amount = $inputValue;
                $orderBill['lack_amount'] = ($orderBill->total_amount - $inputValue);
                $this->orderBillRepository->updateModel($orderBill);
                $resultQty['lack_amount'] = AppHelper::formatMoney($orderBill->lack_amount);
            }else{
                $this->orderBillRepository->create(array('bill_date' => $dailyDate,'branch_id' => 1,'total_amount' => 0,'real_amount' => $inputValue, 'lack_amount' => -1*$inputValue));
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
        $resultQty = [];
        try{
            DB::beginTransaction();
            $whereValues = array('date_daily' => $dailyDate,'branch_id' => 1,'employee_id' => $employeeId);
            $valueUpdate = array($inputName => $inputValue);
            $employeeDaily = $this->employeeDailyRepository->updateOrCreate($valueUpdate,$whereValues);
            $resultQty['total_hour'] = $employeeDaily->first_hours + $employeeDaily->last_hours;
            DB::commit();
        }catch (\Exception $ex){
            DB::rollBack();
            dd($ex);
        }
        return $resultQty;
    }
}
