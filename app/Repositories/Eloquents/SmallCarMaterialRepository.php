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
    public function __construct(SmallCarProduct $model)
    {
        $this->model = $model;
    }

    public function getSmallCarMaterial($branchId){
        $tableMaterialName = Material::getTableName();
        $tableSmallCarMaterialName = SmallCartMaterial::getTableName();
        $tableSmallCarLocation = SmallCarLocation::getTableName();
//        return Material::leftjoin("$tableSmallCarProductName", "$tableSmallCarProductName.product_id","$tableProductName.id")
//            ->leftjoin("$tableSmallCarLocation",function($join) use($branchId,$tableSmallCarLocation,$tableSmallCarProductName){
//                $join->on("$tableSmallCarLocation.id","$tableSmallCarProductName.small_car_location_id")
//                    ->where("$tableSmallCarLocation.branch_id",$branchId);
//            })
//            ->select("$tableProductName.*","$tableSmallCarProductName.qty_no_vegetables","$tableSmallCarProductName.qty_have_vegetables")->get();
    }

}
