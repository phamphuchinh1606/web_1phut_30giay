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

    public function getSmallCarMaterial($branchId,$smallCarLocationId = null){
        $tableMaterialName = Material::getTableName();
        $tableSmallCarMaterialName = SmallCartMaterial::getTableName();
        $tableSmallCarLocation = SmallCarLocation::getTableName();
        $materialIds = [Material::MATERIAL_PEPSI_ID, Material::MATERIAL_COCOA_ID, Material::MATERIAL_MILK_TEA];

        $subTable = $this->model::join("$tableSmallCarLocation","$tableSmallCarLocation.id","$tableSmallCarMaterialName.small_car_location_id")
            ->where("$tableSmallCarLocation.branch_id",$branchId)
            ->where("$tableSmallCarLocation.id",$smallCarLocationId)
            ->select(
                "$tableSmallCarMaterialName.material_id",
                "$tableSmallCarMaterialName.qty");
        $subTableName = "subTable";


        return Material::leftjoinSub($subTable,"$subTableName",function($join) use ($subTableName,$tableMaterialName){
                $join->on("$subTableName.material_id","$tableMaterialName.id");
            })
            ->whereIn("$tableMaterialName.id",$materialIds)
            ->select("$tableMaterialName.*","$subTableName.qty")
            ->get();
    }

}
