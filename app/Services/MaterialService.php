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
                $whereValues = array('sale_date' => $dailyDate, 'product_id' => $materialId);
                $valueUpdate = array('qty' => $checkOut->qty / $product->part_num, 'price' => $product->price, 'amount' => ($checkOut->qty / $product->part_num)*$product->price);
                $this->saleRepository->updateOrCreate($valueUpdate,$whereValues);
            }
        }
        $resultQty = array(
            'qty_in' => isset($checkIn->qty) ? $checkIn->qty : 0,
            'amount_in' => isset($checkIn->amount) ? AppHelper::formatMoney($checkIn->amount) : 0,
            'qty_in_move' => isset($checkInMove->qty) ? $checkInMove->qty : 0,
            'qty_out' => isset($checkOut->qty) ? $checkOut->qty : 0,
            'amount_out' => isset($checkOut->amount) ? $checkOut->amount : 0,
            'qty_out_move' => isset($checkOutMove->qty) ? $checkOutMove->qty : 0,
            'qty_cancel' => isset($orderCancel->qty) ? $orderCancel->qty : 0,
            'qty_last' => isset($stockDaily->qty) ? $stockDaily->qty : 0,
            'qty_first' => isset($stockDailyFirst->qty) ? $stockDailyFirst->qty : 0
        );
        return $resultQty;
    }

}
