<?php

namespace App\Repositories\Eloquents;

use App\Models\Material;
use App\Models\SmallCarLocation;
use App\Models\SmallCarProduct;
use App\Models\SmallCartMaterial;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SmallCarMaterialRepository extends BaseRepository
{
    public function __construct(SmallCartMaterial $model)
    {
        $this->model = $model;
    }

    public function getSmallCarMaterial($branchId){
        $tableMaterialName = Material::getTableName();
        $tableSmallCarMaterialName = SmallCartMaterial::getTableName();
        $tableSmallCarLocation = SmallCarLocation::getTableName();
        $materialIds = [Material::MATERIAL_PEPSI_ID, Material::MATERIAL_COCOA_ID, Material::MATERIAL_MILK_TEA];
        return Material::leftjoin("$tableSmallCarMaterialName", "$tableSmallCarMaterialName.material_id","$tableMaterialName.id")
            ->leftjoin("$tableSmallCarLocation",function($join) use($branchId,$tableSmallCarLocation,$tableSmallCarMaterialName){
                $join->on("$tableSmallCarLocation.id","$tableSmallCarMaterialName.small_car_location_id")
                    ->where("$tableSmallCarLocation.branch_id",$branchId);
            })
            ->whereIn("$tableMaterialName.id",$materialIds)
            ->select("$tableMaterialName.*","$tableSmallCarMaterialName.qty")
            ->get();
    }

}
