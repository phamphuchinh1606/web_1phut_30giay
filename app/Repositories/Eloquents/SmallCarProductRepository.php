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

    public function getSmallCarProduct($branchId, $smallCarLocationId){
        $tableProductName = Product::getTableName();
        $tableSmallCarProductName = SmallCarProduct::getTableName();
        $tableSmallCarLocation = SmallCarLocation::getTableName();
        return Product::leftjoin("$tableSmallCarProductName", "$tableSmallCarProductName.product_id","$tableProductName.id")
            ->leftjoin("$tableSmallCarLocation",function($join) use($branchId,$smallCarLocationId,$tableSmallCarLocation,$tableSmallCarProductName){
                $join->on("$tableSmallCarLocation.id","$tableSmallCarProductName.small_car_location_id")
                    ->where("$tableSmallCarLocation.branch_id",$branchId)
                    ->where("$tableSmallCarLocation.id",$smallCarLocationId);
            })
            ->select("$tableProductName.*",
                "$tableSmallCarProductName.qty_no_vegetables",
                "$tableSmallCarProductName.qty_have_vegetables",
                DB::raw("($tableSmallCarProductName.qty_no_vegetables + $tableSmallCarProductName.qty_have_vegetables) as total_qty"))
            ->get();
    }

}
