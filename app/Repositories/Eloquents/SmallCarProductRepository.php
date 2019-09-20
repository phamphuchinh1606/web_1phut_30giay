<?php

namespace App\Repositories\Eloquents;

use App\Models\Product;
use App\Models\SmallCarLocation;
use App\Models\SmallCarProduct;
use App\Repositories\Base\BaseRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class SmallCarProductRepository extends BaseRepository
{
    public function __construct(SmallCarProduct $model)
    {
        $this->model = $model;
    }

    public function getSmallCarProduct($branchId, $smallCarLocationId = null){
        $tableProductName = Product::getTableName();
        $tableSmallCarProductName = SmallCarProduct::getTableName();
        $tableSmallCarLocation = SmallCarLocation::getTableName();
        $subTable = $this->model::join("$tableSmallCarLocation","$tableSmallCarLocation.id","$tableSmallCarProductName.small_car_location_id")
                ->where("$tableSmallCarLocation.branch_id",$branchId)
                ->where("$tableSmallCarLocation.id",$smallCarLocationId)
                ->select(
                    "$tableSmallCarProductName.product_id",
                    "$tableSmallCarProductName.qty_no_vegetables",
                    "$tableSmallCarProductName.qty_have_vegetables",
                    DB::raw("(IFNULL($tableSmallCarProductName.qty_no_vegetables,0) + IFNULL($tableSmallCarProductName.qty_have_vegetables,0)) as total_qty"));
        $subTableName = "subTable";
        return Product::leftjoinSub($subTable,"$subTableName",function($join) use ($subTableName,$tableProductName){
                $join->on("$subTableName.product_id","$tableProductName.id");
            })
            ->select("$tableProductName.*",
                "$subTableName.qty_no_vegetables",
                "$subTableName.qty_have_vegetables",
                "$subTableName.total_qty")
            ->orderBy("$tableProductName.id")
            ->get();
    }

}
