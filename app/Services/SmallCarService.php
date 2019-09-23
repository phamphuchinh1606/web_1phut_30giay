<?php
namespace App\Services;

use App\Common\Constant;
use App\Helpers\AppHelper;
use App\Helpers\ArrayHelper;
use App\Helpers\DateTimeHelper;
use App\Models\BaseModel;
use App\Models\Material;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SmallCarService extends BaseService {

    public function getSmallCarLocationFull($branchId, $date = null){
        $smallCarLocations = $this->smallCarLocationRepository->selectAllIsShow($date);
        $totalQtyPepsi = 0;
        $totalQtyCocoa = 0;
        $totalQtyMilkTea = 0;
        foreach ($smallCarLocations as $smallCarLocation){
            $smallCarLocation->products = $this->smallCarProductRepository->getSmallCarProduct($branchId, $smallCarLocation->id);
            $totalQtyProduct = 0;
            foreach ($smallCarLocation->products as $product){
                $totalQtyProduct+= $product->total_qty;
            }
            $smallCarLocation->total_qty_product = $totalQtyProduct;

            $smallCarLocation->materials = $this->smallCarMaterialRepository->getSmallCarMaterial($branchId, $smallCarLocation->id);
            $totalQtyMaterial = 0;
            foreach ($smallCarLocation->materials as $material){
                $totalQtyMaterial+= $material->qty;
                switch ($material->id){
                    case Material::MATERIAL_PEPSI_ID:
                        $totalQtyPepsi+= $material->qty;
                        break;
                    case Material::MATERIAL_COCOA_ID:
                        $totalQtyCocoa+= $material->qty;
                        break;
                    case Material::MATERIAL_MILK_TEA:
                        $totalQtyMilkTea+= $material->qty;
                        break;
                }
            }
            $smallCarLocation->total_qty_material = $totalQtyMaterial;
        }
        $result['total_qty_pepsi'] = $totalQtyPepsi;
        $result['total_qty_cocoa'] = $totalQtyCocoa;
        $result['total_qty_milk_tea'] = $totalQtyMilkTea;
        $result['total_qty_material'] = $totalQtyPepsi + $totalQtyCocoa + $totalQtyMilkTea;
        $result['small_car_locations'] = $smallCarLocations;
        return $result;
    }

    public function createSmallCarLocation($values){
        $values['is_show'] = AppHelper::valueSwitch(isset($values['is_show']) ? $values['is_show'] : null);
        $branchId = $values['branch_id'];
        try {
            DB::beginTransaction();
            $smallCar = $this->smallCarLocationRepository->create($values);
            if(isset($smallCar) && isset($smallCar->id)){
                $this->insertSmallCarProductMaterial($values,$smallCar->id);
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }

    public function updateSmallCarLocation($values){
        $values['is_show'] = AppHelper::valueSwitch(isset($values['is_show']) ? $values['is_show'] : null);
        $branchId = $values['branch_id'];
        try {
            DB::beginTransaction();
            $smallCar = $this->smallCarLocationRepository->find($values['id']);
            if(isset($smallCar)){
                $smallCar->car_name = $values['car_name'];
                $smallCar->is_show = $values['is_show'];
                $smallCar->address = $values['address'];
                $this->smallCarLocationRepository->updateModel($smallCar);

                $smallCar->deleteRelation();
                $this->insertSmallCarProductMaterial($values,$smallCar->id);
            }
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }

    private function insertSmallCarProductMaterial($values, $smallCarLocationId){
        $smallCarProducts = [];
        $smallCarMaterials = [];
        foreach ($values as $key => $value){
            if(isset($value)){
                if(preg_match_all('/^qty_\D+_vegetables_\d/',$key) > 0){
                    $matches = [];
                    preg_match_all('/[A-Za-z]+\_|[0-9]/',$key,$matches);
                    $productId = $matches[0][3];
                    preg_match_all('/^qty_\D+_vegetables/',$key,$matches);
                    $columnName = $matches[0][0];
                    $smallCarProducts[$productId][$columnName] = $value;
                    $smallCarProducts[$productId]['product_id'] = $productId;
                    $smallCarProducts[$productId]['small_car_location_id'] = $smallCarLocationId;
                }
                if(preg_match_all('/^qty_\d/',$key,$matchValueQtyHaveVegetables) > 0){
                    $matches = [];
                    preg_match_all('/[0-9]+/',$key,$matches);
                    $materialId = $matches[0][0];
                    $smallCarMaterials[$materialId]['qty'] = $value;
                    $smallCarMaterials[$materialId]['material_id'] = $materialId;
                    $smallCarMaterials[$materialId]['small_car_location_id'] = $smallCarLocationId;
                }
            }
        }
        foreach ($smallCarProducts as $productId => $itemValues){
            $this->smallCarProductRepository->create($itemValues);
        }
        foreach ($smallCarMaterials as $materialId => $itemValues){
            $this->smallCarMaterialRepository->create($itemValues);
        }
        if(isset($values['check_week'])){
            $weeks = $values['check_week'];
            foreach ($weeks as $week){
                $this->smallCarLocationOfDayRepository->create([
                    'small_car_location_id' => $smallCarLocationId,
                    'week_no' => $week
                ]);
            }
        }
    }

    public function deleteSmallCarLocation($id){
        try {
            DB::beginTransaction();
            $smallCar = $this->smallCarLocationRepository->find($id);
            if(isset($smallCar)){
                $smallCar->deleteRelation();
            }
            $smallCar->delete();
            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            dd($exception);
        }
    }

}
