<?php
namespace App\Services;

use App\Models\OrderCheckIn;
use App\Models\OrderCheckOut;

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
        $valueUpdate = array('qty' => $inputValue);
        $wheres = array(
            'material_id' => $materialId
        );
        switch ($inputName){
            case 'qty_in':
                $wheres = array_merge($wheres,['branch_id' => 1,'check_in_date' => $dailyDate, 'order_check_in_type' => OrderCheckIn::CHECK_IN_TYPE]);
                $valueUpdate = array_merge($valueUpdate,['price' => $inputPrice, 'amount' => $inputValue*$inputPrice]);
                $this->orderCheckInRepository->updateOrCreate($valueUpdate,$wheres);
                break;
            case 'qty_in_move':
                $wheres = array_merge($wheres,['branch_id' => 1,'check_in_date' => $dailyDate, 'order_check_in_type' => OrderCheckIn::MOVE_IN_TYPE]);
                $valueUpdate = array_merge($valueUpdate,['price' => $inputPrice, 'amount' => $inputValue*$inputPrice]);
                $this->orderCheckInRepository->updateOrCreate($valueUpdate,$wheres);
                break;
            case 'qty_out':
                $wheres = array_merge($wheres,['branch_id' => 1,'check_out_date' => $dailyDate, 'order_check_out_type' => OrderCheckOut::CHECK_OUT_TYPE]);
                $valueUpdate = array_merge($valueUpdate,['price' => $inputPrice, 'amount' => $inputValue*$inputPrice]);
                $this->orderCheckOutRepository->updateOrCreate($valueUpdate,$wheres);
                break;
            case 'qty_out_move':
                $wheres = array_merge($wheres,['branch_id' => 1,'check_out_date' => $dailyDate, 'order_check_out_type' => OrderCheckOut::MOVE_OUT_TYPE]);
                $valueUpdate = array_merge($valueUpdate,['price' => $inputPrice, 'amount' => $inputValue*$inputPrice]);
                $this->orderCheckOutRepository->updateOrCreate($valueUpdate,$wheres);
                break;
            case 'qty_cancel':
                $wheres = array_merge($wheres,['branch_id' => 1,'cancel_date' => $dailyDate]);
                $valueUpdate = array_merge($valueUpdate,['price' => $inputPrice, 'amount' => $inputValue*$inputPrice]);
                $this->orderCancelRepository->updateOrCreate($valueUpdate,$wheres);
                break;
            case 'qty_last':
                $wheres = array_merge($wheres,['branch_id' => 1,'stock_date' => $dailyDate]);
                $valueUpdate = array_merge($valueUpdate,['price' => $inputPrice, 'amount' => $inputValue*$inputPrice]);
                $this->stockDailyRepository->updateOrCreate($valueUpdate,$wheres);
                break;
                break;
        }
        dd('dung');
    }

    private function calculatorStock($branchId, $dailyDate,$materialId, $inputName){
        $checkIn = $this->orderCheckInRepository->find();
    }

}
